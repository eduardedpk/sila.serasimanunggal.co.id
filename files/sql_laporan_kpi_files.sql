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
