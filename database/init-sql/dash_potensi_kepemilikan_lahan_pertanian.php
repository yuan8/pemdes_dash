
<?php

return [

	"name"=>"dash_potensi_kepemilikan_lahan_pertanian",
	"sql_create"=>"CREATE TABLE `dash_potensi_kepemilikan_lahan_pertanian` (
 	`kode_desa` bigint(20) NOT NULL,
	    `tahun` int(11) NOT NULL,
	    `status_validasi` int(11) DEFAULT 0,
	    `validasi_date` datetime DEFAULT NULL,
	    `updated_at` datetime DEFAULT NULL,
	    `id_user_desa_ver` bigint(20) DEFAULT NULL,
	    `id_user_kec_ver` bigint(20) DEFAULT NULL,
	    `id_user_kab_valid` bigint(20) DEFAULT NULL,
  `Jumlah_Keluarga_Memiliki_Tanah` int(11) DEFAULT NULL,
  `Jumlah_Keluarga_Tidak_Memiliki_Tanah` int(11) DEFAULT NULL,
  `Memiliki_Kurang_10_Ha` int(11) DEFAULT NULL,
  `Memiliki_10_50_Ha` int(11) DEFAULT NULL,
  `Memiliki_50_100_Ha` int(11) DEFAULT NULL,
  `Memiliki_Lebih_Dari_100_Ha` int(11) DEFAULT NULL,
  `Jumlah_Keluarga_Petani_Tanaman_Pangan` int(11) DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"];