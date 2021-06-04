
<?php

return [
"name"=>"dash_potensi_iklim_tanah_erosi",
"sql_create"=>"CREATE TABLE `dash_potensi_iklim_tanah_erosi` (
  `kode_desa` bigint(20) NOT NULL,
    `tahun` int(11) NOT NULL,
    `status_validasi` int(11) DEFAULT 0,
    `validasi_date` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `id_user_desa_ver` bigint(20) DEFAULT NULL,
    `id_user_kec_ver` bigint(20) DEFAULT NULL,
    `id_user_kab_valid` bigint(20) DEFAULT NULL,
  `Curah_Hujan_mm` double DEFAULT NULL,
  `Jumlah_Bulan_Hujan_bulan` double DEFAULT NULL,
  `Kelembapan_Udara_persen` double DEFAULT NULL,
  `Suhu_Rata_Rata_Harian_oC` double DEFAULT NULL,
  `Tinggi_Diatas_Permukaan_Laut_M` double DEFAULT NULL,
  `Warna_Tanah_kuning` int(11) DEFAULT NULL,
  `Warna_Tanah_hitam` int(11) DEFAULT NULL,
  `Warna_Tanah_abu_abu` int(11) DEFAULT NULL,
  `Warna_Tanah_merah` int(11) DEFAULT NULL,
  `Tekstur_Tanah_pasiran` int(11) DEFAULT NULL,
  `Tekstur_Tanah_debuan` int(11) DEFAULT NULL,
  `Tekstur_Tanah_lempungan` int(11) DEFAULT NULL,
  `Kemiringan_Tanah_derajat` double DEFAULT NULL,
  `Lahan_Kritis_Ha` double DEFAULT NULL,
  `Lahan_Terlantar_Ha` double DEFAULT NULL,
  `Luas_Tanah_Erosi_Ringan_Ha` double DEFAULT NULL,
  `Luas_Tanah_Erosi_Sedang_Ha` double DEFAULT NULL,
  `Luas_Tanah_Erosi_Berat_Ha` double DEFAULT NULL,
  `Luas_Tanah_yang_Tidak_Ada_Erosi_Ha` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
];
			