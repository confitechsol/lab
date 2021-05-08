@extends('admin.layout.app')
@section('content')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="form-horizontal" style="padding: 34px;"">
                                    <h1 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 10px;">Sample Quality Test</h1>
                                    <h6>Once samples are collected in the reception area the samples are stored in cold storage. Quality checks for the samples are done in this step also in some cases.<h6>
                                </div>

                                <form class="form-horizontal form-material" style="padding: 8px;">
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Search Barcode</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Lab Enrolment Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Patient Nikshay Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Test Request For</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 5px;margin-left: 14px;border-radius: 4px;background-color: #26c5da;padding: 16px;color: #fff !important;">Diagnosis TB</h4>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Diagnosis TB Nikshay Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Diagnosis TB H/O Anti TB Rx For > 1 Month</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Presumtive TB</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Private Referral</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Presumtive NTM</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Predominant Symptom</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Duration In Days</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 5px;margin-left: 14px;border-radius: 4px;background-color: #26c5da;padding: 16px;color: #fff !important;">Follow Up TB (Smear and Culture)</h4>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">RNTCP TB Reg No</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>New</option>
                                                <option>Previously Treated</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">NIKSHAY ID</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Regimen</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>New</option>
                                                <option>Previously Treated</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Reason</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Reason</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>End IP</option>
                                                <option>End CP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Post Treatment</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>6m</option>
                                                <option>12m</option>
                                                <option>18m</option>
                                                <option>24m</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 5px;margin-left: 14px;border-radius: 4px;background-color: #26c5da;padding: 16px;color: #fff !important;">Diagnosis Drug Resistant TB - Drug Susceptibility Testing (DST)</h4>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Presumptive MDR TB</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Type</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>New</option>
                                                <option>Previously Treated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">At Diagnosis</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Contact of MDR/RR TB</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Follow Up Sm+ve</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Private Referral</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Discordance Resolution</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Presumptive H Monopoly</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Presumptive XDR TB</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">MDR/RR TB at Diagnosis</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">&gt;= 4 Months Culture Positive</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">&gt;= 4 Months Culture Positive</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Treatment Month</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">3 Monthly For Persistent Culture Positives</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Culture Reversion</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Failure of MDR/RR TB Regimen</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Recurrent Case Of Second Line Treatment</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Discordance Resolution</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 5px;margin-left: 14px;border-radius: 4px;background-color: #26c5da;padding: 16px;color: #fff !important;">Follow Up (Culture)</h4>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">PMDT TB No</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                     <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">DRTB Nikshay Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Regimen</label>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;"">
                                            <input type="checkbox" id="inlineCheckbox1" value="option1">
                                            <label for="inlineCheckbox1"> Inline One </label>
                                        </div>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;">
                                            <input type="checkbox" id="inlineCheckbox2" value="option1" checked="">
                                            <label for="inlineCheckbox2"> Inline Two </label>
                                        </div>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;">
                                            <input type="checkbox" id="inlineCheckbox3" value="option1">
                                            <label for="inlineCheckbox3"> Inline Three </label>
                                        </div>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;"">
                                            <input type="checkbox" id="inlineCheckbox4" value="option1">
                                            <label for="inlineCheckbox4"> Inline One </label>
                                        </div>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;">
                                            <input type="checkbox" id="inlineCheckbox5" value="option1" checked="">
                                            <label for="inlineCheckbox5"> Inline Two </label>
                                        </div>
                                        <div class="" style="width: 30%;float: left;margin-left: 15px;margin-top: 20px;">
                                            <input type="checkbox" id="inlineCheckbox6" value="option1">
                                            <label for="inlineCheckbox6"> Inline Three </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Treatment Month</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Treatment Week</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specimen Barcode - Sample A</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specimen Barcode - Sample B</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Specimen Status - Sample A</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Pushed For Test</option>
                                                <option>Rejected</option>
                                                <option>Stand By</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Reason for Rejection - Sample A</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Specimen Status - Sample B</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Pushed For Test</option>
                                                <option>Rejected</option>
                                                <option>Stand By</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Reason for Rejection - Sample B</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Follow Up For (month/Year)</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-12 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Test Requested</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>ZN Microscopy</option>
                                                <option>FM Microscopy</option>
                                                <option>AFB Culture LJ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specify Others</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Requester Name</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Requester Designation</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Requester Contact No</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Requester Email Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Process Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Pending</option>
                                                <option>WP</option>
                                                <option>Complete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Reason For Pending</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Operator</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12"">
                                        <label class="col-sm-12">Tests Already Done</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>CBNAAT</option>
                                                <option>Microscopy</option>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div>


                        <div class="row" style="margin-left: 42px;margin-bottom: 60px;">
                            <p>
                                <button type="button" class="btn btn-info btn-warning " style="margin-bottom: 5px;">Submit</button>
                                <button type="button" class="btn btn-info " style="margin-bottom: 5px;">Review</button>
                                <button type="button" class="btn btn-info " style="margin-bottom: 5px;">Print</button>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">  </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
  @endsection
