
<?php

return [
"name"=>"dash_potensi_sarpras_kominfo",
"sql_create"=>"
CREATE TABLE `dash_potensi_sarpras_kominfo` (
`kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `Telepon_umum` double DEFAULT NULL,
  `Wartel` double DEFAULT NULL,
  `Warnet` double DEFAULT NULL,
  `Jumlah_Pelanggan_Telkom` double DEFAULT NULL,
  `Jumlah_Pelanggan_GSM` double DEFAULT NULL,
  `Jumlah_Pelanggan_CDMA` double DEFAULT NULL,
  `Sinyal_Telepon_Seluler_Handphone` double DEFAULT NULL,
  `Kantor_pos` double DEFAULT NULL,
  `Kantor_pos_pembantu` double DEFAULT NULL,
  `Tukang_pos` double DEFAULT NULL,
  `TV_umum` double DEFAULT NULL,
  `Jumlah_radio` double DEFAULT NULL,
  `Jumlah_TV` double DEFAULT NULL,
  `Jumlah_parabola` double DEFAULT NULL,
  `Koran_surat_kabar` double DEFAULT NULL,
  `Majalah` double DEFAULT NULL,
  `Papan_iklan_reklame` double DEFAULT NULL,
  `Papan_pengumuman` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			