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
                                      <form name="frmannex" id="anxr15l">
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            Year <span>*</span>
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="number" name="year" class="form-control"  value="" id="year" min="2020" max="2050" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                          </div>
                                          <div class="col-sm-1">
                                            Select Quarter <span>*</span>
                                          </div>
                                          <div class="col-sm-11">
                                            <select name="quarter" class="form-control" id="quarter" required>
												<option value="">--Select Quarter--</option>
												@foreach ($data['quarter'] as $quarter)
													<option value="{{ $quarter->quarter_no }}">{{ $quarter->quarter_name }}</option>													
												@endforeach
											</select>
                                          </div>
										  <div class="col-sm-1">
                                            Select Month(s) <span>*</span>
                                          </div>
                                          <div class="col-sm-11">
                                            <select name="quarter_months[]" class="form-control" id="quarter_months" multiple required>
												<option value="">--Select Month--</option>												
											</select>
                                          </div>
                                          <div class="col-sm-12">
                                            <button type="button" class="btn btn-info" id="btnSubmit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Show</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    
                                            <!---------------------------->
									<div class="container search-table-outter">
										<h2 align="center" style="font-family:Lucida Console;">FL-LPA PROBE REGISTER</h2>


										<h4 id="period" align="center" style="display: none;"><u>Period: <span id="sp_qt_no"></span> ( <span id="sp_month_name"></span> ) of <span id="sp_year"></span></u></h4>


										<a style="padding: 5px 15px;
											border-radius: 4px;
											background: #008000;
											color: #ffffff;
											margin-right: 3px; cursor:pointer;" onclick="fnExcelReport();">Excel</a>
										<br> <br>

										 {{-- {{ dd($data) }}  --}}

										<table id="result1" class="tg">  
											<tr>
												<td colspan="6" width="545">Patient    Details</td>
												<td width="98">Direct/</td>
												<td width="102">TUB</td>
												<td colspan="13" width="1121">RpoB  </td>
												<td colspan="4" width="412">KatG </td>
												<td colspan="7" width="712">InhA </td>
												<td colspan="4" width="373">Interpretation</td>
												<td width="212">Final</td>
												<td width="220">Clinical</td>
												<td rowspan="2" width="170">Sample collection date</td>
												<td rowspan="2" width="157">Sample receipt date</td>
												<td rowspan="2" width="114">Date of result</td>
												<td rowspan="2" width="126">Result hit to Nikshay</td>
											  </tr>
											  <tr>
												<td>Enrolment No.</td>
												<td>LIMS Sample No</td>
												<td>Nikshay ID</td>
												<td>State</td>
												<td colspan="2">District</td>
												<td>Indirect</td>
												<td>Band</td>
												<td width="144">Locus Control</td>
												<td>WT1</td>
												<td>WT2</td>
												<td>WT3</td>
												<td>WT4</td>
												<td>WT5</td>
												<td>WT6</td>
												<td>WT7</td>
												<td>WT8</td>
												<td>MUT1(D516V)</td>
												<td>MUT2A(H526Y)&nbsp;</td>
												<td>MUT2B(H526D)</td>
												<td>MUT3(S531L) </td>
												<td>Locus Control</td>
												<td>WT1(315) </td>
												<td>MUT1(S315T1)</td>
												<td>MUT2(S315T2)</td>
												<td>Locus Control</td>
												<td>WT1(-15,-16)</td>
												<td>WT2(-8)</td>
												<td>MUT1(C15T) </td>
												<td>MUT2(A16G) </td>
												<td>MUT3A(T8C) </td>
												<td>MUT3B(T8A)</td>
												<td>MTB Result </td>
												<td>RIF Resi</td>
												<td>KatG Resi</td>
												<td>H Resi</td>
												<td>Interpretation</td>
												<td>Interpretation</td>
											  </tr>						
											
										  </table>
									</div>

											<!------------------------------>

                                     
                                </div>



                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <footer class="footer">  </footer>

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

			$( document ).ready(function() {

				$('#btnSubmit').on('click', function() {

					var quarter_wise_month = [];
					var year = "";
					var quarter_no = "";
					var len = 0;
					var quarter_month = "";
					var quarter_month_text = [];
					

					year = $('#year').val();
					quarter_no = $('#quarter').val();

					$.each($("#quarter_months option:selected"), function(){            
						quarter_wise_month.push($(this).val());
						quarter_month_text.push($(this).text());
					});

					//console.log(quarter_month_text);

					if( quarter_wise_month.length > 0 )
					{
						len = quarter_wise_month.length;						
					}					

					if( year == ""  || quarter_no == "" || len <= 0 )
					{

						$('#sp_qt_no').html("");
						$('#sp_month_name').html("");
						$('#sp_year').html("");						
						$('#period').hide();
						$('#result1 #dataRow').remove();						

					} else {
					
						$('#sp_qt_no').html( $('#quarter option:selected').text() );
						$('#sp_month_name').html( quarter_month_text.join(", ") );
						$('#sp_year').html( $('#year').val() );
						$('#period').show();

						quarter_month = quarter_wise_month.join(", ");

						$.ajax({
							type: "POST",
							dataType:"html",							
							data: { "_token": "{{ csrf_token() }}", "year": year, "quarter_no": quarter_no, "quarter_wise_month": quarter_month },
							url: "{{ route('ajax-fl-lpa') }}",
							
							success: function (response) {

								$('#result1 #dataRow').remove();
								$('#result1').append(response);
								//$('#annex_data').html(response);
							
							}
						});

					}
					
				});

				$('#year').change(function() {
				var n = $('#year').val();
				if (n < 2020)
					$('#year').val('2020');
				if (n > 2050)
					$('#year').val('2050');
				});

				$('#year').blur(function() {

				var n = $('#year').val();
				if (n < 2020)
					$('#year').val('2020');
				if (n > 2050)
					$('#year').val('2050');

				});

				$('#quarter').on('change', function() {

					var quarter = $(this).val();

					$.ajax({
						url: '/getQuarterWiseMonth/'+quarter,
						type: 'GET',
						dataType: 'html',
						success: function(response){
							console.log(response);
							var len = 0;
							if(response != null){
								
								$('#quarter_months')
								.empty()
								.append(response);
							}							
						},
						failure: function(response){
							alert("failure");

						}
					});

				})

			});
       </script>
    @endsection
