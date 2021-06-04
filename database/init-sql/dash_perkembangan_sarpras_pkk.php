
<?php

return [
"name"=>"dash_perkembangan_sarpras_pkk",
"sql_create"=>"CREATE TABLE `dash_perkembangan_sarpras_pkk` (
 	`kode_desa` bigint(20) NOT NULL,
    `tahun` int(11) NOT NULL,
    `status_validasi` int(11) DEFAULT 0,
    `validasi_date` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `id_user_desa_ver` bigint(20) DEFAULT NULL,
    `id_user_kec_ver` bigint(20) DEFAULT NULL,
    `id_user_kab_valid` bigint(20) DEFAULT NULL,
	  `jenis_organisasi` varchar(255) DEFAULT NULL,
	  `kepengurusan` varchar(255) DEFAULT NULL,
	  `jumlah_buku_administrasi` double DEFAULT NULL,
	  `jumlah_kegiatan` double DEFAULT NULL,
	  `dasar_hukum_pembentukan` varchar(255) DEFAULT NULL,
	  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			