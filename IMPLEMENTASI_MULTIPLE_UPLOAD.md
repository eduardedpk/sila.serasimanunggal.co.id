# Implementasi Multiple File Upload untuk Laporan KPI Non CS

## 1. Setup Database

Jalankan SQL berikut untuk membuat tabel baru:

```sql
-- Table to store multiple files for each KPI report
CREATE TABLE `laporan_kpi_files` (
  `FileNID` bigint(20) NOT NULL AUTO_INCREMENT,
  `LaporanNID` bigint(20) NOT NULL,
  `File_Name` varchar(255) NOT NULL,
  `File_Original_Name` varchar(255) NOT NULL,
  `File_Type` varchar(50) NOT NULL,
  `File_Size` bigint(20) NOT NULL,
  `Upload_Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Uploaded_By` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`FileNID`),
  KEY `LaporanNID` (`LaporanNID`),
  KEY `Uploaded_By` (`Uploaded_By`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
```

File SQL ini tersedia di: `files/sql_laporan_kpi_files.sql`

## 2. Buat Folder untuk Upload

Pastikan folder utama berikut ada dan memiliki permission write (755):

```
files/laporan_kpi/
```

Subfolder berdasarkan periode (format YYYYMM) akan dibuat otomatis saat upload pertama kali.

Contoh struktur folder:
```
files/laporan_kpi/
├── 202501/  (Januari 2025)
├── 202502/  (Februari 2025)
├── 202508/  (Agustus 2025)
└── 202512/  (Desember 2025)
```

Buat folder utama secara manual atau folder akan dibuat otomatis saat upload pertama kali.

## 3. Fitur yang Sudah Diimplementasikan

### A. Multiple File Upload
- User dapat menambah lebih dari 1 file dengan klik tombol "Tambah File"
- Maksimal 10 file dapat di-upload per laporan
- Setiap file input dapat dihapus dengan tombol X (merah)

### B. Validasi File (Client-Side)
- Ekstensi yang diperbolehkan: `.pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .jpg, .jpeg, .png, .gif`
- Ukuran maksimal: 5MB per file
- File berbahaya otomatis ditolak: `.php, .exe, .sh, .bat, .cmd, .com, .pif, .scr, .vbs, .js`

### C. Validasi & Sanitasi File (Server-Side)
- **Fungsi `sanitize_filename()`**: Membersihkan nama file dari karakter berbahaya
- **Fungsi `validate_file_type()`**: Validasi ekstensi dan MIME type
- Cek double extension (contoh: `file.php.jpg`)
- Verifikasi MIME type untuk gambar
- Generate nama file unik untuk menghindari conflict

### D. Keamanan
- Nama file di-sanitasi (remove special characters)
- Cek MIME type untuk file gambar
- Block file dengan ekstensi berbahaya
- Block file dengan double extension
- Validasi ukuran file
- Generate unique filename dengan timestamp dan random number

### E. Display & Management
- Saat edit, file yang sudah di-upload ditampilkan dalam list
- Setiap file dapat dihapus secara individual
- File dapat di-download dengan klik nama file
- Ukuran file ditampilkan dalam KB

## 4. Cara Penggunaan

### Tambah Laporan Baru
1. Pilih Periode dan Indikator
2. Isi Lokasi (optional)
3. Klik "Browse" untuk pilih file pertama
4. Klik tombol "Tambah File" untuk menambah file lagi
5. Pilih file-file yang ingin di-upload
6. Klik "Simpan"

### Edit Laporan
1. Buka laporan yang ingin di-edit
2. File yang sudah di-upload akan muncul di bagian bawah form
3. Untuk menghapus file, klik tombol merah (trash icon)
4. Untuk menambah file baru, gunakan file input seperti biasa
5. Klik "Simpan"

## 5. File Types yang Diperbolehkan

### Dokumen
- PDF: `.pdf`
- Microsoft Word: `.doc`, `.docx`
- Microsoft Excel: `.xls`, `.xlsx`
- Microsoft PowerPoint: `.ppt`, `.pptx`

### Gambar
- JPEG: `.jpg`, `.jpeg`
- PNG: `.png`
- GIF: `.gif`

## 6. Batasan

- Maksimal 10 file per form submission
- Maksimal 5MB per file
- Hanya file dengan ekstensi yang diperbolehkan yang bisa di-upload
- File berbahaya (executable, script) otomatis ditolak

## 7. Error Handling

### Client-Side
- Validasi dilakukan sebelum form di-submit
- Alert akan muncul jika ada file yang tidak valid
- Form tidak akan ter-submit jika ada error

### Server-Side
- Setiap file divalidasi sebelum di-upload
- File yang tidak valid akan di-skip
- Pesan error akan ditampilkan untuk file yang gagal
- Laporan tetap tersimpan meskipun ada file yang gagal di-upload

## 8. Struktur File Upload

File akan disimpan dalam subfolder berdasarkan periode dengan format:
```
files/laporan_kpi/YYYYMM/nama_file_1234567890_5678.ext
```

Contoh:
- Periode: Agustus 2025 (2025-08)
- Folder: `files/laporan_kpi/202508/`
- File: `Dokumen_Laporan_1234567890_5678.pdf`
- Full path: `files/laporan_kpi/202508/Dokumen_Laporan_1234567890_5678.pdf`

Format nama file:
- `nama_file`: Nama file original yang sudah di-sanitasi
- `1234567890`: Unix timestamp
- `5678`: Random number 4 digit
- `ext`: Ekstensi file original

Keuntungan struktur folder per periode:
- File terorganisir berdasarkan bulan/tahun
- Memudahkan backup per periode
- Memudahkan cleanup file lama
- Menghindari terlalu banyak file dalam satu folder

## 9. Testing Checklist

- [ ] Upload file PDF
- [ ] Upload file Word (.doc dan .docx)
- [ ] Upload file Excel (.xls dan .xlsx)
- [ ] Upload file PowerPoint (.ppt dan .pptx)
- [ ] Upload gambar (.jpg, .png, .gif)
- [ ] Upload multiple files sekaligus
- [ ] Coba upload file > 5MB (harus ditolak)
- [ ] Coba upload file .php (harus ditolak)
- [ ] Coba upload file dengan nama aneh (special characters)
- [ ] Edit laporan dan tambah file baru
- [ ] Hapus file dari laporan
- [ ] Download file yang sudah di-upload

## 10. Troubleshooting

### File tidak ter-upload
- Cek permission folder `files/laporan_kpi/` (harus 755)
- Cek `upload_max_filesize` dan `post_max_size` di php.ini
- Cek error log PHP

### File ditolak padahal ekstensi benar
- Pastikan file tidak memiliki double extension
- Untuk gambar, pastikan MIME type sesuai (bukan file renamed)

### Alert "file tidak diperbolehkan"
- File memiliki ekstensi yang tidak ada dalam whitelist
- File memiliki double extension dengan ekstensi berbahaya
- MIME type tidak sesuai (untuk gambar)

## 11. Maintenance

### Bersihkan File Orphan
Jika ada laporan yang dihapus, file-nya perlu dihapus manual atau buat script cleanup:

```sql
-- Cari file yang laporannya sudah dihapus
SELECT * FROM laporan_kpi_files lkf
LEFT JOIN laporan_non_cs lnc ON lkf.LaporanNID = lnc.LaporanNID
WHERE lnc.LaporanNID IS NULL;
```

### Backup Files
Pastikan folder `files/laporan_kpi/` ter-backup secara regular.
