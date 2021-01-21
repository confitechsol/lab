@extends('admin.layout.app')
@section('content')

    <style>


        .form-group{
            margin-bottom: 1rem;
        }

        table.my_modal tr td {
            border: 1px solid #666;
            text-align: center;
        }

        table.my_modal th {
            border: 1px solid #009efb;
            padding: 10px;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            color: #009efb;
        }

        #progressdetailpopup .modal-title {
            color: #009efb;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
        }

        .search_field {
            height: 0;
            display: inline-block;
            min-height: 29px;
        }

        .detail_modal {

            cursor: pointer;
            color: #028EE1 !important;
        }

        /* Apply styles only for progressdetailpopup modal */
        #progressdetailpopup .modal-dialog {
            max-width: 95%;
            margin: 30px auto;
        }
    </style>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Sample Progress Status</h3>

                </div>
                <div class="col-md-7 col-4 align-self-center">
                <!-- <form action="{{ url('/cbnaat/print') }}" method="post" >

                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample">
                     <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                   </form> -->
                </div>

            </div>


            <div class="row">

                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 ">

                                <div class="row">
                                    <div class="col-sm-3 form-group offset-sm-5">
                                        <input placeholder="Manual Search" type="text"
                                               class="form-control form-control-line search_field"
                                               value=""
                                               id="manual-search"/>
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <input placeholder="BarCode Search" type="text" name="search"
                                               class="form-control form-control-line search_field" value=""
                                               id="search"/>
                                    </div>
                                    <div class="col-sm-1 form-group">
                                        <input style="" type="button" id="srch" class="btn-sm btn-info"
                                               value="search"/>
                                    </div>
                                </div>

                                <div class="table-scroll">

                                    <table id="display" style="font-size:14px;"
                                           class="table table-striped table-bordered responsive col-xlg-12 "
                                           cellspacing="0">

                                        <thead>

                                        <th>Enrolment ID</th>
                                        <th>Sample Label</th>
                                        <th>Nikshay ID</th>
                                        <th>Patient Name</th>
                                        <th>Contact No.</th>
                                        <th>Progress Status</th>
                                        <!--<th>Report</th>-->


                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <footer class="footer"> © Copyright Reserved 2017-2018, LIMS</footer>
    </div>


    <div class="modal fade" id="progressdetailpopup" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sample Progress Status (<span id="sample_name"></span>)</h4>
                </div>
                <div class="modal-body">
                    <table id="det_modal" class="my_modal" width="100%" border='0' cellspacing='5' cellpadding="5"
                           style='font-size:13px;'>
                        <thead>
                        <th>Type of Test</th>
                        <th>Reported On</th>
                        <th>Released On</th>
                        <th>Current Status</th>
                        <th>Tested By</th>
                        <th>Comments</th>
                        </thead>
                        <tbody class='table'>

                        </tbody>
                    </table>

                    <div class="display_status_material"></div>
                    <div id="table_footer"></div>
                </div>
            </div>
        </div>
    </div>




    <!-- ======================================= -->
    <!-- ========= Cancel Process Modal ======== -->
    <!-- ======================================= -->
    <div class="modal fade" role="dialog" id="modal-cancel-process">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cancel Process</h4>
                </div>
                <form id="cbnaat_result"
                      method="post"
                      class="form-horizontal form-material"
                      action="{{ route('microbiologist.store') }}">
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="action" value="cancel-process">
                        <input type="hidden" name="enrollId1" value="">
                        <input type="hidden" name="sample" value="">
                        <input type="hidden" name="service1" value="">
                        <input type="hidden" name="no_sample" value="">
                        <input type="hidden" name="sampleid1" value="">
                        <input type="hidden" name="nextStep" value="">
                        <input type="hidden" name="detail" value="">
                        <input type="hidden" name="remark" value="">
                        <input type="hidden" name="bwm_status" value="">
                        <input type="hidden" name="reason_bwm" value="">
                        <input type="hidden" name="reason_other" value="">
						<input type="hidden" name="rec_flag" value="">

                        <label class="col-md-12"><h5>Sample ID:</h5></label>
                        <div class="col-md-12">
                            <input type="text" name="sample_ids" class="form-control form-control-line sample_ids" readonly>
                        </div>
                        <br>
                        <label class="col-md-12"><h5>Sample sent for:<span class="red">*</span><span id="ssentfor"></span></br><span id="ssentforreq" class="red"></span></h5></label>
                        <div class="col-md-12">
                            <!--<select name="sentstep[]" class="form-control form-control-line test_reason services-selected multi-select-xl" multiple required>--->
                            <select name="sentstep[]" class="form-control form-control-line test_reason services-selected sentStepClass"  required>
                                {{--<option value="1">Zn Microscopy</option>--}}
                                {{--<option value="2">Fm Microscopy</option>--}}
                                {{--<option value="4">Cbnaat</option>--}}
                                {{--<option value="6">LPA 1st line</option>--}}
                                {{--<option value="7">LPA 2nd line</option>--}}
                                {{--<option value="16">AFB Culture Innoculation(LC & LJ)</option>--}}
                                {{--<option value="11">Storage</option>--}}

                                <option value="">Choose Step</option>
                                <option value="1">Zn Microscopy</option>
                                <option value="2">Fm Microscopy</option>
                                <option value="3">Decontamination</option>
                                <option value="4">CBNAAT</option>
                                <option value="8-LPA1">LPA 1st Line - DNA Extraction</option>
                                <option value="12-LPA1">LPA 1st Line - PCR</option>
                                <option value="14-LPA1">LPA 1st Line - Hybridization</option>
                                <option value="15-LPA1">LPA 1st Line - LPA Interpretation</option>
                                <option value="8-LPA2">LPA 2nd Line - DNA Extraction</option>
                                <option value="12-LPA2">LPA 2nd Line - PCR</option>
                                <option value="14-LPA2">LPA 2nd Line - Hybridization</option>
                                <option value="15-LPA2">LPA 2nd Line - LPA Interpretation</option>
                                <option value="16-LC">AFB Culture Inoculation - LC</option>
                                <option value="16-LJ">AFB Culture Inoculation - LJ</option>
                                <option value="16-LC">AFB Culture Innoculation(LC & LJ)</option>
                                <option value="11">Storage</option>

                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                        <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="pull-right btn btn-primary btn-md">Ok</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

        var $modalCancelProcess = $('#modal-cancel-process');
        $('body').on('click', '.btn-cancel-process', function (){
            var $btn = $(this);
            var service_log = $btn.data('service-log');
            //console.log(service_log);
            $modalCancelProcess.find('input[name="enrollId1"]')     .val( service_log.enroll_id );
            $modalCancelProcess.find('input[name="sample"]')        .val( service_log.sample_id );
            $modalCancelProcess.find('input[name="service1"]')      .val( service_log.service_id );
            $modalCancelProcess.find('input[name="bwm_status"]')    .val( 0 );
            $modalCancelProcess.find('input[name="no_sample"]')     .val( 0 );
            $modalCancelProcess.find('input[name="sampleid1"]')     .val( service_log.sample_label );
            $modalCancelProcess.find('input[name="sample_ids"]')    .val( service_log.sample_label );
            $modalCancelProcess.find('input[name="nextStep"]')      .val( '' );
            $modalCancelProcess.find('input[name="detail"]')        .val( '' );
            $modalCancelProcess.find('input[name="remark"]')        .val( '' );
            $modalCancelProcess.find('input[name="reason_bwm"]')    .val( '' );
            $modalCancelProcess.find('input[name="reason_other"]')  .val( '' );
            $modalCancelProcess.find('input[name="rec_flag"]')     .val( service_log.rec_flag );
            $modalCancelProcess.modal('show');
        });

        $(".services-selected").change(function() {
            var value = $(this).children(":selected").val();
            var tag = '';
            switch( value ){
                case 3: tag = 'LC'; break;
                case 4: tag = 'LJ'; break;
                case 5: tag = 'LC & LJ Both'; break;
            }
            $modalCancelProcess.find('input[name="tag"]').val( tag );
        });

        $modalCancelProcess.on('show.bs.modal', function () {

        });
    </script>

    <!-- ======================================= -->
    <!-- ====== Cancel Process Modal Ends ====== -->
    <!-- ======================================= -->



    <script>
        $(document).ready(function(){
            // $("#sampleId").setAttribute("readonly");
            //   $("#enroll_label").setAttribute("readonly");

            const $input = $("#search");

            $input.change(function(){

                var scanval= $(this).val();
                var err=0;
                if(scanval.length < 6 || scanval.length > 6){
                    err++;
                    // $(".scanerr").html("Please scan a valid code");
                    // alert("Please enter a valid code");
                    $input.val(null);

                }

                if(isNaN(scanval) !== false ){
                    err++;
                    // $(".scanerr").html("Alphabets are not allowed.Please enter a valid digit");
                    //  alert("Alphabets are not allowed.Please enter a valid digit");
                    $input.val(null);

                }

                if( scanval == '' || scanval == null ){
                    err++;
                    // $(".scanerr").html("It cannot be empty");
                    //alert("It cannot be empty");

                }

                if( /^[a-z0-9_]+$/i.test(scanval) == false ){

                    err++;
                    // $(".scanerr").html("No spaces are allowed");
                    //alert("No spaces are allowed");
                    $input.val(null);
                }

                if(err == 0){
                    $.ajax({
                        url:"{{ url('/getsample')}}",
                        type:"POST",
                        data:{
                            "_token":"{{ csrf_token() }}",
                            "scanval":scanval},
                        success:function(response){
                            if(response == "false"){
                                alert("No Barcode Matches Found In The Database. Please Enter a valid Code !")
                                $input.val(null);
                            }else{
                                // fstr= str.toUpperCase();
                                var str = response;
                                $input.val(str);
                            }

                        }

                    });

                }


            });
			
			
			
        });
    </script>



    <script>
        $(document).ready(function () {
            $("#display > tbody").html(null);
            $("#srch").click(function () {
                $("#display > tbody").html(null);
                var barcode = $.trim( $("#search").val() );
                var manual_search = $.trim( $("#manual-search").val() );
                var search_val = ( barcode.length > 0 ? barcode : manual_search );

                // Do not proceed if no search_val is provided.
                if( search_val.length === 0 ) {
                    $("#display > tbody").html(null);
                    return;
                }

                $.ajax({
                    url: "{{url('/searchform/getenquiry')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {"search_val": search_val, "_token": "{{ csrf_token() }}"},
                    success: function (response) {

                        var html = '';
                        $.each(response, function (key, val) {
                            // alert(val.sampleid);
                            var id = val.sampleid;
                            var enrolls_id = val.enroll_id;
                            var sample_label = val.sample_label;
                            html += "<tr><td>" + val.label + "</td><td>" + val.sample_label + "</td><td>" + val.nikshay_id + "</td><td>" + val.firstname + "</td><td>" + val.mobile_number + "</td> <td><a class='detail_modal' onclick='getdetailsform(" + id + ',' + enrolls_id + ",\"" + sample_label + "\")'>Show Status</a></td></tr>";
							//<td><a target='_blank' href='{{ url('/interimview/') }}/" + val.sampleid + "/pdf'>Show Report</a></td></tr>";
                        });
                        $("#display > tbody").html(html);


                    }
                });

            });
        });

    </script>

    <script>

        function getdetailsform(id, enrolls_id, sample_label) {
            $("#det_modal > tbody").empty();
            var sample_id = id;
            var enroll_id = enrolls_id;
            var label = sample_label;
            // alert(label);
            // alert(sample_label)
            $.ajax({

                url: "{{ url('/searchform/get_current_status') }}",
                method: "POST",
                data: {"sample_id": sample_id, 'enroll_id': enroll_id, "label": label, "_token": "{{ csrf_token() }}"},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    $.each(response, function (key, val) {

                        // $(".display_status_material").append("<div><span>Type of Test :</span><br/><span>Reported On :</span><br/><span>Released On :</span><br/><span>Current Status :</span><br/><br/></div>");
                        var type_test = val.service_name;
						var tag=val.tag;
						if(tag != ''){

						  type_test=type_test+" - "+tag;

						}
                        var status = val.status;
                        var rptnewDate;
                        var rlsnewDate;
                        var reported_date = val.reported_dt;
                        var released_date = val.released_dt;
						var is_accepted = val.is_accepted;

                        // if(reported_date == '' || reported_date == null){
                        // rptnewDate='';
                        //
                        // }else{
                        //   var rptdateAr = reported_date.split('-');
                        //   var rptnewDate = rptdateAr[1] + '-' + rptdateAr[2] + '-' + rptdateAr[0];
                        // }


                        // if(released_date == '' || released_date == null){
                        //
                        // rlsnewDate='';
                        // }else{
                        //   var rlsdateAr = released_date.split('-');
                        //  rlsnewDate = rlsdateAr[1] + '-' + rlsdateAr[2] + '-' + rlsdateAr[0];
                        // }


                        // alert(rptnewDate);

						
                        var teststatus = '';
						if(is_accepted=="Rejected"){
								teststatus = "Sample Rejected";
						}
						else {
							if ( status == 0 || status == 2 || status == 99 ) {
								teststatus = "Done";
							} else{
								teststatus = "In Progress";
								}
                        }

                        $("#sample_name").text(val.sample_label);

                        // Only user with role "cancel_process" can only have this button.
                        @role('cancel_process')
                            if( status != 0 && status != 2 && status != 99 ){
								if(is_accepted!="Rejected"){
                                // In "tested_by" column add a button to "cancel the process".
                                val.tested_by  = '<button data-service-log=\'' + JSON.stringify(val) + '\' class="btn btn-danger btn-sm btn-cancel-process">Cancel</button>';
								}
                            }
                        @endrole

                        $("#det_modal > tbody").append(
                            "<tr>" +
                            "   <td>" + type_test + "</td>" +
                            "   <td>" + reported_date + "</td>" +
                            "   <td>" + released_date + "</td>" +
                            "   <td>" + teststatus + "</td>" +
                            "   <td>" + val.tested_by + "</td>" +
                            "   <td>" + val.comments + "</td>" +
                            "</tr>");

                    });

                    $("#progressdetailpopup").modal('toggle');

                }

            });



        }

    </script>
@endsection

