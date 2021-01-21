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
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <!-- <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Patient</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Add Patient</li>
                        </ol>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="form-horizontal" style="padding: 34px;">
                                    <h1 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 10px;">Sample Reception</h1>

                                </div>

                                <form class="form-horizontal form-material" style="padding: 8px;">
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Lab Enrolment Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Patient Type</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>New</option>
                                                <option>Transferred</option>
                                                <option>Referred</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Patient Nikshay Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Nikshay Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Generated</option>
                                                <option>Pending Validated</option>
                                                <option>Validation Pending</option>
                                                <option>Mismatch</option>
                                                <option>Not Found</option>
                                                <option>Demography Mismatch</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specimen Barcode Id-Sample A</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specimen Barcode Id-Sample B</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specimen Date Of Collection</label>
                                        <div class="col-md-12" id="sandbox-container">
                                        <input type="text" class="form-control">
                                            <!-- <input type="text"class="form-control form-control-line"> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Speciment Type</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Sputum</option>
                                                <option>BAL</option>
                                                <option>Pus</option>
                                                <option>Gastric Aspirates</option>
                                                <option>Pericardial Fluid</option>
                                                <option>Endometrial Biopsy</option>
                                                <option>Urine</option>
                                                <option>Pleural Fluid</option>
                                                <option>AFB MTB positive culture (LJ tube) Biopsy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Speciment Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Accepted</option>
                                                <option>Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Reason For Rejection</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Sample leakage in the box</option>
                                                <option>Wrong forms</option>
                                                <option>Insufficient quantity of sample</option>
                                                <option>Wrong labelling</option>
                                                <option>Sample transport without cold chain</option>
                                                <option>Sample received outside of the TAT time</option>
                                                <option>Other reason</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Specify Other Reason</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">HIV Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Reactive</option>
                                                <option>Non-Reactive</option>
                                                <option>Unknown</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Key Population</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Contact of known TB patient</option>
                                                <option>Diabetes</option>
                                                <option>Tobacco</option>
                                                <option>Prison</option>
                                                <option>Miner</option>
                                                <option>Migrant</option>
                                                <option>Urban Slum</option>
                                                <option>Healthcare Worker</option>
                                                <option>Other (Specify)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Key Population Other Specify</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Name Referring Facility</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Health Establishment Id(Nikshay)</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">CDL Nikshay Id</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">RNTCP TB Reg No Applicable</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">RNTCP TB Reg No.</label>
                                        <div class="col-md-12">
                                            <input type="text"class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">State (List of all states, UT)</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">District</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Tuberculos in Unit (TU)</label>
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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>

@endsection
