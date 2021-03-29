@extends('vendor.adminlte.dashboard')

@section('content')

<div class="box box-primary">
	 <div class="box-header with-border">
    <h5 class="text-center"><b>TINGKAT PENDIDIKAN</b></h5>
    
    
  </div>
	<div class="box-body table-responsive" style="position: relative; max-height: 400px;">
		<div class="btn-group" style="margin-bottom: 5px;">
					     	     
      <button type="button" onclick="exportExcelTable('#table-table_1200948','TINGKAT PENDIDIKAN');" class="btn btn-success btn-sm">Download Excel</button>
          </div>
			
			<div style="max-height: 400px; overflow: scroll;">
				<table class="table table-bordered sticky-table" id="table-table_1200948">
				<thead>
					<tr>
						
						
						<th rowspan="2">AKSI</th>
																<th rowspan="2">KODEDAERAH</th>
						<th rowspan="2">NAMA PROVINSI</th>
											<th rowspan="2">JUMLAH DESA</th>
						<th rowspan="2">JUMLAH DESA TERDATA</th>
											
						<th colspan="2">JUMLAH TIDAK SEKOLAH</th>
						
						<th colspan="2">JUMLAH SETINGKAT SMP</th>
						
						<th colspan="2">JUMLAH SETINGKAT SMA</th>
						
						<th colspan="2">JUMLAH PERGURUAN TINGGI</th>
											

					</tr>
					<tr>
						
						<th>NILAI</th>
						<th>SATUAN</th>

						
						<th>NILAI</th>
						<th>SATUAN</th>

						
						<th>NILAI</th>
						<th>SATUAN</th>

						
						<th>NILAI</th>
						<th>SATUAN</th>

										</tr>
				</thead>
				<tbody style="max-height: 300px; overflow: scroll;">
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=11')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>11</td>
						<td>ACEH</td>
													<td>6.497</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=12')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>12</td>
						<td>SUMATERA UTARA</td>
													<td>6.110</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=13')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>13</td>
						<td>SUMATERA BARAT</td>
													<td>1.173</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=14')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>14</td>
						<td>RIAU</td>
													<td>1.860</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=15')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>15</td>
						<td>JAMBI</td>
													<td>1.562</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=16')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>16</td>
						<td>SUMATERA SELATAN</td>
													<td>3.240</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=17')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>17</td>
						<td>BENGKULU</td>
													<td>1.513</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=18')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>18</td>
						<td>LAMPUNG</td>
													<td>2.640</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=19')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>19</td>
						<td>KEPULAUAN BANGKA BELITUNG</td>
													<td>391</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=21')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>21</td>
						<td>KEPULAUAN RIAU</td>
													<td>416</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=31')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>31</td>
						<td>DKI JAKARTA</td>
													<td>267</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=32')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>32</td>
						<td>JAWA BARAT</td>
													<td>5.957</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=33')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>33</td>
						<td>JAWA TENGAH</td>
													<td>8.562</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=34')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>34</td>
						<td>DAERAH ISTIMEWA YOGYAKARTA</td>
													<td>438</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=35')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>35</td>
						<td>JAWA TIMUR</td>
													<td>8.501</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=36')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>36</td>
						<td>BANTEN</td>
													<td>1.551</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=51')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>51</td>
						<td>BALI</td>
													<td>716</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=52')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>52</td>
						<td>NUSA TENGGARA BARAT</td>
													<td>1.140</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=53')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>53</td>
						<td>NUSA TENGGARA TIMUR</td>
													<td>3.353</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=61')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>61</td>
						<td>KALIMANTAN BARAT</td>
													<td>2.130</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=62')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>62</td>
						<td>KALIMANTAN TENGAH</td>
													<td>1.572</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=63')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>63</td>
						<td>KALIMANTAN SELATAN</td>
													<td>2.009</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=64')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>64</td>
						<td>KALIMANTAN TIMUR</td>
													<td>1.038</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=65')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>65</td>
						<td>KALIMANTAN UTARA</td>
													<td>482</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=71')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>71</td>
						<td>SULAWESI UTARA</td>
													<td>1.840</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=72')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>72</td>
						<td>SULAWESI TENGAH</td>
													<td>2.017</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=73')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>73</td>
						<td>SULAWESI SELATAN</td>
													<td>3.048</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=74')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>74</td>
						<td>SULAWESI TENGGARA</td>
													<td>2.299</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=75')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>75</td>
						<td>GORONTALO</td>
													<td>729</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=76')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>76</td>
						<td>SULAWESI BARAT</td>
													<td>649</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=81')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>81</td>
						<td>MALUKU</td>
													<td>1.233</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=82')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>82</td>
						<td>MALUKU UTARA</td>
													<td>1.181</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=91')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>91</td>
						<td>PAPUA BARAT</td>
													<td>1.837</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
														<tr>
											
							<td>
								<button onclick="get_data('#dom_l_2','http://localhost/pemdeskel/api/d/2020/visulisasi-p-table/1/ddk_pendidikan?kdparent=94')" type="button" class="btn btn-primary btn-xs background-blue"><i class="fa fa-eye"></i> Detail</button>
							</td>
												

						<td>94</td>
						<td>P A P U A</td>
													<td>5.521</td>
						<td>0</td>

										
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					
					<td>0</td>
					<td>Jiwa</td>

					


					</tr>
				</tbody>
			</table>
			</div>
	</div>
	<script type="text/javascript">
			$('#table-table_1200948').floatThead({
				'position':'auto'

			});
			console.log('float run');
		</script>
</div>
@stop