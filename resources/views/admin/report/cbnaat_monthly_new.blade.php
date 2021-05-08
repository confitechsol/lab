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

                                            <h6>CBNAAT Monthly Report   </h6>
                                            <hr>
                                            <style>
                                            table, th, td {
                                                border: 1px solid black;
                                            }
                                            .card-block {
                                                  width: inherit;
                                                  overflow-x: auto;
                                              }
                                            </style>
                                            <?php// dd($data['cbnaat_lab_details']); die; ?>
                                          <div style="margin-bottom:2%;">
                                            <form method="get" action="{{ route('reports.cbnaat.monthly') }}">
                                              
                                               <div class="form-group col-sm-12">
											      <label class="col-sm-4"><b>Reporting year:</b></label>
												  <input type="text" name="reporting_year" id="reporting_year" class="form-control col-md-6" value="{{ $currentyear }}" placeholder="{{$currentyear }}" onkeydown="return ( event.ctrlKey || event.altKey 
						|| (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
						|| (95<event.keyCode && event.keyCode<106)
						|| (event.keyCode==8) || (event.keyCode==9) 
						|| (event.keyCode>34 && event.keyCode<40) 
						|| (event.keyCode==46) )" maxlength="4"/>
					                         </div>
					                        <div class="form-group col-sm-12">
												  <label for="LPA" class="col-sm-4"><b>CBNAAT Machine Serial No</b></label>
												  <select class="form-control col-md-6" name="serial_no" required="required">
													<option value="0">All</option>
													@foreach( $serial_no_drp as $serno )
													<option value="{{$serno->serial_no}}" <?php if(!empty($_REQUEST['serial_no']) && $_REQUEST['serial_no']==$serno->serial_no){ ?> selected <?php } ?>>{{$serno->serial_no}}</option>
                                                    @endforeach													
												  </select>
											</div>
                                              <p><input class="btn btn-primary" type="submit"/></p>
                                            </form>
                                          </div>
                                          <a style="margin-right:2%;color:white;cursor:pointer;padding:15px; margin-bottom:2%;"  onclick="fnExcelReport();" class="btn btn-primary">Excel</a>
                                          <a style="margin-right:2%; color:white; padding:15px;margin-bottom:2%;" onclick="demoFromHTML();" class="btn btn-primary">Pdf</a>
                                          <div id="pdf_bind">
										     
                                            <table id="result"  class="tg" cellspacing="0" border="0">
											    <tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Name of the CBNAAT Laboratory:</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{$lab_details->lab_name}}</font></b></td>
												</tr>
												<tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Address:</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{$lab_details->address}}</font></b></td>
												</tr>
												<tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Contact Details(Name,contact no. & Email ID):</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{$lab_details->micro_name.', '.$lab_details->micro_number.', '.$lab_details->micro_email}}</font></b></td>
												</tr>
												<tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Serial No of the machine:</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000"><?php echo !empty($_REQUEST['serial_no'])?$_REQUEST['serial_no']:"All"; ?></font></b></td>
												</tr>
												<tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Date of last calibration:</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000"></font></b></td>
												</tr>
												<tr>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="10" height="21" align="left"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">Reporting year:</font></td>
												    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="12" align="center" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{ $currentyear }}</font></b></td>
												</tr>
                                                <tr>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign="bottom"><font face="Bookman Old Style" size="3" color="#000000">S.No.</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="9" align="center" valign="top" bgcolor="#000000"><b><font face="Bookman Old Style" size="3" color="#000000"><br></font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Jan </font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Feb</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Mar</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Apr</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">May</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Jun</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Jul</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Aug</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Sep</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Oct</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Nov</font></b></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><b><font face="Bookman Old Style" size="3" color="#000000">Dec</font></b></td>
                                            	</tr>

                                                <?php 
												 $var_colspan9_arr=array(1,2,3,4,5,6,7,8,33,34,35,36,37);
												 $var_colspan6_arr=array(27,28,29,30,31,32);
												 $var_colspan3_arr=array(9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26);
                                                 $var_rowspan9to17_arr=array(9,10,11,12,13,14,15,16);
												 $var_rowspan18to26_arr=array(18,19,20,21,22,23,24,25);
												 $var_rowspan27to29_arr=array(27,28);
												 $var_rowspan30to32_arr=array(30,31);
												 
												 $var_rowspan2_9to11_arr=array(9,10);
												 $var_rowspan2_12to14_arr=array(12,13);
												 $var_rowspan2_15to17_arr=array(15,16);
												 $var_rowspan2_18to20_arr=array(18,19);
												 $var_rowspan2_21to23_arr=array(21,22);
												 $var_rowspan2_24to26_arr=array(24,25);
												 ?>
												@foreach( $cbnaat_mnth_rpt_data as $cbnaat_mnth_data )
                                            	<tr>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->slno }}</font></td>
                                                    
                                            		<td style="border-top: 1px solid #000000; <?php if(in_array($cbnaat_mnth_data->slno,$var_rowspan9to17_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan18to26_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan27to29_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan30to32_arr)){ ?>border-bottom: 1px solid #FFFFFF;<?php }else{ ?>border-bottom: 1px solid #000000;<?php } ?> border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="<?php if(in_array($cbnaat_mnth_data->slno,$var_colspan9_arr)){ ?>9<?php }if(in_array($cbnaat_mnth_data->slno,$var_colspan6_arr)){ ?>6<?php }if(in_array($cbnaat_mnth_data->slno,$var_colspan3_arr)){ ?>3<?php } ?>" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{ $cbnaat_mnth_data->text1 }}</font></b></td>
                                                    @if(in_array($cbnaat_mnth_data->slno,$var_colspan3_arr))
													<td style="border-top: 1px solid #000000; <?php if(in_array($cbnaat_mnth_data->slno,$var_rowspan2_9to11_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan2_12to14_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan2_15to17_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan2_18to20_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan2_21to23_arr)||in_array($cbnaat_mnth_data->slno,$var_rowspan2_24to26_arr)){ ?>border-bottom: 1px solid #FFFFFF;<?php }else{ ?>border-bottom: 1px solid #000000;<?php } ?> border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{ $cbnaat_mnth_data->text2 }}</font></b></td>
                                            		@endif
													@if(in_array($cbnaat_mnth_data->slno,$var_colspan3_arr)||in_array($cbnaat_mnth_data->slno,$var_colspan6_arr))
													<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="left" valign="middle" bgcolor="#FFFFFF"><b><font face="Bookman Old Style" size=3 color="#000000">{{ $cbnaat_mnth_data->text3 }}</font></b></td>
													@endif
													<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Jan }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Feb }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Mar }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Apr }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->May }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Jun }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Jul }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Aug }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Sep }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Oct }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->Nov }}</font></td>
                                            		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="center"  sdval="1" sdnum="16393;"><font face="Bookman Old Style" size="3" color="#000000">{{ $cbnaat_mnth_data->TDec }}</font></td>
                                            	</tr>
                                                @endforeach

                                            
                                            	
                                            </table>
</div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <footer class="footer">  </footer>

        </div>
        <script>
        // $(document).ready(function() {
        //     $('#result').DataTable({
        //       searching: false,
        //       paging: false,
        //       ordering: false,
        //       dom: 'Bfrtip',
        //         buttons: [
        //             'excel','pdf'
        //         ]
        //     });
        // } );


        function fnExcelReport()
		{
			var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
			var textRange; 
			var j=0;
			tab = document.getElementById('result'); // id of table

			for(j = 0 ; j < tab.rows.length ; j++)
			{
				tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
				//tab_text=tab_text+"</tr>";
			}

			tab_text=tab_text+"</table>";
			tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
			tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
			tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // removes input params

			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
			{
				txtArea1.document.open("txt/html","replace");
				txtArea1.document.write(tab_text);
				txtArea1.document.close();
				txtArea1.focus();
				sa=txtArea1.document.execCommand("SaveAs","CBNAAT.xls");
			}
			else{                //other browser not tested on IE 11
				//sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
				sa ='data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
				var link = document.createElement("a");
				document.body.appendChild(link);
				var today = new Date();
				var day = today.getDate();
				day = day < 10 ? '0' + day : day;
				var time = day + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
				link.download = 'LIMS_<?php echo this_lab()->name; ?>CBNAAT_Monthly_Report_'+ time +'.xls'; //You need to change file_name here.
				link.href = sa;
				link.click();
            }
			return (sa);
		}
        </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

        <script type="text/javascript">
        function demoFromHTML() {
			var pdf = new jsPDF('p', 'pt', 'letter');

			pdf.cellInitialize();
			pdf.setFontSize(5);
			$.each( $('#result tr'), function (i, row){
				$.each( $(row).find("td, th"), function(j, cell){
					var txt = $(cell).text().trim() || " ";
					var width = (j==5) ? 20 : 15; //make 5th column smaller
					width= (j==1) ? 150 : 35;
					pdf.cell(5,50, width, 30, txt, i);
				});
			});
            var reporting_year=$("#reporting_year").val();
			pdf.save('CBNAAT-Monthly-Report_'+reporting_year+'.pdf');
		}
     </script>
    @endsection
