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
-- Table structure for table `jenis_tender`
--

DROP TABLE IF EXISTS `jenis_tender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_tender` (
  `id_jenis_tender` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis_tender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_tender`
--

LOCK TABLES `jenis_tender` WRITE;
/*!40000 ALTER TABLE `jenis_tender` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_tender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satker`
--

DROP TABLE IF EXISTS `satker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satker` (
  `id_satker` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_induk_satker` bigint unsigned NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_satker`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satker`
--

LOCK TABLES `satker` WRITE;
/*!40000 ALTER TABLE `satker` DISABLE KEYS */;
INSERT INTO `satker` VALUES (1,0,'Universitas Wijaya Kusuma'),(2,1,'Lembaga Penelitian dan Pengabdian Masyarakat'),(3,1,'Badan Perencanaan dan Pengembangan Pendidikan'),(4,1,'Badan Penjamin Mutu'),(5,1,'Biro Administrasi Keuangan'),(6,1,'Biro Administrasi Akademik'),(7,1,'Biro Administrasi Kemahasiswaan dan Humas'),(8,1,'Fakultas Teknik'),(9,1,'Fakultas Pertanian'),(10,1,'Fakultas Hukum'),(11,1,'Fakultas Ekonomi dan Bisnis'),(12,1,'Fakultas Ilmu Sosial dan Politik'),(13,1,'Fakultas Bahasa dan Sains'),(14,1,'Fakultas Kedokteran'),(15,1,'Fakultas Kedokteran Hewan'),(16,1,'UPT TIK'),(17,1,'UPT MKU'),(18,1,'Biro Administrasi Umum');
/*!40000 ALTER TABLE `satker` ENABLE KEYS */;
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
  `nilai_pagu` decimal(10,3) NOT NULL,
  `nilai_hps` decimal(10,3) NOT NULL,
  `id_jenis_tender` bigint unsigned NOT NULL,
  `tgl_akhir_daftar` datetime NOT NULL,
  `is_setuju` tinyint(1) DEFAULT NULL,
  `tgl_setuju` datetime DEFAULT NULL,
  `id_user_setuju` bigint unsigned DEFAULT NULL,
  `catatan_persetujuan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` bigint unsigned NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_buat` datetime NOT NULL,
  PRIMARY KEY (`id_tender`),
  KEY `tender_FK` (`id_user_setuju`),
  KEY `tender_FK_1` (`id_jenis_tender`),
  KEY `tender_FK_2` (`id_satker`),
  CONSTRAINT `tender_FK` FOREIGN KEY (`id_user_setuju`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_1` FOREIGN KEY (`id_jenis_tender`) REFERENCES `jenis_tender` (`id_jenis_tender`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_2` FOREIGN KEY (`id_satker`) REFERENCES `satker` (`id_satker`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender`
--

LOCK TABLES `tender` WRITE;
/*!40000 ALTER TABLE `tender` DISABLE KEYS */;
/*!40000 ALTER TABLE `tender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tender_peserta`
--

DROP TABLE IF EXISTS `tender_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tender_peserta` (
  `⁯id_tender` bigint unsigned NOT NULL,
  `id_vendor` bigint unsigned NOT NULL,
  `harga_penawaran` double(10,3) NOT NULL,
  `harga_koreksi` decimal(10,3) DEFAULT NULL,
  `is_kualifikasi` tinyint(1) DEFAULT NULL,
  `is_bukti_kualifikasi` tinyint(1) DEFAULT NULL,
  `is_eval_harga` tinyint(1) NOT NULL DEFAULT '0',
  `is_eval_administrasi` tinyint(1) DEFAULT NULL,
  `is_eval_teknis` tinyint(1) DEFAULT NULL,
  `is_pemenang` tinyint(1) NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_daftar` datetime NOT NULL,
  KEY `tender_peserta_FK` (`id_vendor`),
  KEY `tender_peserta_FK_1` (`⁯id_tender`),
  CONSTRAINT `tender_peserta_FK` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tender_peserta_FK_1` FOREIGN KEY (`⁯id_tender`) REFERENCES `tender` (`id_tender`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender_peserta`
--

LOCK TABLES `tender_peserta` WRITE;
/*!40000 ALTER TABLE `tender_peserta` DISABLE KEYS */;
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
  `tgl_daftar` datetime NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_UN` (`email`),
  KEY `user_FK` (`id_vendor`),
  CONSTRAINT `user_FK` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin Luqman','admin@gmail.com','$2y$10$WWDXTl2a/dgkz9fBYVUen.qy1hRlkyEMB1uTaqU73K30aJWr6lQRm',1,NULL,'2023-03-14 13:12:17'),(2,'Petugas Luqman','petugas@gmail.com','$2y$10$5fvZn/H7HJgZIm40So27QeTSbyEiGT0i6yRb.SsY0hfN05ctzL9m.',2,NULL,'2023-03-14 13:13:01'),(3,'Vendor Luqman','vendor@gmail.com','$2y$10$/lPj9tHB6hsuvm0Z5kIUO.1AnzbCKenv7J3a9535gikgUAZAqthOK',3,1,'2023-03-14 13:13:01');
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
  `npwp` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_npwp` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_npwp_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pemilik` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pemilik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_ktp_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_siup` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_siup_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_nib` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_sppkp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_sppkp_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_vendor`),
  UNIQUE KEY `vendor_UN` (`npwp`),
  UNIQUE KEY `vendor_nik_unique` (`nik_pemilik`),
  UNIQUE KEY `vendor_nib_unique` (`no_nib`),
  UNIQUE KEY `vendor_sppkp_unique` (`no_sppkp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'PT. ERDEKA BERKAH MANDIRI','Jl. Pahlawan No. 1 Parakan Temanggung','02.615.979.8-023.000','Faridah Iqbal','C4HfuEEBx2.jpg','Faridah Iqbal','3524074706640005','AAx7VTNH5R.jpg','0469/1.824.51','G8ENyDHcNG.jpg','9120000792674','PEM-02550/WPJ.06/KP.0603/2012','G8ENyDs35HcNG.jpg');
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

-- Dump completed on 2023-03-15  8:31:46
