
<?php

return [
"name"=>"dash_potensi_sarana_prasarana_pemerintahan",
"sql_create"=>"
CREATE TABLE `dash_potensi_sarana_prasarana_pemerintahan` (
  `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
	`sd` bigint(20) DEFAULT NULL,
	`smp` bigint(20) DEFAULT NULL,
	`sma` bigint(20) DEFAULT NULL,
	`diploma` bigint(20) DEFAULT NULL,
	`s1` bigint(20) DEFAULT NULL,
	`s2` bigint(20) DEFAULT NULL,
	`s3` bigint(20) DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			