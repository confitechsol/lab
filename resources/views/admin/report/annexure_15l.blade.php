@extends('admin.layout.app')
@section('content')
<link href="{{ url('https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ url('https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js') }}"></script>
        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                <div class="card" >
                                    <div class="card-block">
									 <!----------loader------------>
									<div id="pageloader">
									  <div class="loader"></div>
									</div>
									<!----------loader------------>
                                      <form method="post" action="{{ url('/report/annexurel') }}" id="anxr15l">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            From:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="from_date"  value="{{$data['from_date']}}" id="from_date" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-1">
                                            To:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="to_date" id="to_date" value="{{ $data['to_date'] }}" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-12">
                                            <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Generate</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    
                                            <!---------------------------->
									<div class="container search-table-outter">
										<h2 align="center" style="font-family:Lucida Console;">TB Laboratory Register</h2>


										<h4 align="center"><u>Sample Registrar Details</u></h4>


										<a style="padding: 5px 15px;
											border-radius: 4px;
											background: #009efb;
											color: #ffffff;
											margin-right: 3px; cursor:pointer;" onclick="fnExcelReport();">Excel for Sample Registrar Details</a>
										<br> <br>

										<table id="result1" class="tg">


											<tr>
												<th class="tg-yw4l" rowspan="3"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;text-align:center;">Lab Serial No.</span></th>
												<th class="tg-yw4l" rowspan="3">NIKSHAY ID</th>
												<!-- <th class="tg-yw4l" rowspan="3">Date of colllection of first specimen</th> -->
												<th class="tg-yw4l" style="text-align:center;" rowspan="3">Patient's full name (Address/contact details)</th>
												<th class="tg-yw4l" rowspan="3">Age</th>
												<th class="tg-yw4l" rowspan="3"><span
															style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Gender (M/F/TG)</span>
												</th>
												<th class="tg-yw4l" rowspan="3">Key Population</th>
												<!-- <th class="tg-yw4l" rowspan="3">Complete Address</th> -->
												<th class="tg-yw4l" style="text-align:center;" rowspan="3">Name of referring health facility</th>
												<th class="tg-yw4l" style="text-align:center;" colspan="5">Reasons for Testing</th>
												<!-- <th class="tg-yw4l" colspan="3">Date</th> -->
												<th class="tg-yw4l" style="text-align:center;" colspan="3">Date</th>
												<th class="tg-yw4l" style="text-align:center;" rowspan="3">Type(Sputum/other-specify)</th>
												<th class="tg-yw4l" rowspan="3">Specimen Condition ( M/B/S/C)</th>
												<th class="tg-yw4l" rowspan="3">C&DST Lab Microscopy Result</th>



												<!-- =============== -->
												<!-- Result Headings -->
												<!-- =============== -->

												<th class="tg-031e" style="text-align:center;" colspan="10">Rapid DST Results</th>
												<th class="tg-031e" style="text-align:center;" colspan="3">Culture Results</th>
												<th class="tg-031e" style="text-align:center;" colspan="24">Reporting of Results</th>

												<!-- ===================== -->
												<!-- Result Headings - END -->
												<!-- ===================== -->

											</tr>
											<tr>
												<td class="tg-yw4l" style="text-align:center;" colspan="3">Diagnosis/DST</td>
												<td class="tg-yw4l" style="text-align:center;" colspan="2">Follow-up</td>
												<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen Collection</span>
												</td>
												<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen sent to lab</span>
												</td>
												<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen receipt at laboratory</span>
												</td>
												<!-- <td class="tg-yw4l"></td>
												<td class="tg-yw4l"></td> -->


												<!-- =============== -->
												<!-- Result Headings -->
												<!-- =============== -->

												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Test performed (FL-LPA/SL-LPA/CBNAAT)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Valid* (Y/N)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">TB + (Y/N)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">RIF</span>
												</td>
											   
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH(InhA)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH(KatG)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">FQ class resistance (ND/D)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">SLI class (resi)</span></td>
                                                 <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">SLID(eis)</span></td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Type (LJ/LC)</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Results</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt </span>
												</td>

												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Rifampicin</span>
												</td>
												<td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.1</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.4</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Streptomycin</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethambutol</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Pyrazinamide</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Kanamycin</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Capreomycin</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Amicacin</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Levofloxacin</span>
												</td>

												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (0.25)</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (1.0)</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethionamide</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">PAS</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Linezolid</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clofazimine</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Bedaquiline</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Delamanid</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Azythromycin</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clarithromycin</span>
												</td>
												<!-- <td class="tg-yw4l" rowspan="2"><span
															style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;"></span></td> -->
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting culture result</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting DST result</span>
												</td>
												<td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Remarks</span>
												</td>


												<!-- ===================== -->
												<!-- Result Headings - END -->
												<!-- ===================== -->


											</tr>
											<tr>
												<td class="tg-yw4l">New PT</td>
												<td class="tg-yw4l">Presumptive MDR TB</td>
												<td class="tg-yw4l">Predominant symptom and duration</td>
												<td class="tg-yw4l">PMDT TB No</td>
												<td class="tg-yw4l">Month of FU</td>

												<td class="tg-yw4l"></td>
												<td class="tg-yw4l"></td>
												<td class="tg-yw4l"></td>
											</tr>

										   

										   @foreach($data['annexure_data'] as $key=> $anx_data)
												<tr>
													<td class="tg-yw4l">{{ $anx_data->colA }}</td>
													<td class="tg-yw4l">{{ $anx_data->colB }}</td>            
													<td class="tg-yw4l">{{ $anx_data->colC }}</td>
													<td class="tg-yw4l">{{ $anx_data->colD }}</td>
													<td class="tg-yw4l">{{ $anx_data->colE }}</td>
													<td class="tg-yw4l">{{ $anx_data->colF }}</td>           
													<td class="tg-yw4l">{{ $anx_data->colG }}</td>
													<td class="tg-yw4l">{{ $anx_data->colH }}</td>
													<td class="tg-yw4l">{{ $anx_data->colI }}</td>
													<td class="tg-yw4l">{{ $anx_data->colJ }}</td>         
													<td class="tg-yw4l">{{ $anx_data->colK }}</td>
													<td class="tg-yw4l">{{ $anx_data->colL }}</td>
													<td class="tg-yw4l">{{ $anx_data->colM }}</td>
													<td class="tg-yw4l">{{ $anx_data->colN }}</td>
													<td class="tg-yw4l">{{ $anx_data->colO }}</td>
													<td class="tg-yw4l">{{ $anx_data->colP }}</td>
													<td class="tg-yw4l">{{ $anx_data->colQ }}</td>
													<td class="tg-yw4l">{{ $anx_data->colR }}</td>
													<td class="tg-031e">{{ $anx_data->colS }}</td>
													<td class="tg-031e">{{ $anx_data->colT }}</td>
													<td class="tg-031e">{{ $anx_data->colU }}</td>
													<td class="tg-031e">{{ $anx_data->colV }}</td>
													<td class="tg-031e">{{ $anx_data->colW }}</td>
													<td class="tg-031e">{{ $anx_data->colX }}</td>
													<td class="tg-031e">{{ $anx_data->colY }}</td>           
													<td class="tg-031e">{{ $anx_data->colZ }}</td>
													<td class="tg-031e">{{ $anx_data->colAA }}</td>
													<td class="tg-031e">{{ $anx_data->colAB }}</td>
													<td class="tg-031e">{{ $anx_data->colAC }}</td>
													<td class="tg-031e">{{ $anx_data->colAD }}</td>
													<td class="tg-031e">{{ $anx_data->colAE }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAF }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAG }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAH }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAI }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAJ }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAK }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAL }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAM }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAN }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAO }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAP }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAQ }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAR }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAS }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAT }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAU }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAV }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAW }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAX }}</td>
													<td class="tg-yw4l">{{ $anx_data->colAY }}</td>
													<td class="tg-yw4l">{{ $anx_data->colBA }}</td>
													<td class="tg-yw4l">{{ $anx_data->colBB }}</td>
													 <td class="tg-yw4l">{{ $anx_data->colBC }}</td>
												</tr>
											@endforeach	
										</table>



									</div>

											<!------------------------------>

                                     
                                </div>



                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>

        </div>
		<style type="text/css">
			table td, table th {
				border: 1px solid black;
			}

			td {
				width: 34px;
			}

			th {
				width: 76px;
			}
            table {
				border-collapse: collapse;
			}

		   .search-table-outter { overflow-x: scroll; }
			@page {
				size: landscape;
			}
			
#pageloader
{
  background: rgba( 255, 255, 255, 0.8 );
  display: none;
  height: 100%;
  position: fixed;
  width: 100%;
  z-index: 9999;
}

			#pageloader .loader
			{
			  left: 50%;
			  margin-left: -32px;
			  margin-top: -32px;
			  position: absolute;
			  top: 50%;
			}
			.loader {
			  border: 16px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 16px solid blue;
			  border-right: 16px solid green;
			  border-bottom: 16px solid red;
			  border-left: 16px solid pink;
			  width: 120px;
			  height: 120px;
			  -webkit-animation: spin 2s linear infinite;
			  animation: spin 2s linear infinite;
			}

			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
		</style>
		<script>
		  $(document).ready(function(){
			  $("#anxr15l").on("submit", function(){
				$("#pageloader").fadeIn();
			  });//submit
			});//document ready
          function fnExcelReport() {
				var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
				var textRange;
				var j = 0;
				tab = document.getElementById('result1'); // id of table

				for (j = 0; j < tab.rows.length; j++) {
					tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
		//tab_text=tab_text+"</tr>";
				}

				tab_text = tab_text + "</table>";
				tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
				tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
				tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE ");

				if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
				{
					txtArea1.document.open("txt/html", "replace");
					txtArea1.document.write(tab_text);
					txtArea1.document.close();
					txtArea1.focus();
					sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Wlt.xls");
				}
				else                 //other browser not tested on IE 11
					// sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
					var labname='<?php echo this_lab()->name; ?>';
					var data_uri = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
					var today = new Date();
					var day = today.getDate();
					day = day < 10 ? '0' + day : day;
					var time = day + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
					return saveContent( data_uri, 'LIMS_'+labname+'_Annexure15L_' + time + '.xls' );

				return (sa);
			}
			function saveContent(uri, fileName){
				var link = document.createElement('a');
				link.download = fileName;
				link.href = uri;
				link.click();
			}
       </script>
    @endsection
