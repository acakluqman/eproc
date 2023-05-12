-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: eproc
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jenis_dok`
--

DROP TABLE IF EXISTS `jenis_dok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_dok` (
  `id_jns_dok` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jns_dok` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `ekstensi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_jns_dok`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_dok`
--

LOCK TABLES `jenis_dok` WRITE;
/*!40000 ALTER TABLE `jenis_dok` DISABLE KEYS */;
INSERT INTO `jenis_dok` VALUES (0,'Lainnya',NULL),(1,'NPWP','image/png, image/jpg, image/jpeg, application/pdf'),(2,'Sertifikat Badan Usaha (SBU) ','image/png, image/jpg, image/jpeg, application/pdf'),(3,'Akta Pendirian Perusahaan ','image/png, image/jpg, image/jpeg, application/pdf');
/*!40000 ALTER TABLE `jenis_dok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_tender`
--

DROP TABLE IF EXISTS `jenis_tender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_tender` (
  `id_jenis` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_tender`
--

LOCK TABLES `jenis_tender` WRITE;
/*!40000 ALTER TABLE `jenis_tender` DISABLE KEYS */;
INSERT INTO `jenis_tender` VALUES (1,'Pengadaan Barang'),(2,'Pengadaan Jasa');
/*!40000 ALTER TABLE `jenis_tender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password` (
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_reset` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
INSERT INTO `reset_password` VALUES ('admin@gmail.com','hva5jJTEvoPhZGTKdKjFkdPQBYJcTDmjr5y6IjxnLSHfevT3u6','2023-05-10 13:03:57'),('admin@gmail.com','QrF1JKTBugfY5NGrMo49jbvEQacbh88QMkacHLq3wSht4lYs7t','2023-05-10 13:05:18'),('admin@gmail.com','X3rBkPdajUzjXlYgOdp3F2ivBOUoBjvQOoyIkb0STofXnAS5BH','2023-05-10 13:05:25'),('admin@gmail.com','hCBTmNvt1eiX0tWVowhHR42TsGnxT5mA3OidePwwCzS4ikPrtG','2023-05-10 13:06:16'),('admin@gmail.com','Lik2ADBAHOzpA3tmahmV1xFVJIKXaaUeY4cCToI30jSLHvdXzb','2023-05-10 13:10:50'),('admin@gmail.com','go1kLybutVPPADT19D5PMkHK7TnFuIma81O3vmyEe47iAtBdpA','2023-05-10 13:11:25'),('admin@gmail.com','DQrkvfkV6fIRcrFLBmxUx2aUcZVSZeV1S1U8vnZreXx1Z20Yq1','2023-05-10 13:13:43'),('admin@gmail.com','Mk2zmNdcFyGu4kFLZFb5XbRLaokT7Wp4fmHsHYW47e8HThNsbb','2023-05-10 13:23:01'),('admin@gmail.com','ejUjNziq7B5cdItRJUxidL8WA8lUGBN59AkVMzwgsdz9maJNre','2023-05-10 13:23:25'),('admin@gmail.com','UVuZPvE2RJq4srbrgPFrilPHMbPueAplgfLEQvRZVyO6yP05BC','2023-05-10 13:30:35'),('admin@gmail.com','y0Qo8zSV4aygQq5iHquLJpq0YmiZ9sP37ZMg4bDtu1IXxl9hdh','2023-05-10 13:32:07'),('admin@gmail.com','513oBxyUA5EH8dW8LXfMs0wnrhmjJH8xc6RALd7iXw2K2D2fr0','2023-05-10 13:33:24'),('admin@gmail.com','wJD3cJ3uhJWQ9mxXcgNiVuIg9ObcRJSkDu8L5tMdwlC4gDHSbz','2023-05-10 13:33:51'),('admin@gmail.com','wnkez1X0cBVzD0ChIpJcwfGnTllwleqVRGeBEkmwDZpJtxAgrd','2023-05-10 13:34:27'),('admin@gmail.com','lmZq4LX2tV8Asq11ZLIoIm941rtamj1vHWK11HdhIMhnNhxkhU','2023-05-10 15:26:16'),('admin@gmail.com','rQ4FXya8RMzfz112kUsPCRdwlvkXZEGnfdjSsWlyC9gf5DI5CI','2023-05-10 15:28:09');
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satker`
--

DROP TABLE IF EXISTS `satker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satker` (
  `id_satker` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_satker`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satker`
--

LOCK TABLES `satker` WRITE;
/*!40000 ALTER TABLE `satker` DISABLE KEYS */;
INSERT INTO `satker` VALUES (1,'Universitas Wijaya Kusuma'),(2,'Lembaga Penelitian dan Pengabdian Masyarakat'),(3,'Badan Perencanaan dan Pengembangan Pendidikan'),(4,'Badan Penjamin Mutu'),(5,'Biro Administrasi Keuangan'),(6,'Biro Administrasi Akademik'),(7,'Biro Administrasi Kemahasiswaan dan Humas'),(8,'Fakultas Teknik'),(9,'Fakultas Pertanian'),(10,'Fakultas Hukum'),(11,'Fakultas Ekonomi dan Bisnis'),(14,'Fakultas Kedokteran'),(15,'Fakultas Kedokteran Hewan'),(16,'UPT TIK'),(17,'UPT MKU'),(18,'Biro Administrasi Umum');
/*!40000 ALTER TABLE `satker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_tender`
--

DROP TABLE IF EXISTS `status_tender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_tender` (
  `id_status` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_tender`
--

LOCK TABLES `status_tender` WRITE;
/*!40000 ALTER TABLE `status_tender` DISABLE KEYS */;
INSERT INTO `status_tender` VALUES (1,'Diajukan'),(2,'Disetujui'),(3,'Ditolak');
/*!40000 ALTER TABLE `status_tender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tender`
--

DROP TABLE IF EXISTS `tender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tender` (
  `id_tender` bigint unsigned NOT NULL,
  `judul` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_satker` bigint unsigned NOT NULL,
  `nilai_pagu` bigint unsigned NOT NULL,
  `nilai_hps` bigint unsigned NOT NULL,
  `id_jenis` bigint unsigned NOT NULL,
  `tgl_akhir_daftar` datetime NOT NULL,
  `id_status` bigint unsigned NOT NULL,
  `tgl_setuju` datetime DEFAULT NULL,
  `id_user_setuju` bigint unsigned DEFAULT NULL,
  `catatan_persetujuan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kualifikasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tgl_buat` datetime NOT NULL,
  PRIMARY KEY (`id_tender`),
  KEY `tender_FK` (`id_user_setuju`),
  KEY `tender_FK_1` (`id_jenis`),
  KEY `tender_FK_3` (`id_status`),
  KEY `tender_FK_2` (`id_satker`),
  CONSTRAINT `tender_FK` FOREIGN KEY (`id_user_setuju`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_tender` (`id_jenis`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_2` FOREIGN KEY (`id_satker`) REFERENCES `satker` (`id_satker`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_3` FOREIGN KEY (`id_status`) REFERENCES `status_tender` (`id_status`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender`
--

LOCK TABLES `tender` WRITE;
/*!40000 ALTER TABLE `tender` DISABLE KEYS */;
INSERT INTO `tender` VALUES (1678871376,'Pengadaan Peralatan Elektronik Pendukung Praktikum di Prodi Teknologi Kedokteran','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',14,474066966,468827059,1,'2023-06-15 15:51:09',2,'2023-03-16 09:50:10',1,'ok',NULL,NULL,'2023-03-15 15:51:27'),(1678871394,'Pengadaan Artificial Intelligence Supercomputer – NVIDIA DGX A100','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',8,4180000000,4171928750,1,'2023-05-15 15:58:58',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 15:59:09'),(1678871408,'Pengadaan Lisensi Software Microsoft','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.',16,1280000000,1127000000,1,'2023-04-15 16:00:23',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 16:00:35');
/*!40000 ALTER TABLE `tender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tender_dokumen`
--

DROP TABLE IF EXISTS `tender_dokumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tender_dokumen` (
  `id_tender_dokumen` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_jenis_dok` bigint unsigned NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `tgl_unggah` datetime NOT NULL,
  PRIMARY KEY (`id_tender_dokumen`),
  KEY `tender_dokumen_jns_dok_fk` (`id_jenis_dok`),
  CONSTRAINT `tender_dokumen_jns_dok_fk` FOREIGN KEY (`id_jenis_dok`) REFERENCES `jenis_dok` (`id_jns_dok`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender_dokumen`
--

LOCK TABLES `tender_dokumen` WRITE;
/*!40000 ALTER TABLE `tender_dokumen` DISABLE KEYS */;
/*!40000 ALTER TABLE `tender_dokumen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tender_jadwal`
--

DROP TABLE IF EXISTS `tender_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tender_jadwal` (
  `id_tender_jadwal` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_tender` bigint unsigned NOT NULL,
  `tgl_kegiatan` datetime NOT NULL,
  `nama_kegiatan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_tender_jadwal`),
  KEY `tender_jadwal_tender_fk` (`id_tender`),
  CONSTRAINT `tender_jadwal_tender_fk` FOREIGN KEY (`id_tender`) REFERENCES `tender` (`id_tender`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender_jadwal`
--

LOCK TABLES `tender_jadwal` WRITE;
/*!40000 ALTER TABLE `tender_jadwal` DISABLE KEYS */;
/*!40000 ALTER TABLE `tender_jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tender_peserta`
--

DROP TABLE IF EXISTS `tender_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tender_peserta` (
  `id_tender` bigint unsigned NOT NULL,
  `id_vendor` bigint unsigned NOT NULL,
  `harga_penawaran` bigint unsigned NOT NULL,
  `harga_koreksi` bigint unsigned DEFAULT NULL,
  `is_kualifikasi` tinyint(1) DEFAULT NULL,
  `is_bukti_kualifikasi` tinyint(1) DEFAULT NULL,
  `is_eval_harga` tinyint(1) DEFAULT '0',
  `is_eval_administrasi` tinyint(1) DEFAULT NULL,
  `is_eval_teknis` tinyint(1) DEFAULT NULL,
  `is_pemenang` tinyint(1) DEFAULT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_daftar` datetime NOT NULL,
  KEY `tender_peserta_id_tender_IDX` (`id_tender`) USING BTREE,
  KEY `tender_peserta_id_vendor_IDX` (`id_vendor`) USING BTREE,
  CONSTRAINT `tender_peserta_id_tender` FOREIGN KEY (`id_tender`) REFERENCES `tender` (`id_tender`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tender_peserta_id_vendor` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender_peserta`
--

LOCK TABLES `tender_peserta` WRITE;
/*!40000 ALTER TABLE `tender_peserta` DISABLE KEYS */;
INSERT INTO `tender_peserta` VALUES (1678871376,1,345754853,345754853,NULL,NULL,NULL,NULL,NULL,1,NULL,'2023-03-15 16:45:37'),(1678871376,2,273171000,273171000,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:15'),(1678871394,3,345754853,345754853,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:18'),(1678871394,4,599815878,599815878,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:20'),(1678871408,2,267585521,267585521,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:22');
/*!40000 ALTER TABLE `tender_peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id_user` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_user` tinyint unsigned NOT NULL,
  `id_vendor` bigint unsigned DEFAULT NULL,
  `tgl_daftar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_UN` (`email`),
  KEY `user_FK` (`id_vendor`),
  CONSTRAINT `user_FK` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin Luqman','admin@gmail.com','$2y$10$PCzezqzs.DVJaNye9qV7gO9hkuy2dwIMGrs82IaQUkUkT0zSO0XGG',1,NULL,'2023-03-14 13:12:17'),(2,'Petugas Luqman','petugas@gmail.com','$2y$10$5fvZn/H7HJgZIm40So27QeTSbyEiGT0i6yRb.SsY0hfN05ctzL9m.',2,NULL,'2023-03-14 13:13:01'),(3,'Vendor Luqman','vendor@gmail.com','$2y$10$LgYolITE9DMafWw7hHNoLuf171i.H.U5dkw5M9E4iDZhGRdoaA6Oq',3,18,'2023-03-14 13:13:01'),(4,'Nadiyatul Adabiyyah','rifite8133@necktai.com','$2y$10$zSdNyETmqW6ykjI/RZoq1epEXCezIgWII3VndtFT.WmO5MpZl2CqW',3,2,'2023-03-16 13:55:00'),(5,'Nama Vendor 3','yarihol766@loongwin.com','$2y$10$DKc3Hg7FPsUG5F4STxUwnOk5moYyrlINDdthkaHIzp78Yk16dCSES',3,NULL,'2023-03-16 13:57:10'),(6,'Petugas Tes','tes@gmail.com','$2y$10$3Dz/9MO/1F6ZlbXNvhOJMebSw9u9C.1cv6AqlY6sgnU50QFsr3dIu',2,NULL,'2023-05-08 12:38:29'),(7,'Luqman Hakim','luqman@gmail.com','$2y$10$AkPiN3hY5mtTWf4LHDy..uUa/FoVrr4a6LDsbXUTlsJ31qMiEvvVi',3,NULL,'2023-05-11 10:37:17'),(8,'Luqman Hakim','luqmanhakem922@gmail.com','$2y$10$JapFHN6AuRvjOt0vYtkmCOReLePn..pGM6tU6sK5C3H1RONnGXzW6',3,NULL,'2023-05-11 10:37:54'),(9,'Luqman Hakim','hakim@gmail.com','$2y$10$djK4PO.RXMGOMLc09WkuIudmi9AZStmWTmBs2Ft5X4TXv1KrDmQm6',3,NULL,'2023-05-11 10:38:58'),(10,'Nadiyatul Adabiyyah','adabiyyah@gmail.com','$2y$10$9QiXGn7UgYYUpxuGmy/b3ulqaJCAqGYiiKx1bwT3yHKPPD75FwEla',3,NULL,'2023-05-11 10:39:59');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor` (
  `id_vendor` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pemilik` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pemilik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_ktp_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `npwp` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_npwp` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_npwp_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_siup` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_siup_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_nib` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_vendor`),
  UNIQUE KEY `vendor_UN` (`npwp`),
  UNIQUE KEY `vendor_nik_unique` (`nik_pemilik`),
  UNIQUE KEY `vendor_nib_unique` (`no_nib`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'PT. BERKAH MANDIRI PRATAMA','Jl. Kenjeran No. 573 Surabaya','Nathan Alzaydan','0494071004950161','upload\\641d1b38bbb01.webp','49.615.979.8-023.161','Nathan Alzaydan','upload\\641d1d4dc5068.png','0469/1.824.61','upload\\641d1d4dc532f.pdf','0490000792161'),(2,'CV. PUTRA JATI MANDIRI','Jl. R.A. Kartini Kp. Bekasi Jati No. 79 RT. 005 RW. 026 Kel. Margahayu Kec. Bekasi Timur','LUQMAN HAKIM','3524069706640005','upload\\641d1b38bbb01.webp','81.377.390.0-407.000','LUQMAN HAKIM','C4HfuEEBx2.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730792674'),(3,'CV. CITRA MANUNGGAL','Jl. Bungur GG Tugu No.72 RT.03 RW.11','Denny Kusuma','3524068639640005','AAx7VTNH5R.jpg','81.377.865.4-863.000','Denny Kusuma','C4HfuEEBx2.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730798574'),(4,'CV. INVOTECH','Jl. Purnama Komplek Dinasti Indah Blok B.15 RT.003/RW.008, Kel. Parittokaya Kec. Pontianak Selatan','Mala Puspita','4485357198310351','AAx7VTNH5R.jpg','81.874.865.4-863.000','Mala Puspita','C4HfuEEBx2.jpg','0764/1.824.51','G8ENyDHcNG.jpg','9120760774574'),(5,'CV. MARINA LESTARI','Jl. Sijawangkati No. 21 Kel. Lamangga Kec. Murhum','Prasetyo Gunawan','3585669779640005','AAx7VTNH5R.jpg','81.377.865.0-407.000','Prasetyo Gunawan','C4HfuEEBx2.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730872674'),(13,'PT. Maju Jaya','Jl. Surabaya','Muhammad Yunus','3524071004950003','upload\\6412d205c2047.png','81.874.875.4-863.000','Muhammad Yunus','upload\\6412d205c204a.png','436676857','upload\\6412d205c204b.png','4985685456546'),(16,'PT. Indo Sukses Abadi','Jl. Cibaduyut Nomor 13, Kb, Jeruk, Kec. Dawu, Kota Bandung, Jawa Barat 40818','Nana Lie','3524071004950895','upload\\641d237a01a9e.jpg','12.345.678.9-012.000.8546','Nana Lie','upload\\641d237a02033.jpg','544234879090737','upload\\641d237a0242d.pdf','940182057365829'),(17,'PT. calvindo global utama','Jl. Kenjeran No. 573 Surabaya','Sudiro','3524071004958762','upload\\641d24a233695.png','12.345.678.9-012.000','Sudiro','upload\\641d24a233a41.webp','546434879100326','upload\\641d24a233d59.pdf','948734072915376'),(18,'PT. arminareka','Jl. Pahlawan No. 1 Lamongan','Bryan Domani','3524071004869857','upload\\641d253556737.webp','12.345.755.9-012.043','Bryan Domani','upload\\641d253556a81.webp','078960563454236','upload\\641d253556ded.pdf','046475656765748');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'eproc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-11 16:15:47
