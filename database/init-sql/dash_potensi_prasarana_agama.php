
<?php

return [
"name"=>"dash_potensi_prasarana_agama",
"sql_create"=>"
CREATE TABLE `dash_potensi_prasarana_agama` (
  `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `daftar_draf` boolean DEFAULT 0,
  
  `jumlah_masjid_kodisi_baik` double DEFAULT NULL,
  `jumlah_langgar_surau_mushola_kodisi_baik` double DEFAULT NULL,
  `jumlah_gereja_kristen_protestan_kodisi_baik` double DEFAULT NULL,
  `jumlah_gereja_katholik_kodisi_baik` double DEFAULT NULL,
  `jumlah_wihara_kodisi_baik` double DEFAULT NULL,
  `jumlah_pura_kodisi_baik` double DEFAULT NULL,
  `jumlah_klenteng_kodisi_baik` double DEFAULT NULL,
  UNIQUE KEY `kode_permen` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			