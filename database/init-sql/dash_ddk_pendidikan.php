
<?php

return [
"name"=>"dash_ddk_pendidikan",
"sql_create"=>" CREATE TABLE `dash_ddk_pendidikan` (
    `kode_desa` bigint(20) NOT NULL,
    `tahun` int(11) NOT NULL,
    `status_validasi` int(11) DEFAULT 0,
    `validasi_date` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `id_user_desa_ver` bigint(20) DEFAULT NULL,
    `id_user_kec_ver` bigint(20) DEFAULT NULL,
    `id_user_kab_valid` bigint(20) DEFAULT NULL,
    `daftar_draf` boolean DEFAULT 0,
    
    `tidak_sekolah` bigint(20) DEFAULT NULL,
    `sd` bigint(20) DEFAULT NULL,
    `smp` bigint(20) DEFAULT NULL,
    `sma` bigint(20) DEFAULT NULL,
    `pt` bigint(20) DEFAULT NULL,
    `jumlah_kk` bigint(20) DEFAULT NULL,
    `jumlah_ak` bigint(20) DEFAULT NULL,
    UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1"
];
			