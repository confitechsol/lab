@extends('admin.layout.app')
@section('content')
<div class="page-wrapper">
          
            <div class="container-fluid">
              
                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="form-horizontal" style="padding: 34px;"">
                                    <h1 class="text-themecolor m-b-0 m-t-0" style="margin-bottom: 10px;">HR</h1>
                                    <h6>Provide personnel &amp; trainings data of the lab users are recorded here.<h6>
                                </div>    

                                <form action="{{ url('/hr') }}" method="post" enctype='multipart/form-data' class="form-horizontal form-material" style="padding: 8px;">
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="name" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Designation</label>
                                        <div class="col-sm-12">
                                            <select name="designation" class="form-control form-control-line">
                                                <option>Bacteriologist</option>
                                                <option>Bio Safety Officer</option>
                                                <option>Consultant Micro-Biologist</option>
                                                <option>Data Entry Operator</option>
                                                <option>Head of the dept</option>
                                                <option>Head &amp; Director for Lab Services</option>
                                                <option>Jr. Microbiologist</option>
                                                <option>Lab Directory</option>
                                                <option>Lab Manager</option>
                                                <option>Lab Supervisor</option>
                                                <option>Officer</option>
                                                <option>Phlebotomist</option>
                                                <option>Professor</option>
                                                <option>Quality Officer</option>
                                                <option>Sr.technician</option>
                                                <option>Sweeper</option>
                                                <option>STDC Director</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Qualification</label>
                                        <div class="col-md-12">
                                            <input type="text" name="qualification" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Mode of Employment</label>
                                        <div class="col-sm-12">
                                            <select  name="mode" class="form-control form-control-line">
                                                <option>Central Govt.</option>
                                                <option>State Govt.</option>
                                                <option>Institutional</option>
                                                <option>Contractual(RNTCP,Private,Project,Others)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Date of Joining</label>
                                        <div class="col-md-12" id="sandbox-container">
                                        <input type="text" name="date_joining" class="form-control"> 
                                            <!-- <input type="text"class="form-control form-control-line"> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Date of Reliving</label>
                                        <div class="col-md-12" id="sandbox-container">
                                        <input type="text" name="date_joining" class="form-control"> 
                                            <!-- <input type="text"class="form-control form-control-line"> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Health Checkup for Current year</label>
                                        <div class="col-sm-12">
                                            <select name="health_check" class="form-control form-control-line">
                                                <option>Yes</option>
                                                <option>No</option>
                                                <option>Ongoing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Vaccination (Hep B)</label>
                                        <div class="col-sm-12">
                                            <select name="vaccination" class="form-control form-control-line">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-sm-12">Trainging Subject</label>
                                        <div class="col-sm-12">
                                            <select name="training_subject" class="form-control form-control-line">
                                                <option value="Bio Bio Safety training">Bio Bio Safety training</option>
                                                <option value="CBNAAT testing">CBNAAT testing</option>
                                                <option value="Culture">Culture</option>
                                                <option value="DST">DST</option>
                                                <option value="Fire Safety training">Fire Safety training</option>
                                                <option value="Line Probe Assay">Line Probe Assay</option>
                                                <option value="Microscopy">Microscopy</option>
                                                <option value="Orientation training">Orientation training</option>
                                                <option value="QMS training">QMS training</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-xlg-4 col-md-6 col-lg-4 col-sm-12 col-xs-12">
                                        <label class="col-md-12">Training Start Date</label>
                                        <div class="col-md-12" id="sandbox-container">
                                        <input type="text" class="form-control"> 
                                            <!-- <input type="text"class="form-control form-control-line"> -->
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group col-xs-3 cal-lg-6 pull-right">
							                    <input type="submit" value="Submit" class = "pull-right btn-go go-button add-button"/>
							        </div>

                                </form>
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
        
@endsection