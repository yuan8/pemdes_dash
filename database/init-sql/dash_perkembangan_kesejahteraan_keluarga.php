
<?php

return [
"name"=>"dash_perkembangan_kesejahteraan_keluarga",
"sql_create"=>"
CREATE TABLE `dash_perkembangan_kesejahteraan_keluarga` (
  `kode_desa` bigint(20) NOT NULL,
    `tahun` int(11) NOT NULL,
    `status_validasi` int(11) DEFAULT 0,
    `validasi_date` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `id_user_desa_ver` bigint(20) DEFAULT NULL,
    `id_user_kec_ver` bigint(20) DEFAULT NULL,
    `id_user_kab_valid` bigint(20) DEFAULT NULL,
  `prasejahtera` double DEFAULT NULL,
  `sejahtera_1` double DEFAULT NULL,
  `sejahtera_2` double DEFAULT NULL,
  `sejahtera3` double DEFAULT NULL,
  `sejahtera_3_plus` double DEFAULT NULL,
  UNIQUE KEY `kode_desa` (`kode_desa`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
];
			