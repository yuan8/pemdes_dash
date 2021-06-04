
<?php

return [
"name"=>"dash_potensi_umur_penduduk",
"sql_create"=>"
CREATE TABLE `dash_potensi_umur_penduduk` (
  `kode_desa` bigint(20) NOT NULL,
	`tahun` int(11) NOT NULL,
	`status_validasi` int(11) DEFAULT 0,
	`validasi_date` datetime DEFAULT NULL,
	`updated_at` datetime DEFAULT NULL,
	`id_user_desa_ver` bigint(20) DEFAULT NULL,
	`id_user_kec_ver` bigint(20) DEFAULT NULL,
	`id_user_kab_valid` bigint(20) DEFAULT NULL,
  `laki_usia_00` int(11) DEFAULT NULL,
  `laki_usia_01` int(11) DEFAULT NULL,
  `laki_usia_02` int(11) DEFAULT NULL,
  `laki_usia_03` int(11) DEFAULT NULL,
  `laki_usia_04` int(11) DEFAULT NULL,
  `laki_usia_05` int(11) DEFAULT NULL,
  `laki_usia_06` int(11) DEFAULT NULL,
  `laki_usia_07` int(11) DEFAULT NULL,
  `laki_usia_08` int(11) DEFAULT NULL,
  `laki_usia_09` int(11) DEFAULT NULL,
  `laki_usia_10` int(11) DEFAULT NULL,
  `laki_usia_11` int(11) DEFAULT NULL,
  `laki_usia_12` int(11) DEFAULT NULL,
  `laki_usia_13` int(11) DEFAULT NULL,
  `laki_usia_14` int(11) DEFAULT NULL,
  `laki_usia_15` int(11) DEFAULT NULL,
  `laki_usia_16` int(11) DEFAULT NULL,
  `laki_usia_17` int(11) DEFAULT NULL,
  `laki_usia_18` int(11) DEFAULT NULL,
  `laki_usia_19` int(11) DEFAULT NULL,
  `laki_usia_20` int(11) DEFAULT NULL,
  `laki_usia_21` int(11) DEFAULT NULL,
  `laki_usia_22` int(11) DEFAULT NULL,
  `laki_usia_23` int(11) DEFAULT NULL,
  `laki_usia_24` int(11) DEFAULT NULL,
  `laki_usia_25` int(11) DEFAULT NULL,
  `laki_usia_26` int(11) DEFAULT NULL,
  `laki_usia_27` int(11) DEFAULT NULL,
  `laki_usia_28` int(11) DEFAULT NULL,
  `laki_usia_29` int(11) DEFAULT NULL,
  `laki_usia_30` int(11) DEFAULT NULL,
  `laki_usia_31` int(11) DEFAULT NULL,
  `laki_usia_32` int(11) DEFAULT NULL,
  `laki_usia_33` int(11) DEFAULT NULL,
  `laki_usia_34` int(11) DEFAULT NULL,
  `laki_usia_35` int(11) DEFAULT NULL,
  `laki_usia_36` int(11) DEFAULT NULL,
  `laki_usia_37` int(11) DEFAULT NULL,
  `laki_usia_38` int(11) DEFAULT NULL,
  `laki_usia_39` int(11) DEFAULT NULL,
  `laki_usia_40` int(11) DEFAULT NULL,
  `laki_usia_41` int(11) DEFAULT NULL,
  `laki_usia_42` int(11) DEFAULT NULL,
  `laki_usia_43` int(11) DEFAULT NULL,
  `laki_usia_44` int(11) DEFAULT NULL,
  `laki_usia_45` int(11) DEFAULT NULL,
  `laki_usia_46` int(11) DEFAULT NULL,
  `laki_usia_47` int(11) DEFAULT NULL,
  `laki_usia_48` int(11) DEFAULT NULL,
  `laki_usia_49` int(11) DEFAULT NULL,
  `laki_usia_50` int(11) DEFAULT NULL,
  `laki_usia_51` int(11) DEFAULT NULL,
  `laki_usia_52` int(11) DEFAULT NULL,
  `laki_usia_53` int(11) DEFAULT NULL,
  `laki_usia_54` int(11) DEFAULT NULL,
  `laki_usia_55` int(11) DEFAULT NULL,
  `laki_usia_56` int(11) DEFAULT NULL,
  `laki_usia_57` int(11) DEFAULT NULL,
  `laki_usia_58` int(11) DEFAULT NULL,
  `laki_usia_59` int(11) DEFAULT NULL,
  `laki_usia_60` int(11) DEFAULT NULL,
  `laki_usia_61` int(11) DEFAULT NULL,
  `laki_usia_62` int(11) DEFAULT NULL,
  `laki_usia_63` int(11) DEFAULT NULL,
  `laki_usia_64` int(11) DEFAULT NULL,
  `laki_usia_65` int(11) DEFAULT NULL,
  `laki_usia_66` int(11) DEFAULT NULL,
  `laki_usia_67` int(11) DEFAULT NULL,
  `laki_usia_68` int(11) DEFAULT NULL,
  `laki_usia_69` int(11) DEFAULT NULL,
  `laki_usia_70` int(11) DEFAULT NULL,
  `laki_usia_71` int(11) DEFAULT NULL,
  `laki_usia_72` int(11) DEFAULT NULL,
  `laki_usia_73` int(11) DEFAULT NULL,
  `laki_usia_74` int(11) DEFAULT NULL,
  `laki_usia_75` int(11) DEFAULT NULL,
  `laki_usia_lebih_dari_75` int(11) DEFAULT NULL,
  `wanita_usia_00` int(11) DEFAULT NULL,
  `wanita_usia_01` int(11) DEFAULT NULL,
  `wanita_usia_02` int(11) DEFAULT NULL,
  `wanita_usia_03` int(11) DEFAULT NULL,
  `wanita_usia_04` int(11) DEFAULT NULL,
  `wanita_usia_05` int(11) DEFAULT NULL,
  `wanita_usia_06` int(11) DEFAULT NULL,
  `wanita_usia_07` int(11) DEFAULT NULL,
  `wanita_usia_08` int(11) DEFAULT NULL,
  `wanita_usia_09` int(11) DEFAULT NULL,
  `wanita_usia_10` int(11) DEFAULT NULL,
  `wanita_usia_11` int(11) DEFAULT NULL,
  `wanita_usia_12` int(11) DEFAULT NULL,
  `wanita_usia_13` int(11) DEFAULT NULL,
  `wanita_usia_14` int(11) DEFAULT NULL,
  `wanita_usia_15` int(11) DEFAULT NULL,
  `wanita_usia_16` int(11) DEFAULT NULL,
  `wanita_usia_17` int(11) DEFAULT NULL,
  `wanita_usia_18` int(11) DEFAULT NULL,
  `wanita_usia_19` int(11) DEFAULT NULL,
  `wanita_usia_20` int(11) DEFAULT NULL,
  `wanita_usia_21` int(11) DEFAULT NULL,
  `wanita_usia_22` int(11) DEFAULT NULL,
  `wanita_usia_23` int(11) DEFAULT NULL,
  `wanita_usia_24` int(11) DEFAULT NULL,
  `wanita_usia_25` int(11) DEFAULT NULL,
  `wanita_usia_26` int(11) DEFAULT NULL,
  `wanita_usia_27` int(11) DEFAULT NULL,
  `wanita_usia_28` int(11) DEFAULT NULL,
  `wanita_usia_29` int(11) DEFAULT NULL,
  `wanita_usia_30` int(11) DEFAULT NULL,
  `wanita_usia_31` int(11) DEFAULT NULL,
  `wanita_usia_32` int(11) DEFAULT NULL,
  `wanita_usia_33` int(11) DEFAULT NULL,
  `wanita_usia_34` int(11) DEFAULT NULL,
  `wanita_usia_35` int(11) DEFAULT NULL,
  `wanita_usia_36` int(11) DEFAULT NULL,
  `wanita_usia_37` int(11) DEFAULT NULL,
  `wanita_usia_38` int(11) DEFAULT NULL,
  `wanita_usia_39` int(11) DEFAULT NULL,
  `wanita_usia_40` int(11) DEFAULT NULL,
  `wanita_usia_41` int(11) DEFAULT NULL,
  `wanita_usia_42` int(11) DEFAULT NULL,
  `wanita_usia_43` int(11) DEFAULT NULL,
  `wanita_usia_44` int(11) DEFAULT NULL,
  `wanita_usia_45` int(11) DEFAULT NULL,
  `wanita_usia_46` int(11) DEFAULT NULL,
  `wanita_usia_47` int(11) DEFAULT NULL,
  `wanita_usia_48` int(11) DEFAULT NULL,
  `wanita_usia_49` int(11) DEFAULT NULL,
  `wanita_usia_50` int(11) DEFAULT NULL,
  `wanita_usia_51` int(11) DEFAULT NULL,
  `wanita_usia_52` int(11) DEFAULT NULL,
  `wanita_usia_53` int(11) DEFAULT NULL,
  `wanita_usia_54` int(11) DEFAULT NULL,
  `wanita_usia_55` int(11) DEFAULT NULL,
  `wanita_usia_56` int(11) DEFAULT NULL,
  `wanita_usia_57` int(11) DEFAULT NULL,
  `wanita_usia_58` int(11) DEFAULT NULL,
  `wanita_usia_59` int(11) DEFAULT NULL,
  `wanita_usia_60` int(11) DEFAULT NULL,
  `wanita_usia_61` int(11) DEFAULT NULL,
  `wanita_usia_62` int(11) DEFAULT NULL,
  `wanita_usia_63` int(11) DEFAULT NULL,
  `wanita_usia_64` int(11) DEFAULT NULL,
  `wanita_usia_65` int(11) DEFAULT NULL,
  `wanita_usia_66` int(11) DEFAULT NULL,
  `wanita_usia_67` int(11) DEFAULT NULL,
  `wanita_usia_68` int(11) DEFAULT NULL,
  `wanita_usia_69` int(11) DEFAULT NULL,
  `wanita_usia_70` int(11) DEFAULT NULL,
  `wanita_usia_71` int(11) DEFAULT NULL,
  `wanita_usia_72` int(11) DEFAULT NULL,
  `wanita_usia_73` int(11) DEFAULT NULL,
  `wanita_usia_74` int(11) DEFAULT NULL,
  `wanita_usia_75` int(11) DEFAULT NULL,
  `wanita_usia_lebih_dari_75` int(11) DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8"
];
			