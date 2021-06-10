
<?php

return [
"name"=>"dash_perkembangan_posyandu",
"sql_create"=>"CREATE TABLE `dash_perkembangan_posyandu` (
		`kode_desa` bigint(20) NOT NULL,
  		`tahun` int(11) NOT NULL,
	   `status_validasi` int(11) DEFAULT 0,
	   `validasi_date` datetime DEFAULT NULL,
	   `updated_at` datetime DEFAULT NULL,
	   `id_user_desa_ver` bigint(20) DEFAULT NULL,
	   `id_user_kec_ver` bigint(20) DEFAULT NULL,
		`id_user_kab_valid` bigint(20) DEFAULT NULL,
	`daftar_draf` boolean DEFAULT 0,
		
	  `Jumlah_MCK_Umum` double DEFAULT NULL,
	  `Jumlah_Posyandu` double DEFAULT NULL,
	  `Jumlah_kader_Posyandu_aktif` double DEFAULT NULL,
	  `Jumlah_pembina_Posyandu` double DEFAULT NULL,
	  `Jumlah_Dasawisma` double DEFAULT NULL,
	  `Jumlah_pengurus_Dasa_Wisma_aktif` double DEFAULT NULL,
	  `Jumlah_kader_bina_keluarga_balita_aktif` double DEFAULT NULL,
	  `Jumlah_petugas_lapangan_keluarga_berencana_aktif` double DEFAULT NULL,
	  `Buku_administrasi_Posyandu_lainnya` double DEFAULT NULL,
	  `Jumlah_kegiatan_Posyandu` double DEFAULT NULL,
	  `Jumlah_kader_kesehatan_lainnya` double DEFAULT NULL,
	  `Jumlah_kegiatan_pengobatan_gratis` double DEFAULT NULL,
	  `Jumlah_kegiatan_pemberantasan_sarang_nyamuk_PSN` double DEFAULT NULL,
	  `Jumlah_kegiatan_pembersihan_lingkungan` double DEFAULT NULL,
	  `Lainnya` double DEFAULT NULL,
	  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`),
	  KEY `kode_desa_2` (`kode_desa`),
	  KEY `tahun` (`tahun`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			