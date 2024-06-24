/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.4.11-MariaDB : Database - insentif
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`insentif` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `insentif`;

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `idbarang` char(10) NOT NULL,
  `namabarang` varchar(50) DEFAULT NULL,
  `jenis` enum('Makanan','Minuman') DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `hargajual` decimal(11,0) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  PRIMARY KEY (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `barang` */

/*Table structure for table `barang_insentif` */

DROP TABLE IF EXISTS `barang_insentif`;

CREATE TABLE `barang_insentif` (
  `idbarang_insentif` char(10) NOT NULL,
  `idbarang` char(10) DEFAULT NULL,
  `targetqty_awal` int(11) DEFAULT NULL,
  `targetqty_akhir` int(11) DEFAULT NULL,
  `bonus` decimal(18,0) DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `idkaryawan` char(10) DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  PRIMARY KEY (`idbarang_insentif`),
  KEY `idbarang` (`idbarang`),
  KEY `idkaryawan` (`idkaryawan`),
  CONSTRAINT `barang_insentif_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`),
  CONSTRAINT `barang_insentif_ibfk_2` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `barang_insentif` */

/*Table structure for table `insentif` */

DROP TABLE IF EXISTS `insentif`;

CREATE TABLE `insentif` (
  `idinsentif` char(10) NOT NULL,
  `target` decimal(11,0) DEFAULT NULL,
  `besarbonus` decimal(11,0) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `tginsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `idkaryawan` char(10) DEFAULT NULL,
  PRIMARY KEY (`idinsentif`),
  KEY `idkaryawan` (`idkaryawan`),
  CONSTRAINT `insentif_ibfk_1` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `insentif` */

insert  into `insentif`(`idinsentif`,`target`,`besarbonus`,`keterangan`,`statusaktif`,`tginsert`,`tglupdate`,`idkaryawan`) values ('INS-000001',1500000,50000,'target penjualan per hari','Aktif','2024-06-12 22:57:49','2024-06-12 22:57:49','0000000000');

/*Table structure for table `karyawan` */

DROP TABLE IF EXISTS `karyawan`;

CREATE TABLE `karyawan` (
  `idkaryawan` char(10) NOT NULL,
  `namakaryawan` varchar(30) DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempatlahir` varchar(30) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `notelp` varchar(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jabatan` enum('Canvasser','Supervisor') DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  PRIMARY KEY (`idkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `karyawan` */

insert  into `karyawan`(`idkaryawan`,`namakaryawan`,`jk`,`tempatlahir`,`tgllahir`,`notelp`,`email`,`alamat`,`jabatan`,`username`,`password`,`foto`,`statusaktif`) values ('0000000000','Supervisor','Laki-laki','Pontianak','1991-12-12','08123123163','supervisor@gmail.com','Pontianak','Supervisor','supervisor','09348c20a019be0318387c08df7a783d','supervisor.png','Aktif');

/*Table structure for table `konsumen` */

DROP TABLE IF EXISTS `konsumen`;

CREATE TABLE `konsumen` (
  `idkonsumen` char(10) NOT NULL,
  `namakonsumen` varchar(50) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  PRIMARY KEY (`idkonsumen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `konsumen` */

/*Table structure for table `mapping_insentif` */

DROP TABLE IF EXISTS `mapping_insentif`;

CREATE TABLE `mapping_insentif` (
  `idmapping` char(10) NOT NULL,
  `tglmapping` date NOT NULL,
  `idkaryawan` char(10) NOT NULL,
  `idinsentif` char(10) DEFAULT NULL,
  `besarbonus` decimal(11,0) DEFAULT NULL,
  `tagerterjual` decimal(11,0) DEFAULT NULL,
  `target` decimal(11,0) DEFAULT NULL,
  PRIMARY KEY (`idmapping`),
  UNIQUE KEY `tglmapping` (`tglmapping`,`idkaryawan`),
  KEY `id` (`idmapping`),
  KEY `idkaryawan` (`idkaryawan`),
  KEY `idinsentif` (`idinsentif`),
  CONSTRAINT `mapping_insentif_ibfk_1` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`),
  CONSTRAINT `mapping_insentif_ibfk_2` FOREIGN KEY (`idinsentif`) REFERENCES `insentif` (`idinsentif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mapping_insentif` */

/*Table structure for table `mapping_insentif_detail` */

DROP TABLE IF EXISTS `mapping_insentif_detail`;

CREATE TABLE `mapping_insentif_detail` (
  `idmapping` char(10) DEFAULT NULL,
  `idbarang_insentif` char(10) DEFAULT NULL,
  `bonus` decimal(18,0) DEFAULT NULL,
  `qtyterjual` int(11) DEFAULT NULL,
  UNIQUE KEY `idmapping` (`idmapping`,`idbarang_insentif`),
  KEY `idbaranginsentif` (`idbarang_insentif`),
  CONSTRAINT `mapping_insentif_detail_ibfk_1` FOREIGN KEY (`idmapping`) REFERENCES `mapping_insentif` (`idmapping`),
  CONSTRAINT `mapping_insentif_detail_ibfk_2` FOREIGN KEY (`idbarang_insentif`) REFERENCES `barang_insentif` (`idbarang_insentif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `mapping_insentif_detail` */

/*Table structure for table `penjualan` */

DROP TABLE IF EXISTS `penjualan`;

CREATE TABLE `penjualan` (
  `idpenjualan` char(10) NOT NULL,
  `tglpenjualan` date DEFAULT NULL,
  `idkonsumen` char(10) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `totalharga` decimal(11,0) DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `idkaryawan` char(10) DEFAULT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `idkonsumen` (`idkonsumen`),
  KEY `idkaryawan` (`idkaryawan`),
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`idkonsumen`) REFERENCES `konsumen` (`idkonsumen`),
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `penjualan` */

/*Table structure for table `penjualan_detail` */

DROP TABLE IF EXISTS `penjualan_detail`;

CREATE TABLE `penjualan_detail` (
  `idpenjualan` char(10) DEFAULT NULL,
  `idbarang` char(10) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `hargajual` decimal(11,0) DEFAULT NULL,
  `totalharga` decimal(11,0) DEFAULT NULL,
  UNIQUE KEY `idpenjualan` (`idpenjualan`,`idbarang`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `penjualan_detail_ibfk_1` FOREIGN KEY (`idpenjualan`) REFERENCES `penjualan` (`idpenjualan`),
  CONSTRAINT `penjualan_detail_ibfk_2` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `penjualan_detail` */

/* Function  structure for function  `f_idbarang_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idbarang_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idbarang_create`() RETURNS char(10) CHARSET utf8mb4
BEGIN
	
	DECLARE _cNosekarang VARCHAR(20);
	DECLARE _nNoSelanjutnya INT;
	DECLARE _kodeSekarang CHAR(7);
	
	
	SELECT MAX(RIGHT(idbarang,6)) INTO _cNosekarang FROM barang;
	SET _cNosekarang = IF(ISNULL(_cNosekarang),0,_cNosekarang);
	SET _nNoSelanjutnya = CONVERT(_cNosekarang, INT) + 1;
	
	IF _nNoSelanjutnya > 0 AND _nNoSelanjutnya < 10 THEN
		SET _kodesekarang = CONCAT('-00000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10 AND _nNoSelanjutnya < 100 THEN
		SET _kodesekarang = CONCAT('-0000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100 AND _nNoSelanjutnya < 1000 THEN
		SET _kodesekarang = CONCAT('-000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 1000 AND _nNoSelanjutnya < 10000 THEN
		SET _kodesekarang = CONCAT('-00',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10000 AND _nNoSelanjutnya < 100000 THEN
		SET _kodesekarang = CONCAT('-0',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100000 AND _nNoSelanjutnya < 1000000 THEN
		SET _kodesekarang = CONCAT('-',_nNoSelanjutnya);
	END IF;
	
	
	RETURN CONCAT('BRG', _kodeSekarang);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idbarang_insentif_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idbarang_insentif_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idbarang_insentif_create`() RETURNS char(10) CHARSET utf8mb4
BEGIN
	
	DECLARE _cNosekarang VARCHAR(20);
	DECLARE _nNoSelanjutnya INT;
	DECLARE _kodeSekarang CHAR(7);
	
	
	SELECT MAX(RIGHT(idbarang_insentif,6)) INTO _cNosekarang FROM barang_insentif;
	SET _cNosekarang = IF(ISNULL(_cNosekarang),0,_cNosekarang);
	SET _nNoSelanjutnya = CONVERT(_cNosekarang, INT) + 1;
	
	IF _nNoSelanjutnya > 0 AND _nNoSelanjutnya < 10 THEN
		SET _kodesekarang = CONCAT('-00000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10 AND _nNoSelanjutnya < 100 THEN
		SET _kodesekarang = CONCAT('-0000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100 AND _nNoSelanjutnya < 1000 THEN
		SET _kodesekarang = CONCAT('-000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 1000 AND _nNoSelanjutnya < 10000 THEN
		SET _kodesekarang = CONCAT('-00',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10000 AND _nNoSelanjutnya < 100000 THEN
		SET _kodesekarang = CONCAT('-0',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100000 AND _nNoSelanjutnya < 1000000 THEN
		SET _kodesekarang = CONCAT('-',_nNoSelanjutnya);
	END IF;
	
	
	RETURN CONCAT('BRI', _kodeSekarang);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idinsentif_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idinsentif_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idinsentif_create`() RETURNS char(10) CHARSET utf8mb4
BEGIN
	
	DECLARE _cNosekarang VARCHAR(20);
	DECLARE _nNoSelanjutnya INT;
	DECLARE _kodeSekarang CHAR(7);
	
	
	SELECT MAX(RIGHT(idinsentif,6)) INTO _cNosekarang FROM insentif;
	SET _cNosekarang = IF(ISNULL(_cNosekarang),0,_cNosekarang);
	SET _nNoSelanjutnya = CONVERT(_cNosekarang, INT) + 1;
	
	IF _nNoSelanjutnya > 0 AND _nNoSelanjutnya < 10 THEN
		SET _kodesekarang = CONCAT('-00000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10 AND _nNoSelanjutnya < 100 THEN
		SET _kodesekarang = CONCAT('-0000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100 AND _nNoSelanjutnya < 1000 THEN
		SET _kodesekarang = CONCAT('-000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 1000 AND _nNoSelanjutnya < 10000 THEN
		SET _kodesekarang = CONCAT('-00',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10000 AND _nNoSelanjutnya < 100000 THEN
		SET _kodesekarang = CONCAT('-0',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100000 AND _nNoSelanjutnya < 1000000 THEN
		SET _kodesekarang = CONCAT('-',_nNoSelanjutnya);
	END IF;
	
	
	RETURN CONCAT('INS', _kodeSekarang);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idkaryawan_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idkaryawan_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idkaryawan_create`() RETURNS char(10) CHARSET utf8mb4
BEGIN
	
	DECLARE _cNosekarang VARCHAR(20);
	DECLARE _nNoSelanjutnya INT;
	DECLARE _kodeSekarang CHAR(7);
	
	
	SELECT MAX(RIGHT(idkaryawan,6)) INTO _cNosekarang FROM karyawan;
	SET _cNosekarang = IF(ISNULL(_cNosekarang),0,_cNosekarang);
	SET _nNoSelanjutnya = CONVERT(_cNosekarang, INT) + 1;
	
	IF _nNoSelanjutnya > 0 AND _nNoSelanjutnya < 10 THEN
		SET _kodesekarang = CONCAT('-00000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10 AND _nNoSelanjutnya < 100 THEN
		SET _kodesekarang = CONCAT('-0000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100 AND _nNoSelanjutnya < 1000 THEN
		SET _kodesekarang = CONCAT('-000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 1000 AND _nNoSelanjutnya < 10000 THEN
		SET _kodesekarang = CONCAT('-00',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10000 AND _nNoSelanjutnya < 100000 THEN
		SET _kodesekarang = CONCAT('-0',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100000 AND _nNoSelanjutnya < 1000000 THEN
		SET _kodesekarang = CONCAT('-',_nNoSelanjutnya);
	END IF;
	
	
	RETURN CONCAT('KRY', _kodeSekarang);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idkonsumen_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idkonsumen_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idkonsumen_create`() RETURNS char(10) CHARSET utf8mb4
BEGIN
	
	DECLARE _cNosekarang VARCHAR(20);
	DECLARE _nNoSelanjutnya INT;
	DECLARE _kodeSekarang CHAR(7);
	
	
	SELECT MAX(RIGHT(idkonsumen,6)) INTO _cNosekarang FROM konsumen;
	SET _cNosekarang = IF(ISNULL(_cNosekarang),0,_cNosekarang);
	SET _nNoSelanjutnya = CONVERT(_cNosekarang, INT) + 1;
	
	IF _nNoSelanjutnya > 0 AND _nNoSelanjutnya < 10 THEN
		SET _kodesekarang = CONCAT('-00000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10 AND _nNoSelanjutnya < 100 THEN
		SET _kodesekarang = CONCAT('-0000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100 AND _nNoSelanjutnya < 1000 THEN
		SET _kodesekarang = CONCAT('-000',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 1000 AND _nNoSelanjutnya < 10000 THEN
		SET _kodesekarang = CONCAT('-00',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 10000 AND _nNoSelanjutnya < 100000 THEN
		SET _kodesekarang = CONCAT('-0',_nNoSelanjutnya);
	ELSEIF _nNoSelanjutnya >= 100000 AND _nNoSelanjutnya < 1000000 THEN
		SET _kodesekarang = CONCAT('-',_nNoSelanjutnya);
	END IF;
	
	
	RETURN CONCAT('KNS', _kodeSekarang);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idmapping_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idmapping_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idmapping_create`(_tgl DATE) RETURNS char(10) CHARSET latin1
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT;
	DECLARE cTgl CHAR(6);
	
	SET jumlah_digit = '4';
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(idmapping),jumlah_digit)) FROM mapping_insentif WHERE DATE_FORMAT(tglmapping, '%Y-%m-%d') = _tgl  INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CONVERT(cNosekarang,INT)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/* Function  structure for function  `f_idpenjualan_create` */

/*!50003 DROP FUNCTION IF EXISTS `f_idpenjualan_create` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `f_idpenjualan_create`(_tgl DATE) RETURNS char(10) CHARSET latin1
BEGIN
	DECLARE cNosekarang CHAR(4);
	DECLARE nlen INT;
	DECLARE nNoselanjutnya INT;
	DECLARE cNoselanjutnya CHAR(4);
	DECLARE jumlah_digit INT;
	DECLARE cTgl CHAR(6);
	
	SET jumlah_digit = '4';
	SET cTgl = DATE_FORMAT(_tgl, '%y%m%d');
	
	SELECT MAX(RIGHT(RTRIM(idpenjualan),jumlah_digit)) FROM penjualan WHERE DATE_FORMAT(tglpenjualan, '%Y-%m-%d') = _tgl  INTO cNosekarang;	
	SET cNosekarang = IF(ISNULL(cNosekarang),0,cNosekarang);
	
	SET nNoselanjutnya = CONVERT(cNosekarang,INT)+1;
	SET cNoselanjutnya = RTRIM(CONVERT(nNoselanjutnya,CHAR));
	SET nlen = LENGTH(cNoselanjutnya);
	
	WHILE nlen+1 <= jumlah_digit DO		
		SET cNoselanjutnya= CONCAT('0',cNoselanjutnya);
		SET nlen=nlen+1;
	END WHILE;	
	
	RETURN CONCAT(cTgl, cNoselanjutnya);
    END */$$
DELIMITER ;

/*Table structure for table `v_barang_insentif` */

DROP TABLE IF EXISTS `v_barang_insentif`;

/*!50001 DROP VIEW IF EXISTS `v_barang_insentif` */;
/*!50001 DROP TABLE IF EXISTS `v_barang_insentif` */;

/*!50001 CREATE TABLE  `v_barang_insentif`(
 `idbarang_insentif` char(10) ,
 `idbarang` char(10) ,
 `namabarang` varchar(50) ,
 `jenis` enum('Makanan','Minuman') ,
 `satuan` varchar(10) ,
 `hargajual` decimal(11,0) ,
 `foto` varchar(255) ,
 `targetqty_awal` int(11) ,
 `targetqty_akhir` int(11) ,
 `bonus` decimal(18,0) ,
 `tglinsert` datetime ,
 `tglupdate` datetime ,
 `statusaktif` enum('Aktif','Tidak Aktif') ,
 `idkaryawan` char(10) ,
 `namakaryawan` varchar(30) ,
 `jabatan` enum('Canvasser','Supervisor') 
)*/;

/*Table structure for table `v_insentif` */

DROP TABLE IF EXISTS `v_insentif`;

/*!50001 DROP VIEW IF EXISTS `v_insentif` */;
/*!50001 DROP TABLE IF EXISTS `v_insentif` */;

/*!50001 CREATE TABLE  `v_insentif`(
 `idinsentif` char(10) ,
 `target` decimal(11,0) ,
 `besarbonus` decimal(11,0) ,
 `keterangan` text ,
 `statusaktif` enum('Aktif','Tidak Aktif') ,
 `tginsert` datetime ,
 `tglupdate` datetime ,
 `idkaryawan` char(10) ,
 `namakaryawan` varchar(30) ,
 `jabatan` enum('Canvasser','Supervisor') 
)*/;

/*Table structure for table `v_mapping_insentif` */

DROP TABLE IF EXISTS `v_mapping_insentif`;

/*!50001 DROP VIEW IF EXISTS `v_mapping_insentif` */;
/*!50001 DROP TABLE IF EXISTS `v_mapping_insentif` */;

/*!50001 CREATE TABLE  `v_mapping_insentif`(
 `idmapping` char(10) ,
 `tglmapping` date ,
 `idkaryawan` char(10) ,
 `namakaryawan` varchar(30) ,
 `notelp` varchar(14) ,
 `email` varchar(50) ,
 `jabatan` enum('Canvasser','Supervisor') ,
 `idinsentif` char(10) ,
 `besarbonus` decimal(11,0) ,
 `tagerterjual` decimal(11,0) ,
 `target` decimal(11,0) ,
 `totalbonusbarang` decimal(40,0) 
)*/;

/*Table structure for table `v_mapping_insentif_detail` */

DROP TABLE IF EXISTS `v_mapping_insentif_detail`;

/*!50001 DROP VIEW IF EXISTS `v_mapping_insentif_detail` */;
/*!50001 DROP TABLE IF EXISTS `v_mapping_insentif_detail` */;

/*!50001 CREATE TABLE  `v_mapping_insentif_detail`(
 `idmapping` char(10) ,
 `tglmapping` date ,
 `idbarang_insentif` char(10) ,
 `idbarang` char(10) ,
 `namabarang` varchar(50) ,
 `jenis` enum('Makanan','Minuman') ,
 `satuan` varchar(10) ,
 `hargajual` decimal(11,0) ,
 `targetqty_awal` int(11) ,
 `targetqty_akhir` int(11) ,
 `bonus` decimal(18,0) ,
 `qtyterjual` int(11) 
)*/;

/*Table structure for table `v_penjualan` */

DROP TABLE IF EXISTS `v_penjualan`;

/*!50001 DROP VIEW IF EXISTS `v_penjualan` */;
/*!50001 DROP TABLE IF EXISTS `v_penjualan` */;

/*!50001 CREATE TABLE  `v_penjualan`(
 `idpenjualan` char(10) ,
 `tglpenjualan` date ,
 `idkonsumen` char(10) ,
 `namakonsumen` varchar(50) ,
 `notelp` varchar(20) ,
 `email` varchar(20) ,
 `keterangan` text ,
 `totalharga` decimal(33,0) ,
 `tglinsert` datetime ,
 `tglupdate` datetime ,
 `idkaryawan` char(10) ,
 `namakaryawan` varchar(30) ,
 `jabatan` enum('Canvasser','Supervisor') 
)*/;

/*Table structure for table `v_penjualan_detail` */

DROP TABLE IF EXISTS `v_penjualan_detail`;

/*!50001 DROP VIEW IF EXISTS `v_penjualan_detail` */;
/*!50001 DROP TABLE IF EXISTS `v_penjualan_detail` */;

/*!50001 CREATE TABLE  `v_penjualan_detail`(
 `idpenjualan` char(10) ,
 `tglpenjualan` date ,
 `idbarang` char(10) ,
 `namabarang` varchar(50) ,
 `jenis` enum('Makanan','Minuman') ,
 `satuan` varchar(10) ,
 `qty` int(11) ,
 `hargajual` decimal(11,0) ,
 `totalharga` decimal(11,0) 
)*/;

/*View structure for view v_barang_insentif */

/*!50001 DROP TABLE IF EXISTS `v_barang_insentif` */;
/*!50001 DROP VIEW IF EXISTS `v_barang_insentif` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang_insentif` AS select `barang_insentif`.`idbarang_insentif` AS `idbarang_insentif`,`barang_insentif`.`idbarang` AS `idbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`jenis` AS `jenis`,`barang`.`satuan` AS `satuan`,`barang`.`hargajual` AS `hargajual`,`barang`.`foto` AS `foto`,`barang_insentif`.`targetqty_awal` AS `targetqty_awal`,`barang_insentif`.`targetqty_akhir` AS `targetqty_akhir`,`barang_insentif`.`bonus` AS `bonus`,`barang_insentif`.`tglinsert` AS `tglinsert`,`barang_insentif`.`tglupdate` AS `tglupdate`,`barang_insentif`.`statusaktif` AS `statusaktif`,`barang_insentif`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`jabatan` AS `jabatan` from ((`barang_insentif` join `karyawan` on(`barang_insentif`.`idkaryawan` = `karyawan`.`idkaryawan`)) join `barang` on(`barang_insentif`.`idbarang` = `barang`.`idbarang`)) */;

/*View structure for view v_insentif */

/*!50001 DROP TABLE IF EXISTS `v_insentif` */;
/*!50001 DROP VIEW IF EXISTS `v_insentif` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_insentif` AS select `insentif`.`idinsentif` AS `idinsentif`,`insentif`.`target` AS `target`,`insentif`.`besarbonus` AS `besarbonus`,`insentif`.`keterangan` AS `keterangan`,`insentif`.`statusaktif` AS `statusaktif`,`insentif`.`tginsert` AS `tginsert`,`insentif`.`tglupdate` AS `tglupdate`,`insentif`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`jabatan` AS `jabatan` from (`insentif` join `karyawan` on(`insentif`.`idkaryawan` = `karyawan`.`idkaryawan`)) */;

/*View structure for view v_mapping_insentif */

/*!50001 DROP TABLE IF EXISTS `v_mapping_insentif` */;
/*!50001 DROP VIEW IF EXISTS `v_mapping_insentif` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mapping_insentif` AS select `mapping_insentif`.`idmapping` AS `idmapping`,`mapping_insentif`.`tglmapping` AS `tglmapping`,`mapping_insentif`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`notelp` AS `notelp`,`karyawan`.`email` AS `email`,`karyawan`.`jabatan` AS `jabatan`,`mapping_insentif`.`idinsentif` AS `idinsentif`,`mapping_insentif`.`besarbonus` AS `besarbonus`,`mapping_insentif`.`tagerterjual` AS `tagerterjual`,`mapping_insentif`.`target` AS `target`,(select sum(`mapping_insentif_detail`.`bonus`) from `mapping_insentif_detail` where `mapping_insentif_detail`.`idmapping` = `mapping_insentif`.`idmapping`) AS `totalbonusbarang` from ((`mapping_insentif` join `karyawan` on(`mapping_insentif`.`idkaryawan` = `karyawan`.`idkaryawan`)) join `insentif` on(`mapping_insentif`.`idinsentif` = `insentif`.`idinsentif`)) */;

/*View structure for view v_mapping_insentif_detail */

/*!50001 DROP TABLE IF EXISTS `v_mapping_insentif_detail` */;
/*!50001 DROP VIEW IF EXISTS `v_mapping_insentif_detail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mapping_insentif_detail` AS select `mapping_insentif_detail`.`idmapping` AS `idmapping`,`mapping_insentif`.`tglmapping` AS `tglmapping`,`mapping_insentif_detail`.`idbarang_insentif` AS `idbarang_insentif`,`barang_insentif`.`idbarang` AS `idbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`jenis` AS `jenis`,`barang`.`satuan` AS `satuan`,`barang`.`hargajual` AS `hargajual`,`barang_insentif`.`targetqty_awal` AS `targetqty_awal`,`barang_insentif`.`targetqty_akhir` AS `targetqty_akhir`,`mapping_insentif_detail`.`bonus` AS `bonus`,`mapping_insentif_detail`.`qtyterjual` AS `qtyterjual` from (((`mapping_insentif_detail` join `mapping_insentif` on(`mapping_insentif_detail`.`idmapping` = `mapping_insentif`.`idmapping`)) join `barang_insentif` on(`mapping_insentif_detail`.`idbarang_insentif` = `barang_insentif`.`idbarang_insentif`)) join `barang` on(`barang_insentif`.`idbarang` = `barang`.`idbarang`)) */;

/*View structure for view v_penjualan */

/*!50001 DROP TABLE IF EXISTS `v_penjualan` */;
/*!50001 DROP VIEW IF EXISTS `v_penjualan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penjualan` AS select `penjualan`.`idpenjualan` AS `idpenjualan`,`penjualan`.`tglpenjualan` AS `tglpenjualan`,`penjualan`.`idkonsumen` AS `idkonsumen`,`konsumen`.`namakonsumen` AS `namakonsumen`,`konsumen`.`notelp` AS `notelp`,`konsumen`.`email` AS `email`,`penjualan`.`keterangan` AS `keterangan`,(select sum(`penjualan_detail`.`totalharga`) from `penjualan_detail` where `penjualan_detail`.`idpenjualan` = `penjualan`.`idpenjualan`) AS `totalharga`,`penjualan`.`tglinsert` AS `tglinsert`,`penjualan`.`tglupdate` AS `tglupdate`,`penjualan`.`idkaryawan` AS `idkaryawan`,`karyawan`.`namakaryawan` AS `namakaryawan`,`karyawan`.`jabatan` AS `jabatan` from ((`penjualan` join `konsumen` on(`penjualan`.`idkonsumen` = `konsumen`.`idkonsumen`)) join `karyawan` on(`penjualan`.`idkaryawan` = `karyawan`.`idkaryawan`)) */;

/*View structure for view v_penjualan_detail */

/*!50001 DROP TABLE IF EXISTS `v_penjualan_detail` */;
/*!50001 DROP VIEW IF EXISTS `v_penjualan_detail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_penjualan_detail` AS select `penjualan_detail`.`idpenjualan` AS `idpenjualan`,`penjualan`.`tglpenjualan` AS `tglpenjualan`,`penjualan_detail`.`idbarang` AS `idbarang`,`barang`.`namabarang` AS `namabarang`,`barang`.`jenis` AS `jenis`,`barang`.`satuan` AS `satuan`,`penjualan_detail`.`qty` AS `qty`,`penjualan_detail`.`hargajual` AS `hargajual`,`penjualan_detail`.`totalharga` AS `totalharga` from ((`penjualan_detail` join `penjualan` on(`penjualan_detail`.`idpenjualan` = `penjualan`.`idpenjualan`)) join `barang` on(`penjualan_detail`.`idbarang` = `barang`.`idbarang`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
