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
                                            <select name="quarter" id="quarter" class="form-control" required>
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
										<h2 align="center" style="font-family:Lucida Console;">TB Laboratory Register</h2>


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
											  <td rowspan="3" width="111">Lab Serial No.</td>
											  <td rowspan="3" width="98">Sample </td>
											  <td rowspan="3" width="98">NIKSHAY ID</td>
											  <td colspan="6" rowspan="2" width="1065">Patient's full name    (Address/contact details)</td>
											  <td rowspan="3" width="85">Age</td>
											  <td rowspan="3" width="102">Gender (M/F/TG)</td>
											  <td rowspan="3" width="167">Key Population</td>
											  <td rowspan="3" width="296">Name of referring    health facility</td>
											  <td colspan="6" width="691">Reasons    for Testing</td>
											  <td colspan="2" width="186">Date</td>
											  <td rowspan="3" width="98">Type(Sputum/other-specify)</td>
											  <td rowspan="3" width="103">Specimen Condition (    M/B/S/C)</td>
											  <td rowspan="3" width="97">C&amp;DST Lab    Microscopy Result</td>
											  <td rowspan="3" width="123">Method (ZN/FM)</td>
											  <td rowspan="3" width="97">Date of Microscopy Result</td>
											  <td width="261">Test Requested</td>
											  <td colspan="5" width="669">CBNAAT </td>
											  <td width="240">&nbsp;</td>
											  <td width="83">&nbsp;</td>
											  <td colspan="13" width="1745"> FL LPA</td>
											  <td width="87">&nbsp;</td>
											  <td colspan="13" width="1913">SL LPA</td>
											  <td width="83">&nbsp;</td>
											  <td colspan="13" width="1008">Liquid    Culture Results</td>
											  <td colspan="26" width="2246">Solid    Culture Results (to incorporate data captured in LIMS and as per Culture    register format)</td>
											  <td colspan="23" width="2560">Drug Susceptibility Testing </td>
											  <td colspan="19" width="1790">Drug    Susceptibility Testing (2nd test, if done)</td>
											  <td colspan="4" width="414">Field NAAT Result</td>
											</tr>
											<tr>
											  <td colspan="4" width="517">Diagnosis</td>
											  <td colspan="2" width="174">Follow-up</td>
											  <td rowspan="2" width="92">Specimen Collection</td>
											  <td rowspan="2" width="94">Specimen receipt at laboratory</td>
											  <td width="261">(CBNAAT/FLLPA/SLLPA/AFB    Culture/DST/ Sputum Microscopy)</td>
											  <td rowspan="2" width="150">Date of receipt for test </td>
											  <td rowspan="2" width="150">Valid* (Y/N)</td>
											  <td rowspan="2" width="142">TB +    (Y/N)</td>
											  <td rowspan="2" width="134">RIF(D/    ND/NA</td>
											  <td rowspan="2" width="93">Date of    Report submission to NK</td>
											  <td rowspan="2" width="240">Remarks</td>
											  <td rowspan="2" width="83">Direct/Indirect </td>
											  <td rowspan="2" width="97">Date of Decontamination </td>
											  <td rowspan="2" width="101">Date of    DNA Extraction </td>
											  <td width="101">&nbsp;</td>
											  <td rowspan="2" width="101">Date of Hybridization</td>
											  <td rowspan="2" width="111">Valid*    (Y/N)</td>
											  <td rowspan="2" width="115">MTB    (Y/N)</td>
											  <td rowspan="2" width="104">RIF<br />
												(D,ND,I)</td>
											  <td rowspan="2" width="113">INH(InhA)    (D,ND,I)</td>
											  <td rowspan="2" width="116">INH(KatG)D,ND,I)</td>
											  <td rowspan="2" width="219">Test Interpretation</td>
											  <td rowspan="2" width="243">Clinical Interpretation </td>
											  <td rowspan="2" width="97">Date of    Report submission to NK</td>
											  <td rowspan="2" width="227">Remarks</td>
											  <td rowspan="2" width="87">Direct/Indirect</td>
											  <td rowspan="2" width="121">Date of Decontamination </td>
											  <td rowspan="2" width="111">Date    of DNA Extraction </td>
											  <td width="101">&nbsp;</td>
											  <td rowspan="2" width="116">Date of Hybridization</td>
											  <td rowspan="2" width="99">Valid*    (Y/N)</td>
											  <td rowspan="2" width="114">MTB(Y/N)</td>
											  <td rowspan="2" width="109">FQ    class resistance (ND/D/I)</td>
											  <td rowspan="2" width="118">SLI    (resi)<br />
												(ND/D/I)</td>
											  <td rowspan="2" width="161">SLID    (eis)<br />
												(ND/D/I)</td>
											  <td rowspan="2" width="222">Test Interepretation </td>
											  <td rowspan="2" width="196">Clinical interpretation </td>
											  <td rowspan="2" width="120">Date    of Report submission</td>
											  <td rowspan="2" width="325">Remarks</td>
											  <td rowspan="2" width="83">Type    (LC)</td>
											  <td rowspan="2" width="70">Date of Inoculation </td>
											  <td colspan="2" width="158">Flagged MGIT tube</td>
											  <td colspan="2" width="110">Culture    Microscopy</td>
											  <td colspan="2" width="90">BHI</td>
											  <td colspan="2" width="109">ID test </td>
											  <td colspan="2" width="171">Final Results</td>
											  <td rowspan="2" width="102">Date Result Submit to Nikshay</td>
											  <td rowspan="2" width="198">Remarks</td>
											  <td rowspan="2" width="70">Type    (LJ)</td>
											  <td rowspan="2" width="131">Date of Inoculation </td>
											  <td colspan="16" width="1120">Week </td>
											  <td colspan="2" width="170">Culture Microscopy result</td>
											  <td colspan="2" width="135">ID test </td>
											  <td rowspan="2" width="112">Final Results</td>
											  <td width="107">&nbsp;</td>
											  <td rowspan="2" width="103">Date    of Results submission to Nk</td>
											  <td rowspan="2" width="298">Remarks</td>
											  <td rowspan="2" width="85">Date of    Inoculation on DST </td>
											  <td rowspan="2" width="148">Drugs for which inoculated</td>
											  <td rowspan="2" width="76">Rifampicin<br />
												( R )</td>
											  <td rowspan="2" width="82">Isoniazid<br />
												( H )</td>
											  <td rowspan="2" width="90">Streptomycin<br />
												( S )</td>
											  <td rowspan="2" width="79">Ethambutol<br />
												( E )</td>
											  <td rowspan="2" width="74">Kanamycin<br />
												( Km )</td>
											  <td rowspan="2" width="88">Capreomycin<br />
												( Cm )</td>
											  <td rowspan="2" width="63">Amicacin<br />
												( Am )</td>
											  <td rowspan="2" width="85">Levofloxacin<br />
												( Lfx )</td>
											  <td rowspan="2" width="118">Maxifloxacin<br />
												(Mfx[1])</td>
											  <td rowspan="2" width="86">Ethionamide<br />
												( Eto )</td>
											  <td rowspan="2" width="134">PAS</td>
											  <td rowspan="2" width="97">Linezolid<br />
												( Lzd )</td>
											  <td rowspan="2" width="81">Clofazimine<br />
												( Cfz )</td>
											  <td rowspan="2" width="82">Bedaquiline<br />
												( BDQ )</td>
											  <td rowspan="2" width="74">Delamanid<br />
												( Dim )</td>
											  <td rowspan="2" width="80">Date of    reporting DST result</td>
											  <td width="276">&nbsp;</td>
											  <td rowspan="2" width="159">Date of Innoculation Paranzamide (PZA)</td>
											  <td rowspan="2" width="80">PZA Drug</td>
											  <td rowspan="2" width="141">Date of Reporting (PZA)</td>
											  <td rowspan="2" width="282">Remarks</td>
											  <td rowspan="2" width="85">Date of    Inoculation on DST </td>
											  <td rowspan="2" width="85">Drugs for which inoculated</td>
											  <td rowspan="2" width="73">Rifampicin<br />
												( R )</td>
											  <td rowspan="2" width="62">Isoniazid<br />
												( H )</td>
											  <td rowspan="2" width="90">Streptomycin<br />
												( S )</td>
											  <td rowspan="2" width="79">Ethambutol<br />
												( E )</td>
											  <td rowspan="2" width="74">Kanamycin<br />
												( Km )</td>
											  <td rowspan="2" width="107">Capreomycin<br />
												( Cm )</td>
											  <td rowspan="2" width="102">Amicacin<br />
												( Am )</td>
											  <td rowspan="2" width="85">Levofloxacin<br />
												( Lfx )</td>
											  <td rowspan="2" width="118">Maxifloxacin<br />
												(Mfx[1])</td>
											  <td rowspan="2" width="86">Ethionamide<br />
												( Eto )</td>
											  <td rowspan="2" width="66">PAS</td>
											  <td rowspan="2" width="63">Linezolid<br />
												( Lzd )</td>
											  <td rowspan="2" width="81">Clofazimine<br />
												( Cfz )</td>
											  <td rowspan="2" width="82">Bedaquiline<br />
												( BDQ )</td>
											  <td rowspan="2" width="74">Delamanid<br />
												( Dim )</td>
											  <td rowspan="2" width="80">Date of    reporting DST result</td>
											  <td rowspan="2" width="298">Remarks</td>
											  <td rowspan="2" width="64">Valid*    (Y/N)</td>
											  <td rowspan="2">TB + (Y/N)</td>
											  <td rowspan="2" width="105">RIF(D/    ND/NA</td>
											  <td rowspan="2" width="144">Date    of Report submission</td>
											</tr>
											<tr>
											  <td width="176">Full Name </td>
											  <td width="118">TU</td>
											  <td width="95">Taluk</td>
											  <td width="111">District</td>
											  <td width="88">State </td>
											  <td width="477">Address    and Contact </td>
											  <td width="117">New    PT</td>
											  <td width="155">Presumptive    MDR TB</td>
											  <td width="155">Predominant    symptom </td>
											  <td width="90">Duration</td>
											  <td width="100">PMDT    TB No</td>
											  <td width="74">Month    of FU</td>
											  <td width="261">&nbsp;</td>
											  <td width="101">Date of PCR</td>
											  <td width="101">Date of PCR</td>
											  <td width="88">Date    of flagging</td>
											  <td width="70">GU</td>
											  <td colspan="2" width="110">Result</td>
											  <td colspan="2" width="90">Result</td>
											  <td colspan="2" width="109">Result</td>
											  <td width="80">Date</td>
											  <td width="91">Result</td>
											  <td colspan="2" width="140">WK1 </td>
											  <td colspan="2" width="140">WK2 </td>
											  <td colspan="2" width="140">WK3</td>
											  <td colspan="2" width="140">WK4</td>
											  <td colspan="2" width="140">WK5</td>
											  <td colspan="2" width="140">WK6</td>
											  <td colspan="2" width="140">WK7</td>
											  <td colspan="2" width="140">WK8</td>
											  <td colspan="2" width="170">Result</td>
											  <td colspan="2" width="135">Result</td>
											  <td width="107">Final Result    Date</td>
											  <td width="276">Remarks</td>
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
				var tab_text = "<table border='2px'><tr>";
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

						//alert(quarter_wise_month);

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
							url: "{{ route('ajax-annexure15l') }}",
							
							success: function (response) {

								$('#result1 #dataRow').remove();
								$('#result1').append(response);								
							
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
