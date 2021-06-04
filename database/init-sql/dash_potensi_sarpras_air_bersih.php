
<?php

return [
"name"=>"dash_potensi_sarpras_air_bersih",
"sql_create"=>"
CREATE TABLE `dash_potensi_sarpras_air_bersih` (
  `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `sumur_pompa` int(11) DEFAULT NULL,
  `sumur_gali` int(11) DEFAULT NULL,
  `hidran_umum` int(11) DEFAULT NULL,
  `penampung_air_hujan` int(11) DEFAULT NULL,
  `tangki_air_bersih` int(11) DEFAULT NULL,
  `embung` int(11) DEFAULT NULL,
  `mata_air` int(11) DEFAULT NULL,
  `bangunan_pengolah_air` int(11) DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			