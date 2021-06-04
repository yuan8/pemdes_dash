<?php


return [
	"name"=>"dash_potensi_kepemilikan_lahan_hutan",
	"sql_create"=>"CREATE TABLE `dash_potensi_kepemilikan_lahan_hutan` (
		 `kode_desa` bigint(20) NOT NULL,
	    `tahun` int(11) NOT NULL,
	    `status_validasi` int(11) DEFAULT 0,
	    `validasi_date` datetime DEFAULT NULL,
	    `updated_at` datetime DEFAULT NULL,
	    `id_user_desa_ver` bigint(20) DEFAULT NULL,
	    `id_user_kec_ver` bigint(20) DEFAULT NULL,
	    `id_user_kab_valid` bigint(20) DEFAULT NULL,
	  `Milik_Negara` double DEFAULT NULL,
	  `Milik_Adat_Ulayat` double DEFAULT NULL,
	  `Perhutani_Instansi_Sektoral` double DEFAULT NULL,
	  `Milik_Masyarakat_Perorangan` double DEFAULT NULL,
	  `Luas_Hutan` double DEFAULT NULL,
	  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8"

];