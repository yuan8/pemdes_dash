<h3 class="text-center">LEMBAR PENGESAHAN  {{$table_map['data_name']}} TAHUN {{$GLOBALS['tahun_access']}} </h3>
	<br>
	<hr>
	<p class="text-uppercase">Berita Acara Pelaporan data <b>"{{$table_map['data_name']}}"</b> disusun sebagai laporan capaian <b>{{strtoupper($daerah['nama_daerah'])}}</b> pada tahun <b>{{$GLOBALS['tahun_access']}}</b></p>
	<p class="text-uppercase">YAANG TELAH DIIKUKTI OLEH <b> {{HPV::nformat($total['jumlah_desa_melapor'])}} / {{HPV::nformat($total['jumlah_desa'])}} DESA TERDAFTAR</b>   YANG DI PEROLEH DARI <b>{{HPV::nformat(count($data['data']))}} / {{HPV::nformat($count_kecamatan)}} KECAMATAN.</b></p>