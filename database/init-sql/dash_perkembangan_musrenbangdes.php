
<?php

return [
"name"=>"dash_perkembangan_musrenbangdes",
"sql_create"=>"CREATE TABLE `dash_perkembangan_musrenbangdes` (
	`kode_desa` bigint(20) NOT NULL,
	   `tahun` int(11) NOT NULL,
	   `status_validasi` int(11) DEFAULT 0,
	   `validasi_date` datetime DEFAULT NULL,
	   `updated_at` datetime DEFAULT NULL,
	   `id_user_desa_ver` bigint(20) DEFAULT NULL,
	   `id_user_kec_ver` bigint(20) DEFAULT NULL,
		`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `daftar_draf` boolean DEFAULT 0,
    
  `jumlah_musrenbangdes` double DEFAULT NULL,
  `jumlah_kehadiran_masyarakat` double DEFAULT NULL,
  `jumlah_peserta_pria` double DEFAULT NULL,
  `jumlah_peserta_wanita` double DEFAULT NULL,
  `jumlah_musrenbang_antar_desa` double DEFAULT NULL,
  `penggunaan_profil` varchar(10) DEFAULT NULL,
  `penggunaan_data_bps` varchar(10) DEFAULT NULL,
  `pelibatan_masyarakat_untuk_pemutakiran_profil` varchar(10) DEFAULT NULL,
  `usulan_masyarakat_menjadi_rkpdes` double DEFAULT NULL,
  `usulan_deskel_disetujui_rapbdes` double DEFAULT NULL,
  `usulan_rkpd_disetujui_deskel` double DEFAULT NULL,
  `usulan_rkp_ditolak_musrenbang` double DEFAULT NULL,
  `kepemilikan_rkpdes` varchar(10) DEFAULT NULL,
  `kepemilikan_rpjmdes` varchar(10) DEFAULT NULL,
  `kepemilikan_dokumen_musrenbangdes` varchar(10) DEFAULT NULL,
  `kegiatan_diusulkan_tidak_terealisasi` double DEFAULT NULL,
  `kegiatan_diusulkan_realisasi_tidak_sesuai` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
];
			