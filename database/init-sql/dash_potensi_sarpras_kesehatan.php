
<?php

return [
"name"=>"dash_potensi_sarpras_kesehatan",
"sql_create"=>"
CREATE TABLE `dash_potensi_sarpras_kesehatan` (
 `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `Rumah_sakit_umum` double DEFAULT NULL,
  `Puskesmas` double DEFAULT NULL,
  `Puskesmas_pembantu` double DEFAULT NULL,
  `Poliklinik_balai_pengobatan` double DEFAULT NULL,
  `Apotik` double DEFAULT NULL,
  `Posyandu` double DEFAULT NULL,
  `Toko_obat` double DEFAULT NULL,
  `Balai_pengobatan_masyarakat_yayasan_swasta` double DEFAULT NULL,
  `Gudang_menyimpan_obat` double DEFAULT NULL,
  `Jumlah_Rumah_Kantor_Praktek_Dokter` double DEFAULT NULL,
  `Rumah_Bersalin` double DEFAULT NULL,
  `Balai_Kesehatan_Ibu_dan_Anak` double DEFAULT NULL,
  `Rumah_Sakit_Mata` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			