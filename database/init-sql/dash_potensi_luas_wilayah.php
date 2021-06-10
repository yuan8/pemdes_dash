
<?php

return [
"name"=>"dash_potensi_luas_wilayah",
"sql_create"=>"
CREATE TABLE `dash_potensi_luas_wilayah` (
  `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
	`daftar_draf` boolean DEFAULT 0,
	
  `luas_wilayah` bigint(20) DEFAULT NULL,
  `penetapan_batas` tinyint(1) DEFAULT NULL,
  `peta_batas` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
];
			