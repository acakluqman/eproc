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
INSERT INTO `jenis_tender` VALUES (1,'Pengadaan Barang'),(2,'Pekerjaan Konstruksi');
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
  KEY `tender_FK_2` (`id_satker`),
  KEY `tender_FK_3` (`id_status`),
  CONSTRAINT `tender_FK` FOREIGN KEY (`id_user_setuju`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_tender` (`id_jenis`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_2` FOREIGN KEY (`id_satker`) REFERENCES `satker` (`id_satker`) ON UPDATE CASCADE,
  CONSTRAINT `tender_FK_3` FOREIGN KEY (`id_status`) REFERENCES `status_tender` (`id_status`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tender`
--

LOCK TABLES `tender` WRITE;
/*!40000 ALTER TABLE `tender` DISABLE KEYS */;
INSERT INTO `tender` VALUES (1678871376,'Pengadaan Peralatan Elektronik Pendukung Praktikum di Prodi Teknologi Kedokteran','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',14,474066966,468827059,1,'2023-06-15 15:51:09',2,'2023-03-16 09:50:10',1,'ok',NULL,NULL,'2023-03-15 15:51:27'),(1678871394,'Pengadaan Artificial Intelligence Supercomputer – NVIDIA DGX A100','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',8,4180000000,4171928750,1,'2023-05-15 15:58:58',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 15:59:09'),(1678871408,'Pengadaan Lisensi Software Microsoft','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.',16,1280000000,1127000000,1,'2023-04-15 16:00:23',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 16:00:35'),(1678871417,'Renovasi Atap Gedung A Dan B Fakultas Ilmu Sosial dan Politik','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',12,1217385000,1207700000,2,'2023-07-15 16:02:32',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 16:02:43'),(1678871422,'Pekerjaan Interior Dan Mebelair Custom Lantai 2,3, 5–10 (8 Lantai) Gedung FMIPA (Tower 1) Tahap 1 (Lantai 6,7, 8)','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.',13,1645000000,1634000000,2,'2023-10-15 16:04:20',1,NULL,NULL,NULL,NULL,NULL,'2023-03-15 16:04:30');
/*!40000 ALTER TABLE `tender` ENABLE KEYS */;
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
INSERT INTO `tender_peserta` VALUES (1678871376,1,345754853,345754853,NULL,NULL,NULL,NULL,NULL,1,NULL,'2023-03-15 16:45:37'),(1678871376,2,345754853,345754853,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:15'),(1678871394,3,345754853,345754853,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:18'),(1678871394,4,345754853,345754853,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:20'),(1678871408,2,345754853,345754853,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-03-16 08:09:22');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin Luqman','admin@gmail.com','$2y$10$WWDXTl2a/dgkz9fBYVUen.qy1hRlkyEMB1uTaqU73K30aJWr6lQRm',1,NULL,'2023-03-14 13:12:17'),(2,'Petugas Luqman','petugas@gmail.com','$2y$10$5fvZn/H7HJgZIm40So27QeTSbyEiGT0i6yRb.SsY0hfN05ctzL9m.',2,NULL,'2023-03-14 13:13:01'),(3,'Vendor Luqman','vendor@gmail.com','$2y$10$/lPj9tHB6hsuvm0Z5kIUO.1AnzbCKenv7J3a9535gikgUAZAqthOK',3,NULL,'2023-03-14 13:13:01'),(4,'PT. Telkomsel','rifite8133@necktai.com','$2y$10$zSdNyETmqW6ykjI/RZoq1epEXCezIgWII3VndtFT.WmO5MpZl2CqW',3,NULL,'2023-03-16 13:55:00'),(5,'Nama Vendor 3','yarihol766@loongwin.com','$2y$10$DKc3Hg7FPsUG5F4STxUwnOk5moYyrlINDdthkaHIzp78Yk16dCSES',3,NULL,'2023-03-16 13:57:10');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'PT. ERDEKA BERKAH MANDIRI','Jl. Pahlawan No. 1 Parakan Temanggung','02.615.979.8-023.000','Faridah Iqbal','C4HfuEEBx2.jpg','Faridah Iqbal','3524074706640005','AAx7VTNH5R.jpg','0469/1.824.51','G8ENyDHcNG.jpg','9120000792674','PEM-02550/WPJ.06/KP.0603/2012','G8ENyDs35HcNG.jpg'),(2,'CV. PUTRA JATI MANDIRI','Jl. R.A. Kartini Kp. Bekasi Jati No. 79 RT. 005 RW. 026 Kel. Margahayu Kec. Bekasi Timur','81.377.390.0-407.000','Luqman Hakim','C4HfuEEBx2.jpg','Luqman Hakim','3524069706640005','AAx7VTNH5R.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730792674','PEM-02730/WPJ.06/KP.0603/2012','G8ENyDs35HcNG.jpg'),(3,'CV. CITRA MANUNGGAL','Jl. Bungur GG Tugu No.72 RT.03 RW.11','81.377.865.4-863.000','Denny Kusuma','C4HfuEEBx2.jpg','Denny Kusuma','3524068639640005','AAx7VTNH5R.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730798574','PEM-02730/HFT.06/KP.0603/2012','G8ENyDs35HcNG.jpg'),(4,'CV. INVOTECH','Jl. Purnama Komplek Dinasti Indah Blok B.15 RT.003/RW.008, Kel. Parittokaya Kec. Pontianak Selatan','81.874.865.4-863.000','Mala Puspita','C4HfuEEBx2.jpg','Mala Puspita','4485357198310351','AAx7VTNH5R.jpg','0764/1.824.51','G8ENyDHcNG.jpg','9120760774574','HGT-87535/HJT.06/KP.0603/2012','G8ENyDs35HcNG.jpg'),(5,'CV. MARINA LESTARI','Jl. Sijawangkati No. 21 Kel. Lamangga Kec. Murhum','81.377.865.0-407.000','Prasetyo Gunawan','C4HfuEEBx2.jpg','Prasetyo Gunawan','3585669779640005','AAx7VTNH5R.jpg','0739/1.824.51','G8ENyDHcNG.jpg','9120730872674','PEM-02730/KHE.06/KP.0603/2012','G8ENyDs35HcNG.jpg'),(13,'PT. Maju Jaya','Jl. Surabaya','81.874.875.4-863.000','Muhammad Yunus','upload\\6412d205c204a.png','Muhammad Yunus','3524071004950003','upload\\6412d205c2047.png','436676857','upload\\6412d205c204b.png','4985685456546',NULL,NULL);
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

-- Dump completed on 2023-03-17 14:27:02
