<?php


return [
	"name"=>"dash_potensi_jumlah_penduduk",
	"sql_create"=>"CREATE TABLE `dash_potensi_jumlah_penduduk` (
 `kode_desa` bigint(20) NOT NULL,
    `tahun` int(11) NOT NULL,
    `status_validasi` int(11) DEFAULT 0,
    `validasi_date` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `id_user_desa_ver` bigint(20) DEFAULT NULL,
    `id_user_kec_ver` bigint(20) DEFAULT NULL,
    `id_user_kab_valid` bigint(20) DEFAULT NULL,
  `daftar_draf` boolean DEFAULT 0,
    
  `Jumlah_Laki_Laki_orang` int(11) DEFAULT NULL,
  `Jumlah_Perempuan_orang` int(11) DEFAULT NULL,
  `Jumlah_Total_orang` int(11) DEFAULT NULL,
  `Jumlah_Kepala_Keluarga_KK` int(11) DEFAULT NULL,
  `Kepadatan_Penduduk_Jiwa_Km2` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
];