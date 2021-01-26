<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PeKerjaanCtrl extends Controller
{
    //

    static function toNumber($num){
    	return (double)$num;
    }

     public function index(){

      // 

      return view('dash.kependudukan.pekerjaan');

    }

     public function get_pp_provinsi(){
     	$max=(array)DB::table('dash_ddk_pekerjaan as jp')
    	->selectRaw("sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
    	->first();

    	$max=array_map('static::toNumber',$max);
    	(arsort($max));

     

    	$title_max='4 JENIS PEKERJAAN DENGAN JUMLAH JIWA TERTINGGI NASIONAL';
    	$title='JENIS PEKERJAAN PENDUDUK PERPROVINSI';

    	$data=DB::table('provinsi as p')
      ->leftJoin('dash_ddk_pekerjaan as jp',DB::raw("left(jp.kode_desa,2)"),'=','p.kdprovinsi')
      ->selectRaw("p.kdprovinsi as id,p.nmprovinsi as name,sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
      ->groupBy('p.kdprovinsi')
      ->where('p.kdprovinsi','<>',0)
      ->get();


      $series=[
		[ 'name'=>'PETANI', 'data'=>[], ],
		[ 'name'=>'BURUH TANI', 'data'=>[], ],
		[ 'name'=>'BURUH MIGRAN', 'data'=>[], ],
		[ 'name'=>'PEGAWAI NEGERI SIPIL', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN', 'data'=>[], ],
		[ 'name'=>'PEDAGANG BARANG KELONTONG', 'data'=>[], ],
		[ 'name'=>'PETERNAK', 'data'=>[], ],
		[ 'name'=>'NELAYAN', 'data'=>[], ],
		[ 'name'=>'MONTIR', 'data'=>[], ],
		[ 'name'=>'DOKTER SWASTA', 'data'=>[], ],
		[ 'name'=>'PERAWAT SWASTA', 'data'=>[], ],
		[ 'name'=>'BIDAN SWASTA', 'data'=>[], ],
		[ 'name'=>'AHLI PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'TNI', 'data'=>[], ],
		[ 'name'=>'POLRI', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA KECIL MENENGAH DAN BESAR', 'data'=>[], ],
		[ 'name'=>'GURU SWASTA', 'data'=>[], ],
		[ 'name'=>'DOSEN SWASTA', 'data'=>[], ],
		[ 'name'=>'SENIMAN ARTIS', 'data'=>[], ],
		[ 'name'=>'PEDAGANG KELILING', 'data'=>[], ],
		[ 'name'=>'PENAMBANG', 'data'=>[], ],
		[ 'name'=>'TUKANG KAYU', 'data'=>[], ],
		[ 'name'=>'TUKANG BATU', 'data'=>[], ],
		[ 'name'=>'TUKANG CUCI', 'data'=>[], ],
		[ 'name'=>'PEMBANTU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PENGACARA', 'data'=>[], ],
		[ 'name'=>'NOTARIS', 'data'=>[], ],
		[ 'name'=>'DUKUN TRADISIONAL', 'data'=>[], ],
		[ 'name'=>'ARSITEKTUR DESAINER', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN SWASTA', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN PEMERINTAH', 'data'=>[], ],
		[ 'name'=>'WIRASWASTA', 'data'=>[], ],
		[ 'name'=>'KONSULTAN MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'TIDAK MEMPUNYAI PEKERJAAN TETAP', 'data'=>[], ],
		[ 'name'=>'BELUM BEKERJA', 'data'=>[], ],
		[ 'name'=>'PELAJAR', 'data'=>[], ],
		[ 'name'=>'IBU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PURNAWIRAWAN PENSIUNAN', 'data'=>[], ],
		[ 'name'=>'PERANGKAT DESA', 'data'=>[], ],
		[ 'name'=>'BURUH HARIAN LEPAS', 'data'=>[], ],
		[ 'name'=>'PEMILIK PERUSAHAAN', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'BURUH JASA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'KONTRAKTOR', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA WARUNG RUMAH MAKAN DAN RESTORAN', 'data'=>[], ],
		[ 'name'=>'DUKUN PARANORMAL SUPRANATURAL', 'data'=>[], ],
		[ 'name'=>'JASA PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'SOPIR', 'data'=>[], ],
		[ 'name'=>'USAHA JASA PENGERAH TENAGA KERJA', 'data'=>[], ],
		[ 'name'=>'JASA PENYEWAAN PERALATAN PESTA', 'data'=>[], ],
		[ 'name'=>'PEMULUNG', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN INDUSTRI RUMAH TANGGA LAINNYA', 'data'=>[], ],
		[ 'name'=>'TUKANG ANYAMAN', 'data'=>[], ],
		[ 'name'=>'TUKANG JAHIT', 'data'=>[], ],
		[ 'name'=>'TUKANG KUE', 'data'=>[], ],
		[ 'name'=>'TUKANG RIAS', 'data'=>[], ],
		[ 'name'=>'TUKANG SUMUR', 'data'=>[], ],
		[ 'name'=>'JASA KONSULTANSI MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'JURU MASAK', 'data'=>[], ],
		[ 'name'=>'KARYAWAN HONORER', 'data'=>[], ],
		[ 'name'=>'PIALANG', 'data'=>[], ],
		[ 'name'=>'PSKIATER PSIKOLOG', 'data'=>[], ],
		[ 'name'=>'WARTAWAN', 'data'=>[], ],
		[ 'name'=>'TUKANG CUKUR', 'data'=>[], ],
		[ 'name'=>'TUKANG LAS', 'data'=>[], ],
		[ 'name'=>'TUKANG GIGI', 'data'=>[], ],
		[ 'name'=>'TUKANG LISTRIK', 'data'=>[], ],
		[ 'name'=>'PEMUKA AGAMA', 'data'=>[], ],
		[ 'name'=>'ANGGOTA LEGISLATIF', 'data'=>[], ],
		[ 'name'=>'KEPALA DAERAH', 'data'=>[], ],
		[ 'name'=>'APOTEKER', 'data'=>[], ],
		[ 'name'=>'PRESIDEN', 'data'=>[], ],
		[ 'name'=>'WAKIL PRESIDEN', 'data'=>[], ],
		[ 'name'=>'ANGGOTA MAHKAMAH KONSTITUSI', 'data'=>[], ],
		[ 'name'=>'ANGGOTA KABINET KEMENTRIAN', 'data'=>[], ],
		[ 'name'=>'DUTA BESAR', 'data'=>[], ],
		[ 'name'=>'GUBERNUR', 'data'=>[], ],
		[ 'name'=>'WAKIL BUPATI', 'data'=>[], ],
		[ 'name'=>'PILOT', 'data'=>[], ],
		[ 'name'=>'PENYIAR RADIO', 'data'=>[], ],
		[ 'name'=>'PELAUT', 'data'=>[], ],
		[ 'name'=>'PENELITI', 'data'=>[], ],
		[ 'name'=>'SATPAM SECURITY', 'data'=>[], ],
		[ 'name'=>'WAKIL GUBERNUR', 'data'=>[], ],
		[ 'name'=>'BUPATI WALIKOTA', 'data'=>[], ],
		[ 'name'=>'AKUNTAN', 'data'=>[], ],
		[ 'name'=>'BIARAWATI', 'data'=>[], ],
        

      ];

      foreach ($data as $key => $value) {
        
		$series[0]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->petani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[1]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_tani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[2]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_migran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[3]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pegawai_negeri_sipil, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[4]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[5]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_barang_kelontong, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[6]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peternak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[7]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->nelayan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[8]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->montir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[9]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dokter_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[10]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perawat_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[11]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bidan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[12]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ahli_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[13]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tni, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[14]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->polri, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[15]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_kecil__menengah_dan_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[16]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->guru_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[17]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dosen_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[18]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->seniman_artis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[19]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_keliling, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[20]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penambang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[21]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kayu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[22]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_batu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[23]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cuci, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[24]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pembantu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[25]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengacara, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[26]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->notaris, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[27]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_tradisional, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[28]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->arsitektur_desainer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[29]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[30]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_pemerintah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[31]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wiraswasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[32]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->konsultan_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[33]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tidak_mempunyai_pekerjaan_tetap, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[34]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->belum_bekerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[35]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelajar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[36]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ibu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[37]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->purnawirawan_pensiunan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[38]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perangkat_desa, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[39]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_harian_lepas, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[40]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_perusahaan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[41]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[42]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_jasa_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[43]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[44]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[45]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[46]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[47]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kontraktor, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[48]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[49]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[50]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[51]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[52]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_warung__rumah_makan_dan_restoran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[53]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_paranormal_supranatural, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[54]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[55]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->sopir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[56]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->usaha_jasa_pengerah_tenaga_kerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[57]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_penyewaan_peralatan_pesta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[58]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemulung, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[59]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin_industri_rumah_tangga_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[60]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_anyaman, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[61]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_jahit, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[62]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kue, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[63]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_rias, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[64]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_sumur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[65]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_konsultansi_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[66]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->juru_masak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[67]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_honorer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[68]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pialang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[69]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pskiater_psikolog, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[70]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wartawan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[71]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cukur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[72]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_las, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[73]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_gigi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[74]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_listrik, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[75]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemuka_agama, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[76]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_legislatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[77]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kepala_daerah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[78]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->apoteker, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[79]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[80]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[81]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_mahkamah_konstitusi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[82]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_kabinet_kementrian, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[83]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->duta_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[84]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[85]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_bupati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[86]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pilot, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[87]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penyiar_radio, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[88]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelaut, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[89]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peneliti, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[90]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->satpam_security, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[91]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[92]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bupati_walikota, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[93]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->akuntan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[94]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->biarawati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];

         
      }


      return view('chart.max_pekerjaan')->with(['max'=>$max,'title'=>$title_max])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_2(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_kota($kodepemda){
    	$pemda=DB::table('provinsi')->where('kdprovinsi','=',$kodepemda)->first();
    	$title_max='4 JENIS PEKERJAAN DENGAN JUMLAH JIWA TERTINGGI PROVINSI '.$pemda->nmprovinsi;
    	$title='JENIS PEKERJAAN PENDUDUK PER KOTA/KAB PROVINSI '.$pemda->nmprovinsi;


      $data=DB::table('kabkota as p')
      ->leftJoin('dash_ddk_pekerjaan as jp',DB::raw("left(jp.kode_desa,4)"),'=','p.kdkabkota')
      ->selectRaw("p.kdkabkota as id,p.nmkabkota as name,sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
      ->groupBy('p.kdkabkota')
      ->where(DB::RAW("left(p.kdkabkota,2)"),'=',$kodepemda)
      ->get();

      	$max=(array)DB::table('dash_ddk_pekerjaan as jp')->where(DB::RAW("left(jp.kode_desa,2)"),'=',$kodepemda)
    	->selectRaw("sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
    	->first();

    	$max=array_map('static::toNumber',$max);
    	(arsort($max));


      $series=[
		[ 'name'=>'PETANI', 'data'=>[], ],
		[ 'name'=>'BURUH TANI', 'data'=>[], ],
		[ 'name'=>'BURUH MIGRAN', 'data'=>[], ],
		[ 'name'=>'PEGAWAI NEGERI SIPIL', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN', 'data'=>[], ],
		[ 'name'=>'PEDAGANG BARANG KELONTONG', 'data'=>[], ],
		[ 'name'=>'PETERNAK', 'data'=>[], ],
		[ 'name'=>'NELAYAN', 'data'=>[], ],
		[ 'name'=>'MONTIR', 'data'=>[], ],
		[ 'name'=>'DOKTER SWASTA', 'data'=>[], ],
		[ 'name'=>'PERAWAT SWASTA', 'data'=>[], ],
		[ 'name'=>'BIDAN SWASTA', 'data'=>[], ],
		[ 'name'=>'AHLI PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'TNI', 'data'=>[], ],
		[ 'name'=>'POLRI', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA KECIL MENENGAH DAN BESAR', 'data'=>[], ],
		[ 'name'=>'GURU SWASTA', 'data'=>[], ],
		[ 'name'=>'DOSEN SWASTA', 'data'=>[], ],
		[ 'name'=>'SENIMAN ARTIS', 'data'=>[], ],
		[ 'name'=>'PEDAGANG KELILING', 'data'=>[], ],
		[ 'name'=>'PENAMBANG', 'data'=>[], ],
		[ 'name'=>'TUKANG KAYU', 'data'=>[], ],
		[ 'name'=>'TUKANG BATU', 'data'=>[], ],
		[ 'name'=>'TUKANG CUCI', 'data'=>[], ],
		[ 'name'=>'PEMBANTU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PENGACARA', 'data'=>[], ],
		[ 'name'=>'NOTARIS', 'data'=>[], ],
		[ 'name'=>'DUKUN TRADISIONAL', 'data'=>[], ],
		[ 'name'=>'ARSITEKTUR DESAINER', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN SWASTA', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN PEMERINTAH', 'data'=>[], ],
		[ 'name'=>'WIRASWASTA', 'data'=>[], ],
		[ 'name'=>'KONSULTAN MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'TIDAK MEMPUNYAI PEKERJAAN TETAP', 'data'=>[], ],
		[ 'name'=>'BELUM BEKERJA', 'data'=>[], ],
		[ 'name'=>'PELAJAR', 'data'=>[], ],
		[ 'name'=>'IBU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PURNAWIRAWAN PENSIUNAN', 'data'=>[], ],
		[ 'name'=>'PERANGKAT DESA', 'data'=>[], ],
		[ 'name'=>'BURUH HARIAN LEPAS', 'data'=>[], ],
		[ 'name'=>'PEMILIK PERUSAHAAN', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'BURUH JASA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'KONTRAKTOR', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA WARUNG RUMAH MAKAN DAN RESTORAN', 'data'=>[], ],
		[ 'name'=>'DUKUN PARANORMAL SUPRANATURAL', 'data'=>[], ],
		[ 'name'=>'JASA PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'SOPIR', 'data'=>[], ],
		[ 'name'=>'USAHA JASA PENGERAH TENAGA KERJA', 'data'=>[], ],
		[ 'name'=>'JASA PENYEWAAN PERALATAN PESTA', 'data'=>[], ],
		[ 'name'=>'PEMULUNG', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN INDUSTRI RUMAH TANGGA LAINNYA', 'data'=>[], ],
		[ 'name'=>'TUKANG ANYAMAN', 'data'=>[], ],
		[ 'name'=>'TUKANG JAHIT', 'data'=>[], ],
		[ 'name'=>'TUKANG KUE', 'data'=>[], ],
		[ 'name'=>'TUKANG RIAS', 'data'=>[], ],
		[ 'name'=>'TUKANG SUMUR', 'data'=>[], ],
		[ 'name'=>'JASA KONSULTANSI MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'JURU MASAK', 'data'=>[], ],
		[ 'name'=>'KARYAWAN HONORER', 'data'=>[], ],
		[ 'name'=>'PIALANG', 'data'=>[], ],
		[ 'name'=>'PSKIATER PSIKOLOG', 'data'=>[], ],
		[ 'name'=>'WARTAWAN', 'data'=>[], ],
		[ 'name'=>'TUKANG CUKUR', 'data'=>[], ],
		[ 'name'=>'TUKANG LAS', 'data'=>[], ],
		[ 'name'=>'TUKANG GIGI', 'data'=>[], ],
		[ 'name'=>'TUKANG LISTRIK', 'data'=>[], ],
		[ 'name'=>'PEMUKA AGAMA', 'data'=>[], ],
		[ 'name'=>'ANGGOTA LEGISLATIF', 'data'=>[], ],
		[ 'name'=>'KEPALA DAERAH', 'data'=>[], ],
		[ 'name'=>'APOTEKER', 'data'=>[], ],
		[ 'name'=>'PRESIDEN', 'data'=>[], ],
		[ 'name'=>'WAKIL PRESIDEN', 'data'=>[], ],
		[ 'name'=>'ANGGOTA MAHKAMAH KONSTITUSI', 'data'=>[], ],
		[ 'name'=>'ANGGOTA KABINET KEMENTRIAN', 'data'=>[], ],
		[ 'name'=>'DUTA BESAR', 'data'=>[], ],
		[ 'name'=>'GUBERNUR', 'data'=>[], ],
		[ 'name'=>'WAKIL BUPATI', 'data'=>[], ],
		[ 'name'=>'PILOT', 'data'=>[], ],
		[ 'name'=>'PENYIAR RADIO', 'data'=>[], ],
		[ 'name'=>'PELAUT', 'data'=>[], ],
		[ 'name'=>'PENELITI', 'data'=>[], ],
		[ 'name'=>'SATPAM SECURITY', 'data'=>[], ],
		[ 'name'=>'WAKIL GUBERNUR', 'data'=>[], ],
		[ 'name'=>'BUPATI WALIKOTA', 'data'=>[], ],
		[ 'name'=>'AKUNTAN', 'data'=>[], ],
		[ 'name'=>'BIARAWATI', 'data'=>[], ],
        

      ];

      foreach ($data as $key => $value) {
        
		///

		$series[0]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->petani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[1]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_tani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[2]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_migran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[3]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pegawai_negeri_sipil, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[4]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[5]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_barang_kelontong, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[6]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peternak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[7]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->nelayan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[8]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->montir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[9]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dokter_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[10]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perawat_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[11]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bidan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[12]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ahli_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[13]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tni, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[14]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->polri, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[15]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_kecil__menengah_dan_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[16]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->guru_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[17]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dosen_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[18]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->seniman_artis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[19]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_keliling, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[20]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penambang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[21]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kayu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[22]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_batu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[23]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cuci, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[24]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pembantu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[25]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengacara, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[26]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->notaris, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[27]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_tradisional, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[28]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->arsitektur_desainer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[29]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[30]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_pemerintah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[31]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wiraswasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[32]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->konsultan_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[33]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tidak_mempunyai_pekerjaan_tetap, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[34]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->belum_bekerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[35]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelajar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[36]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ibu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[37]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->purnawirawan_pensiunan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[38]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perangkat_desa, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[39]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_harian_lepas, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[40]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_perusahaan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[41]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[42]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_jasa_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[43]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[44]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[45]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[46]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[47]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kontraktor, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[48]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[49]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[50]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[51]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[52]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_warung__rumah_makan_dan_restoran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[53]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_paranormal_supranatural, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[54]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[55]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->sopir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[56]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->usaha_jasa_pengerah_tenaga_kerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[57]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_penyewaan_peralatan_pesta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[58]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemulung, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[59]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin_industri_rumah_tangga_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[60]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_anyaman, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[61]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_jahit, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[62]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kue, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[63]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_rias, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[64]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_sumur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[65]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_konsultansi_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[66]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->juru_masak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[67]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_honorer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[68]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pialang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[69]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pskiater_psikolog, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[70]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wartawan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[71]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cukur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[72]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_las, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[73]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_gigi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[74]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_listrik, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[75]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemuka_agama, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[76]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_legislatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[77]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kepala_daerah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[78]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->apoteker, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[79]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[80]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[81]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_mahkamah_konstitusi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[82]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_kabinet_kementrian, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[83]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->duta_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[84]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[85]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_bupati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[86]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pilot, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[87]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penyiar_radio, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[88]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelaut, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[89]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peneliti, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[90]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->satpam_security, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[91]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[92]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bupati_walikota, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[93]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->akuntan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];
		$series[94]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->biarawati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.kc',['kodepemda'=>$value->id]) ];

         
      }

      return view('chart.max_pekerjaan')->with(['max'=>$max,'title'=>$title_max])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_3(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_kecamatan($kodepemda){
    	$pemda=DB::table('kabkota')->where('kdkabkota','=',$kodepemda)->first();
    	$title_max='4 JENIS PEKERJAAN DENGAN JUMLAH JIWA TERTINGGI KECAMATAN '.$pemda->nmkabkota;;
    	$title='JENIS PEKERJAAN PENDUDUK PER KECAMATAN '.$pemda->nmkabkota;

      $data=DB::table('kecamatan as p')
      ->leftJoin('dash_ddk_pekerjaan as jp',DB::raw("left(jp.kode_desa,7)"),'=','p.kdkecamatan')
      ->selectRaw("p.kdkecamatan as id,p.nmkecamatan as name,sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
    	 ->groupBy('p.kdkecamatan')
      ->where(DB::RAW("left(p.kdkecamatan,4)"),'=',$kodepemda)
      ->get();


      	$max=(array)DB::table('dash_ddk_pekerjaan as jp')->where(DB::RAW("left(jp.kode_desa,4)"),'=',$kodepemda)
    	->selectRaw("sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
    	->first();

    	$max=array_map('static::toNumber',$max);
    	(arsort($max));


      $series=[
		[ 'name'=>'PETANI', 'data'=>[], ],
		[ 'name'=>'BURUH TANI', 'data'=>[], ],
		[ 'name'=>'BURUH MIGRAN', 'data'=>[], ],
		[ 'name'=>'PEGAWAI NEGERI SIPIL', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN', 'data'=>[], ],
		[ 'name'=>'PEDAGANG BARANG KELONTONG', 'data'=>[], ],
		[ 'name'=>'PETERNAK', 'data'=>[], ],
		[ 'name'=>'NELAYAN', 'data'=>[], ],
		[ 'name'=>'MONTIR', 'data'=>[], ],
		[ 'name'=>'DOKTER SWASTA', 'data'=>[], ],
		[ 'name'=>'PERAWAT SWASTA', 'data'=>[], ],
		[ 'name'=>'BIDAN SWASTA', 'data'=>[], ],
		[ 'name'=>'AHLI PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'TNI', 'data'=>[], ],
		[ 'name'=>'POLRI', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA KECIL MENENGAH DAN BESAR', 'data'=>[], ],
		[ 'name'=>'GURU SWASTA', 'data'=>[], ],
		[ 'name'=>'DOSEN SWASTA', 'data'=>[], ],
		[ 'name'=>'SENIMAN ARTIS', 'data'=>[], ],
		[ 'name'=>'PEDAGANG KELILING', 'data'=>[], ],
		[ 'name'=>'PENAMBANG', 'data'=>[], ],
		[ 'name'=>'TUKANG KAYU', 'data'=>[], ],
		[ 'name'=>'TUKANG BATU', 'data'=>[], ],
		[ 'name'=>'TUKANG CUCI', 'data'=>[], ],
		[ 'name'=>'PEMBANTU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PENGACARA', 'data'=>[], ],
		[ 'name'=>'NOTARIS', 'data'=>[], ],
		[ 'name'=>'DUKUN TRADISIONAL', 'data'=>[], ],
		[ 'name'=>'ARSITEKTUR DESAINER', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN SWASTA', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN PEMERINTAH', 'data'=>[], ],
		[ 'name'=>'WIRASWASTA', 'data'=>[], ],
		[ 'name'=>'KONSULTAN MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'TIDAK MEMPUNYAI PEKERJAAN TETAP', 'data'=>[], ],
		[ 'name'=>'BELUM BEKERJA', 'data'=>[], ],
		[ 'name'=>'PELAJAR', 'data'=>[], ],
		[ 'name'=>'IBU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PURNAWIRAWAN PENSIUNAN', 'data'=>[], ],
		[ 'name'=>'PERANGKAT DESA', 'data'=>[], ],
		[ 'name'=>'BURUH HARIAN LEPAS', 'data'=>[], ],
		[ 'name'=>'PEMILIK PERUSAHAAN', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'BURUH JASA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'KONTRAKTOR', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA WARUNG RUMAH MAKAN DAN RESTORAN', 'data'=>[], ],
		[ 'name'=>'DUKUN PARANORMAL SUPRANATURAL', 'data'=>[], ],
		[ 'name'=>'JASA PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'SOPIR', 'data'=>[], ],
		[ 'name'=>'USAHA JASA PENGERAH TENAGA KERJA', 'data'=>[], ],
		[ 'name'=>'JASA PENYEWAAN PERALATAN PESTA', 'data'=>[], ],
		[ 'name'=>'PEMULUNG', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN INDUSTRI RUMAH TANGGA LAINNYA', 'data'=>[], ],
		[ 'name'=>'TUKANG ANYAMAN', 'data'=>[], ],
		[ 'name'=>'TUKANG JAHIT', 'data'=>[], ],
		[ 'name'=>'TUKANG KUE', 'data'=>[], ],
		[ 'name'=>'TUKANG RIAS', 'data'=>[], ],
		[ 'name'=>'TUKANG SUMUR', 'data'=>[], ],
		[ 'name'=>'JASA KONSULTANSI MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'JURU MASAK', 'data'=>[], ],
		[ 'name'=>'KARYAWAN HONORER', 'data'=>[], ],
		[ 'name'=>'PIALANG', 'data'=>[], ],
		[ 'name'=>'PSKIATER PSIKOLOG', 'data'=>[], ],
		[ 'name'=>'WARTAWAN', 'data'=>[], ],
		[ 'name'=>'TUKANG CUKUR', 'data'=>[], ],
		[ 'name'=>'TUKANG LAS', 'data'=>[], ],
		[ 'name'=>'TUKANG GIGI', 'data'=>[], ],
		[ 'name'=>'TUKANG LISTRIK', 'data'=>[], ],
		[ 'name'=>'PEMUKA AGAMA', 'data'=>[], ],
		[ 'name'=>'ANGGOTA LEGISLATIF', 'data'=>[], ],
		[ 'name'=>'KEPALA DAERAH', 'data'=>[], ],
		[ 'name'=>'APOTEKER', 'data'=>[], ],
		[ 'name'=>'PRESIDEN', 'data'=>[], ],
		[ 'name'=>'WAKIL PRESIDEN', 'data'=>[], ],
		[ 'name'=>'ANGGOTA MAHKAMAH KONSTITUSI', 'data'=>[], ],
		[ 'name'=>'ANGGOTA KABINET KEMENTRIAN', 'data'=>[], ],
		[ 'name'=>'DUTA BESAR', 'data'=>[], ],
		[ 'name'=>'GUBERNUR', 'data'=>[], ],
		[ 'name'=>'WAKIL BUPATI', 'data'=>[], ],
		[ 'name'=>'PILOT', 'data'=>[], ],
		[ 'name'=>'PENYIAR RADIO', 'data'=>[], ],
		[ 'name'=>'PELAUT', 'data'=>[], ],
		[ 'name'=>'PENELITI', 'data'=>[], ],
		[ 'name'=>'SATPAM SECURITY', 'data'=>[], ],
		[ 'name'=>'WAKIL GUBERNUR', 'data'=>[], ],
		[ 'name'=>'BUPATI WALIKOTA', 'data'=>[], ],
		[ 'name'=>'AKUNTAN', 'data'=>[], ],
		[ 'name'=>'BIARAWATI', 'data'=>[], ],
        

      ];

      foreach ($data as $key => $value) {
        
		$series[0]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->petani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[1]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_tani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[2]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_migran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[3]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pegawai_negeri_sipil, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[4]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[5]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_barang_kelontong, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[6]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peternak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[7]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->nelayan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[8]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->montir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[9]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dokter_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[10]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perawat_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[11]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bidan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[12]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ahli_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[13]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tni, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[14]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->polri, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[15]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_kecil__menengah_dan_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[16]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->guru_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[17]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dosen_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[18]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->seniman_artis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[19]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_keliling, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[20]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penambang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[21]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kayu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[22]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_batu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[23]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cuci, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[24]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pembantu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[25]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengacara, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[26]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->notaris, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[27]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_tradisional, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[28]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->arsitektur_desainer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[29]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[30]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_pemerintah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[31]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wiraswasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[32]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->konsultan_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[33]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tidak_mempunyai_pekerjaan_tetap, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[34]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->belum_bekerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[35]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelajar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[36]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ibu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[37]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->purnawirawan_pensiunan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[38]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perangkat_desa, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[39]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_harian_lepas, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[40]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_perusahaan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[41]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[42]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_jasa_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[43]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[44]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[45]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[46]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[47]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kontraktor, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[48]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[49]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[50]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[51]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[52]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_warung__rumah_makan_dan_restoran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[53]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_paranormal_supranatural, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[54]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[55]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->sopir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[56]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->usaha_jasa_pengerah_tenaga_kerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[57]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_penyewaan_peralatan_pesta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[58]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemulung, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[59]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin_industri_rumah_tangga_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[60]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_anyaman, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[61]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_jahit, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[62]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kue, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[63]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_rias, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[64]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_sumur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[65]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_konsultansi_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[66]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->juru_masak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[67]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_honorer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[68]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pialang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[69]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pskiater_psikolog, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[70]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wartawan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[71]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cukur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[72]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_las, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[73]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_gigi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[74]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_listrik, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[75]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemuka_agama, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[76]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_legislatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[77]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kepala_daerah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[78]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->apoteker, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[79]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[80]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[81]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_mahkamah_konstitusi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[82]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_kabinet_kementrian, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[83]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->duta_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[84]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[85]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_bupati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[86]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pilot, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[87]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penyiar_radio, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[88]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelaut, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[89]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peneliti, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[90]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->satpam_security, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[91]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[92]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bupati_walikota, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[93]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->akuntan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];
		$series[94]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->biarawati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.d',['kodepemda'=>$value->id]) ];

         
      }

      return view('chart.max_pekerjaan')->with(['max'=>$max,'title'=>$title_max])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_4(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_desa($kodepemda){
    	$pemda=DB::table('kecamatan')->where('kdkecamatan','=',$kodepemda)->first();
    	$title_max='4 JENIS PEKERJAAN DENGAN JUMLAH JIWA TERTINGGI KECAMATAN '.$pemda->nmkecamatan;
    	$title='JENIS PEKERJAAN PENDUDUK PER KECAMATAN '.$pemda->nmkecamatan;

      $data=DB::table('master_desa as p')
      ->leftJoin('dash_ddk_pekerjaan as jp',DB::raw("(jp.kode_desa)"),'=','p.kode_dagri')
      ->selectRaw("p.kode_dagri as id,p.desa as name,sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
      ->groupBy('p.kode_dagri')
      ->where(DB::RAW("left(p.kode_dagri,7)"),'=',$kodepemda)
      ->get();

      $max=(array)DB::table('dash_ddk_pekerjaan as jp')->where(DB::RAW("left(jp.kode_desa,7)"),'=',$kodepemda)
    	->selectRaw("sum(jp.Petani) as petani,sum(jp.Buruh_Tani) as buruh_tani,sum(jp.Buruh_Migran) as buruh_migran,sum(jp.Pegawai_Negeri_Sipil) as pegawai_negeri_sipil,sum(jp.Pengrajin) as pengrajin,sum(jp.Pedagang_barang_kelontong) as pedagang_barang_kelontong,sum(jp.Peternak) as peternak,sum(jp.Nelayan) as nelayan,sum(jp.Montir) as montir,sum(jp.Dokter_swasta) as dokter_swasta,sum(jp.Perawat_swasta) as perawat_swasta,sum(jp.Bidan_swasta) as bidan_swasta,sum(jp.Ahli_Pengobatan_Alternatif) as ahli_pengobatan_alternatif,sum(jp.TNI) as tni,sum(jp.POLRI) as polri,sum(jp.Pengusaha_kecil__menengah_dan_besar) as pengusaha_kecil__menengah_dan_besar,sum(jp.Guru_swasta) as guru_swasta,sum(jp.Dosen_swasta) as dosen_swasta,sum(jp.Seniman_artis) as seniman_artis,sum(jp.Pedagang_Keliling) as pedagang_keliling,sum(jp.Penambang) as penambang,sum(jp.Tukang_Kayu) as tukang_kayu,sum(jp.Tukang_Batu) as tukang_batu,sum(jp.Tukang_Cuci) as tukang_cuci,sum(jp.Pembantu_rumah_tangga) as pembantu_rumah_tangga,sum(jp.Pengacara) as pengacara,sum(jp.Notaris) as notaris,sum(jp.Dukun_Tradisional) as dukun_tradisional,sum(jp.Arsitektur_Desainer) as arsitektur_desainer,sum(jp.Karyawan_Perusahaan_Swasta) as karyawan_perusahaan_swasta,sum(jp.Karyawan_Perusahaan_Pemerintah) as karyawan_perusahaan_pemerintah,sum(jp.Wiraswasta) as wiraswasta,sum(jp.Konsultan_Manajemen_dan_Teknis) as konsultan_manajemen_dan_teknis,sum(jp.Tidak_Mempunyai_Pekerjaan_Tetap) as tidak_mempunyai_pekerjaan_tetap,sum(jp.Belum_Bekerja) as belum_bekerja,sum(jp.Pelajar) as pelajar,sum(jp.Ibu_Rumah_Tangga) as ibu_rumah_tangga,sum(jp.Purnawirawan_Pensiunan) as purnawirawan_pensiunan,sum(jp.Perangkat_Desa) as perangkat_desa,sum(jp.Buruh_Harian_Lepas) as buruh_harian_lepas,sum(jp.Pemilik_perusahaan) as pemilik_perusahaan,sum(jp.Pengusaha_perdagangan_hasil_bumi) as pengusaha_perdagangan_hasil_bumi,sum(jp.Buruh_jasa_perdagangan_hasil_bumi) as buruh_jasa_perdagangan_hasil_bumi,sum(jp.Pemilik_usaha_jasa_transportasi_dan_perhubungan) as pemilik_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Buruh_usaha_jasa_transportasi_dan_perhubungan) as buruh_usaha_jasa_transportasi_dan_perhubungan,sum(jp.Pemilik_usaha_informasi_dan_komunikasi) as pemilik_usaha_informasi_dan_komunikasi,sum(jp.Buruh_usaha_jasa_informasi_dan_komunikasi) as buruh_usaha_jasa_informasi_dan_komunikasi,sum(jp.Kontraktor) as kontraktor,sum(jp.Pemilik_usaha_jasa_hiburan_dan_pariwisata) as pemilik_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Buruh_usaha_jasa_hiburan_dan_pariwisata) as buruh_usaha_jasa_hiburan_dan_pariwisata,sum(jp.Pemilik_usaha_hotel_dan_penginapan_lainnya) as pemilik_usaha_hotel_dan_penginapan_lainnya,sum(jp.Buruh_usaha_hotel_dan_penginapan_lainnya) as buruh_usaha_hotel_dan_penginapan_lainnya,sum(jp.Pemilik_usaha_warung__rumah_makan_dan_restoran) as pemilik_usaha_warung__rumah_makan_dan_restoran,sum(jp.Dukun_paranormal_supranatural) as dukun_paranormal_supranatural,sum(jp.Jasa_pengobatan_alternatif) as jasa_pengobatan_alternatif,sum(jp.Sopir) as sopir,sum(jp.Usaha_jasa_pengerah_tenaga_kerja) as usaha_jasa_pengerah_tenaga_kerja,sum(jp.Jasa_penyewaan_peralatan_pesta) as jasa_penyewaan_peralatan_pesta,sum(jp.Pemulung) as pemulung,sum(jp.Pengrajin_industri_rumah_tangga_lainnya) as pengrajin_industri_rumah_tangga_lainnya,sum(jp.Tukang_Anyaman) as tukang_anyaman,sum(jp.Tukang_Jahit) as tukang_jahit,sum(jp.Tukang_Kue) as tukang_kue,sum(jp.Tukang_Rias) as tukang_rias,sum(jp.Tukang_Sumur) as tukang_sumur,sum(jp.Jasa_Konsultansi_Manajemen_dan_Teknis) as jasa_konsultansi_manajemen_dan_teknis,sum(jp.Juru_Masak) as juru_masak,sum(jp.Karyawan_Honorer) as karyawan_honorer,sum(jp.Pialang) as pialang,sum(jp.Pskiater_Psikolog) as pskiater_psikolog,sum(jp.Wartawan) as wartawan,sum(jp.Tukang_Cukur) as tukang_cukur,sum(jp.Tukang_Las) as tukang_las,sum(jp.Tukang_Gigi) as tukang_gigi,sum(jp.Tukang_Listrik) as tukang_listrik,sum(jp.Pemuka_Agama) as pemuka_agama,sum(jp.Anggota_Legislatif) as anggota_legislatif,sum(jp.Kepala_Daerah) as kepala_daerah,sum(jp.Apoteker) as apoteker,sum(jp.Presiden) as presiden,sum(jp.Wakil_presiden) as wakil_presiden,sum(jp.Anggota_mahkamah_konstitusi) as anggota_mahkamah_konstitusi,sum(jp.Anggota_kabinet_kementrian) as anggota_kabinet_kementrian,sum(jp.Duta_besar) as duta_besar,sum(jp.Gubernur) as gubernur,sum(jp.Wakil_bupati) as wakil_bupati,sum(jp.Pilot) as pilot,sum(jp.Penyiar_radio) as penyiar_radio,sum(jp.Pelaut) as pelaut,sum(jp.Peneliti) as peneliti,sum(jp.Satpam_Security) as satpam_security,sum(jp.Wakil_Gubernur) as wakil_gubernur,sum(jp.Bupati_walikota) as bupati_walikota,sum(jp.Akuntan) as akuntan,sum(jp.Biarawati) as biarawati")
    	->first();

    	$max=array_map('static::toNumber',$max);
    	(arsort($max));



      $series=[
		[ 'name'=>'PETANI', 'data'=>[], ],
		[ 'name'=>'BURUH TANI', 'data'=>[], ],
		[ 'name'=>'BURUH MIGRAN', 'data'=>[], ],
		[ 'name'=>'PEGAWAI NEGERI SIPIL', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN', 'data'=>[], ],
		[ 'name'=>'PEDAGANG BARANG KELONTONG', 'data'=>[], ],
		[ 'name'=>'PETERNAK', 'data'=>[], ],
		[ 'name'=>'NELAYAN', 'data'=>[], ],
		[ 'name'=>'MONTIR', 'data'=>[], ],
		[ 'name'=>'DOKTER SWASTA', 'data'=>[], ],
		[ 'name'=>'PERAWAT SWASTA', 'data'=>[], ],
		[ 'name'=>'BIDAN SWASTA', 'data'=>[], ],
		[ 'name'=>'AHLI PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'TNI', 'data'=>[], ],
		[ 'name'=>'POLRI', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA KECIL MENENGAH DAN BESAR', 'data'=>[], ],
		[ 'name'=>'GURU SWASTA', 'data'=>[], ],
		[ 'name'=>'DOSEN SWASTA', 'data'=>[], ],
		[ 'name'=>'SENIMAN ARTIS', 'data'=>[], ],
		[ 'name'=>'PEDAGANG KELILING', 'data'=>[], ],
		[ 'name'=>'PENAMBANG', 'data'=>[], ],
		[ 'name'=>'TUKANG KAYU', 'data'=>[], ],
		[ 'name'=>'TUKANG BATU', 'data'=>[], ],
		[ 'name'=>'TUKANG CUCI', 'data'=>[], ],
		[ 'name'=>'PEMBANTU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PENGACARA', 'data'=>[], ],
		[ 'name'=>'NOTARIS', 'data'=>[], ],
		[ 'name'=>'DUKUN TRADISIONAL', 'data'=>[], ],
		[ 'name'=>'ARSITEKTUR DESAINER', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN SWASTA', 'data'=>[], ],
		[ 'name'=>'KARYAWAN PERUSAHAAN PEMERINTAH', 'data'=>[], ],
		[ 'name'=>'WIRASWASTA', 'data'=>[], ],
		[ 'name'=>'KONSULTAN MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'TIDAK MEMPUNYAI PEKERJAAN TETAP', 'data'=>[], ],
		[ 'name'=>'BELUM BEKERJA', 'data'=>[], ],
		[ 'name'=>'PELAJAR', 'data'=>[], ],
		[ 'name'=>'IBU RUMAH TANGGA', 'data'=>[], ],
		[ 'name'=>'PURNAWIRAWAN PENSIUNAN', 'data'=>[], ],
		[ 'name'=>'PERANGKAT DESA', 'data'=>[], ],
		[ 'name'=>'BURUH HARIAN LEPAS', 'data'=>[], ],
		[ 'name'=>'PEMILIK PERUSAHAAN', 'data'=>[], ],
		[ 'name'=>'PENGUSAHA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'BURUH JASA PERDAGANGAN HASIL BUMI', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA TRANSPORTASI DAN PERHUBUNGAN', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA INFORMASI DAN KOMUNIKASI', 'data'=>[], ],
		[ 'name'=>'KONTRAKTOR', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA JASA HIBURAN DAN PARIWISATA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'BURUH USAHA HOTEL DAN PENGINAPAN LAINNYA', 'data'=>[], ],
		[ 'name'=>'PEMILIK USAHA WARUNG RUMAH MAKAN DAN RESTORAN', 'data'=>[], ],
		[ 'name'=>'DUKUN PARANORMAL SUPRANATURAL', 'data'=>[], ],
		[ 'name'=>'JASA PENGOBATAN ALTERNATIF', 'data'=>[], ],
		[ 'name'=>'SOPIR', 'data'=>[], ],
		[ 'name'=>'USAHA JASA PENGERAH TENAGA KERJA', 'data'=>[], ],
		[ 'name'=>'JASA PENYEWAAN PERALATAN PESTA', 'data'=>[], ],
		[ 'name'=>'PEMULUNG', 'data'=>[], ],
		[ 'name'=>'PENGRAJIN INDUSTRI RUMAH TANGGA LAINNYA', 'data'=>[], ],
		[ 'name'=>'TUKANG ANYAMAN', 'data'=>[], ],
		[ 'name'=>'TUKANG JAHIT', 'data'=>[], ],
		[ 'name'=>'TUKANG KUE', 'data'=>[], ],
		[ 'name'=>'TUKANG RIAS', 'data'=>[], ],
		[ 'name'=>'TUKANG SUMUR', 'data'=>[], ],
		[ 'name'=>'JASA KONSULTANSI MANAJEMEN DAN TEKNIS', 'data'=>[], ],
		[ 'name'=>'JURU MASAK', 'data'=>[], ],
		[ 'name'=>'KARYAWAN HONORER', 'data'=>[], ],
		[ 'name'=>'PIALANG', 'data'=>[], ],
		[ 'name'=>'PSKIATER PSIKOLOG', 'data'=>[], ],
		[ 'name'=>'WARTAWAN', 'data'=>[], ],
		[ 'name'=>'TUKANG CUKUR', 'data'=>[], ],
		[ 'name'=>'TUKANG LAS', 'data'=>[], ],
		[ 'name'=>'TUKANG GIGI', 'data'=>[], ],
		[ 'name'=>'TUKANG LISTRIK', 'data'=>[], ],
		[ 'name'=>'PEMUKA AGAMA', 'data'=>[], ],
		[ 'name'=>'ANGGOTA LEGISLATIF', 'data'=>[], ],
		[ 'name'=>'KEPALA DAERAH', 'data'=>[], ],
		[ 'name'=>'APOTEKER', 'data'=>[], ],
		[ 'name'=>'PRESIDEN', 'data'=>[], ],
		[ 'name'=>'WAKIL PRESIDEN', 'data'=>[], ],
		[ 'name'=>'ANGGOTA MAHKAMAH KONSTITUSI', 'data'=>[], ],
		[ 'name'=>'ANGGOTA KABINET KEMENTRIAN', 'data'=>[], ],
		[ 'name'=>'DUTA BESAR', 'data'=>[], ],
		[ 'name'=>'GUBERNUR', 'data'=>[], ],
		[ 'name'=>'WAKIL BUPATI', 'data'=>[], ],
		[ 'name'=>'PILOT', 'data'=>[], ],
		[ 'name'=>'PENYIAR RADIO', 'data'=>[], ],
		[ 'name'=>'PELAUT', 'data'=>[], ],
		[ 'name'=>'PENELITI', 'data'=>[], ],
		[ 'name'=>'SATPAM SECURITY', 'data'=>[], ],
		[ 'name'=>'WAKIL GUBERNUR', 'data'=>[], ],
		[ 'name'=>'BUPATI WALIKOTA', 'data'=>[], ],
		[ 'name'=>'AKUNTAN', 'data'=>[], ],
		[ 'name'=>'BIARAWATI', 'data'=>[], ],
        

      ];

      foreach ($data as $key => $value) {
        
		$series[0]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->petani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[1]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_tani, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[2]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_migran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[3]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pegawai_negeri_sipil, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[4]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[5]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_barang_kelontong, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[6]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peternak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[7]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->nelayan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[8]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->montir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[9]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dokter_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[10]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perawat_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[11]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bidan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[12]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ahli_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[13]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tni, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[14]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->polri, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[15]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_kecil__menengah_dan_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[16]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->guru_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[17]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dosen_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[18]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->seniman_artis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[19]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pedagang_keliling, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[20]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penambang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[21]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kayu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[22]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_batu, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[23]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cuci, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[24]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pembantu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[25]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengacara, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[26]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->notaris, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[27]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_tradisional, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[28]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->arsitektur_desainer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[29]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_swasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[30]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_perusahaan_pemerintah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[31]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wiraswasta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[32]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->konsultan_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[33]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tidak_mempunyai_pekerjaan_tetap, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[34]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->belum_bekerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[35]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelajar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[36]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->ibu_rumah_tangga, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[37]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->purnawirawan_pensiunan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[38]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->perangkat_desa, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[39]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_harian_lepas, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[40]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_perusahaan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[41]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengusaha_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[42]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_jasa_perdagangan_hasil_bumi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[43]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[44]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_transportasi_dan_perhubungan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[45]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[46]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_informasi_dan_komunikasi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[47]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kontraktor, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[48]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[49]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_jasa_hiburan_dan_pariwisata, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[50]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[51]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->buruh_usaha_hotel_dan_penginapan_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[52]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemilik_usaha_warung__rumah_makan_dan_restoran, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[53]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->dukun_paranormal_supranatural, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[54]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_pengobatan_alternatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[55]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->sopir, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[56]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->usaha_jasa_pengerah_tenaga_kerja, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[57]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_penyewaan_peralatan_pesta, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[58]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemulung, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[59]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pengrajin_industri_rumah_tangga_lainnya, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[60]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_anyaman, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[61]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_jahit, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[62]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_kue, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[63]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_rias, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[64]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_sumur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[65]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->jasa_konsultansi_manajemen_dan_teknis, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[66]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->juru_masak, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[67]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->karyawan_honorer, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[68]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pialang, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[69]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pskiater_psikolog, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[70]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wartawan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[71]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_cukur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[72]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_las, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[73]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_gigi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[74]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->tukang_listrik, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[75]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pemuka_agama, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[76]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_legislatif, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[77]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->kepala_daerah, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[78]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->apoteker, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[79]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[80]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_presiden, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[81]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_mahkamah_konstitusi, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[82]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->anggota_kabinet_kementrian, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[83]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->duta_besar, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[84]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[85]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_bupati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[86]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pilot, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[87]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->penyiar_radio, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[88]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->pelaut, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[89]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->peneliti, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[90]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->satpam_security, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[91]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->wakil_gubernur, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[92]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->bupati_walikota, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[93]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->akuntan, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];
		$series[94]['data'][]=[ 'name'=>$value->name, 'y'=>(float)$value->biarawati, 'satuan'=>'Jiwa','id'=>$value->id, 'route'=>route('d.pekerjaan.chart.k',['kodepemda'=>$value->id]) ];

         
      }

      return view('chart.max_pekerjaan')->with(['max'=>$max,'title'=>$title_max])->render().view('chart.table')->with(['series'=>$series,'title'=>$title])->render();


    }
}
