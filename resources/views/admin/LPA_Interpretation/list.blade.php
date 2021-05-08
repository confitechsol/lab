
@extends('admin.layout.app')
@section('content')
<style>
  .activa{
    background-color:#FFDFBF!important;
    color:#1E88E5;
    font-weight: bold;
    font-family: serif;
  }
  .history-activa{
    background-color:#FFDFBF!important;
    color:#1E88E5;
    font-weight: bold;
    font-family: serif;
  }
  input[type="checkbox"][readonly] {
    pointer-events: none;
  }
  #pageloader
  {
    top: 0;
      bottom: 0;
      left: 0;
      right: 0;
    position: fixed;
      height:100%;
    width:100%;
    background:rgba(0, 0, 0, 0.2);
    opacity:.7;
    z-index:9999;
    display:none;
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
  .hide_column {
      display : none;
  }
  @keyframes spinner {
    to {transform: rotate(360deg);}
  }
   
  .spinner:before {
    content: '';
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    margin-left: -10px;
    border-radius: 50%;
    border: 2px solid #ccc;
    border-top-color: #333;
    animation: spinner .6s linear infinite;
  }
  </style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LPA interpretation</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lpa/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
                    </form>
                 </div>
              </div>
            <div class="row">

                </div>

                <div class="row">
                       <!----------loader------------>
						<div id="pageloader">
						  <div class="loader"></div>
						</div>
						<!----------loader------------>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                          <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                            <button class="btn-sm btn-info filterBtn" value="1st line LPA" id="default-btn">1st line LPA&nbsp;<span id="tot_1st_lpa">( 0 )</span></button>
                            <button class="btn-sm btn-info filterBtn" value="2nd line LPA">2nd line LPA&nbsp;<span id="tot_2nd_lpa">( 0 )</span></button>
                            <input type="hidden" name="bulk_tag" id="bulk_tag" value="" >
                            <input type="hidden" name="is_bulk_popup" id="is_bulk_popup" value="" >
                              <div class="scroll-table " style="margin-top: 20px;">
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr> 
                                              <th><input type="checkbox" id="bulk-select-all"></th>                                             
                                              <th class="hide">ID</th>                                                                                                                                        
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>LPA Type</th>
                                              <!-- <th>Test Date</th> -->
                                              <th class="noExport">Field NAAT Result</th>
                                              <th>Action</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                          <tr class="sel"> 
                                            <td></td>
                                            <td class="hide"></td>                                                                                                                      
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>                                            
                                          </tr>
                                  </tbody>

                                        {{-- <tbody>
                                          @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)
                                                  <tr>
                                                    <td>
                                                      @if($samples->status!=0)
                                                      <input class="bulk-selected" type="checkbox" value="{{ $samples->log_id }}">
                                                      @endif
                                                    </td>
                                                    <td class="hide">{{$samples->ID}}</td>
                                                    <td>{{$samples->enroll_label}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    <td>{{$samples->tag}}</td>
                                                    <td><a class='detail_modal bmwoff' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick="showNaatResult()">View Naat Result</a></td>
                                                   <!--  <td></td> -->
                                                    <td>
                                                    @if($samples->status==0)
                                                    Done
                                                    @else
                                                    <button type="button" onclick="openCbnaatForm({{$samples->enroll_id}},'{{$samples->samples}}','{{$samples->tag}}',{{$samples->sample_id}},{{$samples->service_id}},{{$samples->rec_flag}})" class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                    @endif
                                                    </td>
                                                </tr>
                                          @endforeach
                                        @endif
                                      </tbody> --}}

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
        </div>

        <div class="modal fade" id="myModal_naat" role="dialog" >
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Field NAAT Result</h4>
              </div>
        
               <form class="form-horizontal form-material" action="" method="post" enctype='multipart/form-data' id="naat_result">
                        @if(count($errors))
                          @foreach ($errors->all() as $error)
                             <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                         @endforeach
                       @endif
                  <div class="modal-body">
        
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      
                      <label class="col-md-12"><h5>Enrollment Id:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="enrollid" class="form-control form-control-line sampleId"  id="enroll-id">
                         </div>
                         <label class="col-md-12"><h5>Field Sample Id:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="sampleid" class="form-control form-control-line sampleId"  id="sample-id">
                         </div>
                         <label class="col-md-12"><h5>Patient Name:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="patientname" class="form-control form-control-line sampleId"  id="patientname">
                         </div>
                         <label class="col-md-12"><h5>Name of PHI where<br> testing was done:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="phitest" class="form-control form-control-line sampleId"  id="phitest">
                         </div>
                         <label class="col-md-12"><h5>Type of Result <br>(CBNAAT/TrueNAT):</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="resultcbnnat" class="form-control form-control-line sampleId"  id="resultcbnnat">
                         </div>
        
                         <label class="col-md-12"><h5>Vaid/Invalid:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="valid" class="form-control form-control-line sampleId"  id="valid">
                         </div>
        
                         <label class="col-md-12"><h5>If Not valid <br>(Invalid/NA/ No result/Error- specifiy):</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="invalid" class="form-control form-control-line sampleId"  id="invalid">
                         </div>
        
                         <label class="col-md-12"><h5>MTB Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="mtb_result" class="form-control form-control-line sampleId"  id="mtb_result">
                         </div>
                         <label class="col-md-12"><h5>RIF Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="rif_result" class="form-control form-control-line sampleId"  id="rif_result">
                         </div>
                         <label class="col-md-12"><h5>Date of Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="dor_result" class="form-control form-control-line sampleId"  id="dor_result">
                         </div>
                     
                      <br>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                    <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok2" >Ok</button>
                  </div>
        
            </form>
            </div>
          </div>
        </div>

<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="text-themecolor m-b-0 m-t-0 modal-title">Line Probe Assay (LPA)</h4>

        </div>

         <form class="form-horizontal form-material" action="{{ url('/lpa_interpretation') }}" method="post" enctype='multipart/form-data' id="cbnaat_result" >
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
				 <div class="alert alert-danger hide"><h4></h4></div>
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollId" value="">
                <input type="hidden" name="tag" id="tag" value="">				
                <input type="hidden" name="sampleID" id="sampleID" value="">
                <input type="hidden" name="serviceId" id="serviceId" value="">				
                <input type="hidden" name="rec_flag" id="recFlagId" value="">

                <label class="col-md-12"><h6>Sample ID:</h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid">

                       </select>
                   </div>

                <label class="col-md-12"><h6>Lab Serial  </h6></label>
                    <div class="col-md-6">
                       <!-- <select class="form-control form-control-line sampleId" name="type" value="" id="type" required >
                        <option value="">select</option>
                        <option value="Direct">Direct</option>
                        <option value="Indirect">Indirect</option>
                       </select> -->
                        <input type="text" class="form-control form-control-line sampleId" name="type">
                       <input type="checkbox"  name="type_direct" value="Direct" checked> Direct<br>
                       <input type="checkbox" name="type_indirect" value="Indirect"> Indirect<br>

                   </div>
                   <br>
				   
				   <label class="col-md-6"><h6>TUB Band : <span class="red">*</span> </h6></label>
                    <div class="col-md-6">
                       <select class="form-control form-control-line tbu_band_cls" name="tbu_band" value="" id="tbu_band" required>
                        <option value="">select</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                   <br>

                <div id="firstLPA">
                 <label class="col-md-12 text-center"><h6  style="font-weight: bold;">First Line LPA</h6></label>

                  <label class="col-md-12"><h6>RpoB :- Locus Control : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="RpoB" value="" id="RpoB" required>
                        <option value="">select</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                   <br>
                  <div class="row">
                    <div class="col">
                    <label class="col-md-12"><h6>WT1 : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt1" value="" id="wt1" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT2 : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt2" value="" id="wt2" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT3 : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt3" value="" id="wt3" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                 </div>
                 <div class="row">
                   <div class="col">
                     <label class="col-md-12"><h6>WT4 : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="wt4" value="" id="wt4" required>
                         <!-- <option value="">select</option> -->
                         <option value="1">Present</option>
                         <option value="0">Absent</option>
                        </select>
                    </div>
                   </div>
                    <div class="col">
                    <label class="col-md-12"><h6>WT5 : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt5" value="" id="wt5" required>
                       <!--  <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT6 : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt6" value="" id="wt6" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                 </div>

                 <div class="row">

                   <div class="col">
                     <label class="col-md-12"><h6>WT7 : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="wt7" value="" id="wt7" required>
                        <!--  <option value="">select</option> -->
                         <option value="1">Present</option>
                         <option value="0">Absent</option>
                        </select>
                    </div>
                   </div>
                   <div class="col">
                     <label class="col-md-12"><h6>WT8 : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="wt8" value="" id="wt8" required>
                        <!--  <option value="">select</option> -->
                         <option value="1">Present</option>
                         <option value="0">Absent</option>
                        </select>
                    </div>
                   </div>
                    <div class="col">
                    <label class="col-md-12"><h6>MUT1(D516V) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut1DS16V" value="" id="mut1DS16V" required>
                        <!-- <option value="">select</option> -->

                        <option value="0">Absent</option>
                         <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                 </div>

                 <div class="row">
                   <div class="col">
                     <label class="col-md-12"><h6>MUT2A(H526Y) : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="mut2aH526Y" value="" id="mut2aH526Y" required>
                        <!--  <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                   <div class="col">
                     <label class="col-md-12"><h6>MUT2B(H526D) : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="mut2bH526D" value="" id="mut2bH526D" required>
                        <!--  <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                   <div class="col">
                     <label class="col-md-12"><h6>MUT3(S531L) : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="mut3S531L" value="" id="mut3S531L" required>
                        <!--  <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                 </div>

                 <label class="col-md-12"><h6>KatG :- Locus Control : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="katg" value="" id="katg" required>
                        <option value="">select</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                   <br>
                  <div class="row">
                    <div class="col">
                    <label class="col-md-12"><h6>WT1(315) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt1315" value="" id="wt1315" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>MUT1(S315T1) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut1S315T1" value="" id="mut1S315T1" required>
                        <!-- <option value="">select</option> -->

                        <option value="0">Absent</option>
                        <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>MUT2(S315T2) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut2S315T2" value="" id="mut2S315T2" required>
                       <!--  <option value="">select</option> -->

                        <option value="0">Absent</option>
                         <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                 </div>


                 <label class="col-md-12"><h6>InhA :- Locus Control : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="inha" value="" id="inha" required>
                        <option value="">select</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                   <br>
                  <div class="row">
                    <div class="col">
                    <label class="col-md-12"><h6>WT1(-15,-16) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt1516" value="" id="wt1516" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT2(-8) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="wt28" value="" id="wt28" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>MUT1(C15T) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut1C15T" value="" id="mut1C15T" required>
                       <!--  <option value="">select</option> -->

                        <option value="0">Absent</option>
                         <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                 </div>
                 <div class="row">
                   <div class="col">
                     <label class="col-md-12"><h6>MUT2(A16G) : <span class="red">*</span> </h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId flpa" name="mut2A16G" value="" id="mut2A16G" required>
                         <!-- <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                    <div class="col">
                    <label class="col-md-12"><h6>MUT3A(T8C) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut3aT8C" value="" id="mut3aT8C" required>
                       <!--  <option value="">select</option> -->

                        <option value="0">Absent</option>
                         <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>MUT3B(T8A) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId flpa" name="mut3bT8A" value="" id="mut3bT8A" required>
                       <!--  <option value="">select</option> -->

                        <option value="0">Absent</option>
                        <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                 </div>
              </div>
                 <br>				 
                <div id="secondLPA">
                 <label class="col-md-12 text-center"><h6 style="font-weight: bold;">Second Line LPA</h6></label>

                  <label class="col-md-12"><h6>gyrA :- Locus Control : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="gyra" value="" id="gyra" required>
                        <option value="">select</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                   <br>
                  <div class="row">
                    <div class="col">
                    <label class="col-md-12"><h6>WT1(85-90) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="wt18590" value="" id="wt18590" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT2(89-93) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="wt28993" value="" id="wt28993" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>WT3(92-97) : <span class="red">*</span> </h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="wt39297" value="" id="wt39297" required>
                        <!-- <option value="">select</option> -->
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                       </select>
                   </div>
                  </div>
                 </div>
                 <div class="row">
                   <div class="col">
                     <label class="col-md-12"><h6>MUT1(A90V) : <span class="red">*</span></h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId slpa" name="mut1A90V" value="" id="mut1A90V" required>
                        <!--  <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                    <div class="col">
                    <label class="col-md-12"><h6>MUT2(S91P) : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="mut2S91P" value="" id="mut2S91P" required>
                        <!-- <option value="">select</option> -->

                        <option value="0">Absent</option>
                        <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>MUT3A(D94A) : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="mut3aD94A" value="" id="mut3aD94A" required>
                        <!-- <option value="">select</option> -->

                        <option value="0">Absent</option>
                        <option value="1">Present</option>
                       </select>
                   </div>
                  </div>

                 </div>

                 <div class="row">

                   <div class="col">
                     <label class="col-md-12"><h6>MUT3B(D94N/Y) : <span class="red">*</span></h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId slpa" name="mut3bD94N" value="" id="mut3bD94N" required>
                         <!-- <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                   <div class="col">
                     <label class="col-md-12"><h6>MUT3C(D94G) : <span class="red">*</span></h6></label>
                     <div class="col-md-12">
                        <select class="form-control form-control-line sampleId slpa" name="mut3cD94G" value="" id="mut3cD94G" required>
                         <!-- <option value="">select</option> -->

                         <option value="0">Absent</option>
                          <option value="1">Present</option>
                        </select>
                    </div>
                   </div>
                    <div class="col">
                    <label class="col-md-12"><h6>MUT3D(D94H) : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slpa" name="mut3dD94H" value="" id="mut3dD94H" required>
                       <!--  <option value="">select</option> -->

                        <option value="0">Absent</option>
                         <option value="1">Present</option>
                       </select>
                   </div>
                  </div>
                 </div>


                <label class="col-md-12"><h6>gyrB :- Locus Control : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="gyrb" value="" id="gyrb" required>
                    <option value="">select</option>
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
               <br>
              <div class="row">
                <div class="col">
                <label class="col-md-12"><h6>WT1(536-541) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt1536541" value="" id="wt1536541" required>
                    <!-- <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>MUT1(N538D) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="mut1N538D" value="" id="mut1N538D" required>
                   <!--  <option value="">select</option> -->

                    <option value="0">Absent</option>
                     <option value="1">Present</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>MUT2(E540V) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="mut2E540V" value="" id="mut2E540V" required>
                    <!-- <option value="">select</option> -->

                    <option value="0">Absent</option>
                     <option value="1">Present</option>
                   </select>
               </div>
              </div>


             </div>

              <label class="col-md-12"><h6>rrs :- Locus Control : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="rrs" value="" id="rrs" required>
                    <option value="">select</option>
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
               <br>
              <div class="row">

              <div class="col">
                <label class="col-md-12"><h6>WT1(1401-02) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt1140102" value="" id="wt1140102" required>
                    <!-- <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>WT2(1484) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt21484" value="" id="wt21484" required>
                    <!-- <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>MUT1(A1401G) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="mut1A1401G" value="" id="mut1A1401G" required>
                   <!--  <option value="">select</option> -->

                    <option value="0">Absent</option>
                     <option value="1">Present</option>
                   </select>
               </div>
              </div>
             </div>
             <div class="row">
               <div class="col">
                 <label class="col-md-12"><h6>MUT2(G1484T) : <span class="red">*</span></h6></label>
                 <div class="col-md-12">
                    <select class="form-control form-control-line sampleId slpa" name="mut2G1484T" value="" id="mut2G1484T" required>
                    <!--  <option value="">select</option> -->

                     <option value="0">Absent</option>
                     <option value="1">Present</option>
                    </select>
                </div>
               </div>
               <div class="col">

               </div>
               <div class="col">

               </div>
             </div>

             <label class="col-md-12"><h6>eis :- Locus Control : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="eis" value="" id="eis" required>
                    <option value="">select</option>
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
               <br>
              <div class="row">

              <div class="col">
                <label class="col-md-12"><h6>WT1(37) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt137" value="" id="wt137" required>
                   <!--  <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>WT2(14,12,10) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt2141210" value="" id="wt2141210" required>
                   <!--  <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
              <div class="col">
                <label class="col-md-12"><h6>WT3(2) : <span class="red">*</span></h6></label>
                <div class="col-md-12">
                   <select class="form-control form-control-line sampleId slpa" name="wt32" value="" id="wt32" required>
                   <!--  <option value="">select</option> -->
                    <option value="1">Present</option>
                    <option value="0">Absent</option>
                   </select>
               </div>
              </div>
             </div>

             <div class="row">
               <div class="col">
                 <label class="col-md-12"><h6>MUT1(C-14T) : <span class="red">*</span></h6></label>
                 <div class="col-md-12">
                    <select class="form-control form-control-line sampleId slpa" name="mut1c14t" value="" id="mut1c14t" required>
                     <!-- <option value=" ">select</option> -->

                     <option value="0">Absent</option>
                     <option value="1">Present</option>
                    </select>
                </div>
               </div>
               <div class="col">
               </div>
               <div class="col">
               </div>
             </div>
            </div>			

             <br>
             <label class="col-md-12 text-center"><h6 style="font-weight: bold;">Interpretation</h6></label>

                   <br>
                  <div class="row">
                    <div class="col">
                    <label class="col-md-12"><h6>Result : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId new_mtb_result" name="mtb_result" id="mtb_result" required>
                        <option value="">select</option>
                        <option value="M.Tb. not detected">M.Tb. not detected</option>
                        <option value="M.Tb. detected">M.Tb. detected</option>
                        <option value="Invalid">Invalid</option>
                        <option value="Indeterminate">Indeterminate</option>
                        <option value="Contaminated">Contaminated</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>RIF Resi : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId rif_1st_lpa" name="rif" value="" id="rif" required>
                        <option value="">select</option>
                        <option value="Not detected">Not detected</option>
                        <option value="Detected">Detected</option>
                        <!-- <option value="Indeterminate">Indeterminate</option> -->
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>KatG Resi : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId katg_resi_1st" name="katg_resi" value="" id="katg_resi" required>
                        <option value="">select</option>
                        <option value="Inferred">Inferred</option>
                        <option value="Detected">Detected</option>
                        <option value="Not detected">Not detected</option>
                        <!-- <option value="Indeterminate">Indeterminate</option> -->
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>H Resi : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId inh_1st_lpa" name="inh" value="" id="inh" required>
                        <option value="">select</option>
                        <option value="Inferred">Inferred</option>
                        <option value="Detected">Detected</option>
						            <option value="Not detected">Not detected</option>                        
                       </select>
                   </div>
                  </div>
                 </div>
                 <div class="row">
                  <div class="col">
                    <label class="col-md-12"><h6>FQ Resi : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId quinolone_2nd_lpa" name="quinolone" value="" id="quinolone" required>
                        <option value="">select</option>
                        <option value="Detected - Lfx, Mfx (high level)">Detected - Lfx, Mfx (high level)</option>
                      <option value="Detected - Lfx, Mfx (low level)">Detected - Lfx, Mfx (low level)</option>
                      <option value="Inferred- Lfx, Mfx (low level)">Inferred- Lfx, Mfx (low level)</option>
                      <option value="Not detected">Not detected</option>
                        <!-- <option value="Indeterminate">Indeterminate</option> -->
                       </select>
                   </div>                   
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>SLI (rrs) : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId sli_rss_2nd" name="sli_rss" value="" id="sli_rss" required>
                        <option value="">select</option>
                        <option value="Detected">Detected</option>
                        <option value="Inferred">Inferred</option>
                        <option value="Inferred* (1402 mutation)">Inferred* (1402 mutation)</option>
                        <option value="Not detected">Not detected</option>
                       </select>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>SLI (eis) : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId slid_2nd_lpa" name="slid" value="" id="slid" required>
                        <option value="">select</option>
                        <option value="Detected">Detected</option>
                        <option value="Inferred">Inferred</option>                      
                        <option value="Not detected">Not detected</option>
                       </select>
                   </div>
                  </div>
                  
                  <div class="col">
                  </div>
                 </div>

                 <br>

                 <div class="row">
                  <div class="col">
                             <label class="col-md-12"><h6>Final Interpretation : <span class="red">*</span></h6></label>
                             <div class="col-md-12">
                                <input class="form-control form-control-line final_interpretation" name="final_interpretation" value="" id="final_interpretation1" readonly>                                 
                            </div>
                           </div>
                  </div><br/>

                  <div class="row">
                    <div class="col">
                               <label class="col-md-12"><h6>Remarks : <span class="red">*</span></h6></label>
                               <div class="col-md-12">
                                  <input class="form-control form-control-line clinical_trail" name="clinical_trail" value="" id="clinical_trail">                                 
                              </div>
                             </div>
                    </div><br/>
                
				{{-- <div class="row">
				 <div class="col">
                    <label class="col-md-12"><h6>Final Interpretation : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line" name="final_interpretation" value="" id="final_interpretation" required>
                        <option value="">select</option>
                       </select>
                   </div>
                  </div>
				 </div><br/> --}}
				  
                 <div class="row">

                  <!--ui date input field incoprated by Amrita start------> 
				  <div class="col">
                    <label class="col-md-12"><h6>Date Result : <span class="red">*</span></h6></label>
                    <div class="col-md-12">
					   <div class="col-md-12">
						   <!--<input type="text" name="test_date" value="{{ date('d-m-Y',strtotime($data['today'])) }}" class="form-control form-control-line" disabled>---->
						   <input type="date" name="test_date" id="test_date" class="form-control form-control-line" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>" required  >				   
					   </div>
                    </div>
                  </div>
				  <!--ui date input field incoprated by Amrita End------> 
				  
                  <div class="col">
                    <label class="col-md-12"><h6>Date Reported :</h6></label>
                    <div class="col-md-12">
                       <input type="text" name="test_date" id="date_reported" value="{{ date('d-m-Y',strtotime($data['today'])) }}" class="form-control form-control-line" disabled>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>Reported By :</h6></label>
                    <div class="col-md-12">
                      <input type="text" name="created_by" value="{{$data['user']}}" class="form-control form-control-line" disabled>
                   </div>
                  </div>
                 </div>
                 <div class="row">
                   <div class="col">
                     <label class="col-md-12"><h6>Comments : </h6></label>
                     <div class="col-md-12">
                                  <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                    </div>
                   </div>
                 </div>

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal" id="canceled">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>

 {{-- Bulk store LAP Popup --}}

 <div class="modal fade" id="myModal_bulk" role="dialog" >
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="text-themecolor m-b-0 m-t-0 modal-title">Line Probe Assay (LPA)</h4>

      </div>

       <form class="form-horizontal form-material" action="{{ url('/lpa_bulkstore') }}" method="post" enctype='multipart/form-data' id="cbnaat_result_bulk" >
                @if(count($errors))
                  @foreach ($errors->all() as $error)
                     <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                 @endforeach
               @endif
       <div class="alert alert-danger hide"><h4></h4></div>
          <div class="modal-body">

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="log_ids" id="log_ids" value="">
              <input type="hidden" name="enrollId" id="enrollId" value="">
             <input type="hidden" name="tag" id="tag" value="">				
              <input type="hidden" name="sampleID" id="sampleID" value="">
              <input type="hidden" name="serviceId" id="serviceId" value="">				
              <input type="hidden" name="rec_flag" id="recFlagId" value="">
              <input type="hidden" name="sampleid" id="sampleid" value="">
              
              <div class="col-md-6">
                <!-- <select class="form-control form-control-line sampleId" name="type" value="" id="type" required >
                 <option value="">select</option>
                 <option value="Direct">Direct</option>
                 <option value="Indirect">Indirect</option>
                </select> -->                 
                <input type="checkbox"  name="type_direct" value="Direct" checked> Direct<br>
                <input type="checkbox" name="type_indirect" value="Indirect"> Indirect<br>

            </div>
            <br>
         
         <label class="col-md-6"><h6>TUB Band : <span class="red">*</span> </h6></label>
                  <div class="col-md-6">
                     <select class="form-control form-control-line tbu_band_cls" name="tbu_band" value="" id="tbu_band" readonly>
                      <option value="">select</option>
                      <option value="1" selected="selected">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                 <br>

              <div id="firstLPA_bulk">
               <label class="col-md-12 text-center"><h6  style="font-weight: bold;">First Line LPA</h6></label>

                <label class="col-md-12"><h6>RpoB :- Locus Control : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="RpoB" value="" id="RpoB">
                      <option value="">select</option>
                      <option value="1" selected="selected">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                 <br>
                <div class="row">
                  <div class="col">
                  <label class="col-md-12"><h6>WT1 : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt1" value="" id="wt1" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT2 : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt2" value="" id="wt2" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT3 : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt3" value="" id="wt3" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
               </div>
               <div class="row">
                 <div class="col">
                   <label class="col-md-12"><h6>WT4 : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="wt4" value="" id="wt4" required>
                       <!-- <option value="">select</option> -->
                       <option value="1">Present</option>
                       <option value="0">Absent</option>
                      </select>
                  </div>
                 </div>
                  <div class="col">
                  <label class="col-md-12"><h6>WT5 : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt5" value="" id="wt5" required>
                     <!--  <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT6 : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt6" value="" id="wt6" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
               </div>

               <div class="row">

                 <div class="col">
                   <label class="col-md-12"><h6>WT7 : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="wt7" value="" id="wt7" required>
                      <!--  <option value="">select</option> -->
                       <option value="1">Present</option>
                       <option value="0">Absent</option>
                      </select>
                  </div>
                 </div>
                 <div class="col">
                   <label class="col-md-12"><h6>WT8 : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="wt8" value="" id="wt8" required>
                      <!--  <option value="">select</option> -->
                       <option value="1">Present</option>
                       <option value="0">Absent</option>
                      </select>
                  </div>
                 </div>
                  <div class="col">
                  <label class="col-md-12"><h6>MUT1(D516V) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut1DS16V" value="" id="mut1DS16V" required>
                      <!-- <option value="">select</option> -->

                      <option value="0">Absent</option>
                       <option value="1">Present</option>
                     </select>
                 </div>
                </div>
               </div>

               <div class="row">
                 <div class="col">
                   <label class="col-md-12"><h6>MUT2A(H526Y) : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="mut2aH526Y" value="" id="mut2aH526Y" required>
                      <!--  <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                 <div class="col">
                   <label class="col-md-12"><h6>MUT2B(H526D) : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="mut2bH526D" value="" id="mut2bH526D" required>
                      <!--  <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                 <div class="col">
                   <label class="col-md-12"><h6>MUT3(S531L) : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="mut3S531L" value="" id="mut3S531L" required>
                      <!--  <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
               </div>

               <label class="col-md-12"><h6>KatG :- Locus Control : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="katg" value="" id="katg" >
                      <option value="">select</option>
                      <option value="1" selected="selected">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                 <br>
                <div class="row">
                  <div class="col">
                  <label class="col-md-12"><h6>WT1(315) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt1315" value="" id="wt1315" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>MUT1(S315T1) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut1S315T1" value="" id="mut1S315T1" required>
                      <!-- <option value="">select</option> -->

                      <option value="0">Absent</option>
                      <option value="1">Present</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>MUT2(S315T2) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut2S315T2" value="" id="mut2S315T2" required>
                     <!--  <option value="">select</option> -->

                      <option value="0">Absent</option>
                       <option value="1">Present</option>
                     </select>
                 </div>
                </div>
               </div>

               <label class="col-md-12"><h6>InhA :- Locus Control : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="inha" value="" id="inha">
                      <option value="">select</option>
                      <option value="1" selected="selected">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                 <br>
                <div class="row">
                  <div class="col">
                  <label class="col-md-12"><h6>WT1(-15,-16) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt1516" value="" id="wt1516" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT2(-8) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="wt28" value="" id="wt28" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>MUT1(C15T) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut1C15T" value="" id="mut1C15T" required>
                     <!--  <option value="">select</option> -->

                      <option value="0">Absent</option>
                       <option value="1">Present</option>
                     </select>
                 </div>
                </div>
               </div>
               <div class="row">
                 <div class="col">
                   <label class="col-md-12"><h6>MUT2(A16G) : <span class="red">*</span> </h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId flpa" name="mut2A16G" value="" id="mut2A16G" required>
                       <!-- <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                  <div class="col">
                  <label class="col-md-12"><h6>MUT3A(T8C) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut3aT8C" value="" id="mut3aT8C" required>
                     <!--  <option value="">select</option> -->

                      <option value="0">Absent</option>
                       <option value="1">Present</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>MUT3B(T8A) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId flpa" name="mut3bT8A" value="" id="mut3bT8A" required>
                     <!--  <option value="">select</option> -->

                      <option value="0">Absent</option>
                      <option value="1">Present</option>
                     </select>
                 </div>
                </div>
               </div>
            </div>
             <br>
       
              <div id="secondLPA_bulk">
               <label class="col-md-12 text-center"><h6 style="font-weight: bold;">Second Line LPA</h6></label>

                <label class="col-md-12"><h6>gyrA :- Locus Control : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="gyra" value="" id="gyra" >
                      <option value="">select</option>
                      <option value="1" selected="selected">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                 <br>
                <div class="row">
                  <div class="col">
                  <label class="col-md-12"><h6>WT1(85-90) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="wt18590" value="" id="wt18590" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT2(89-93) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="wt28993" value="" id="wt28993" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>WT3(92-97) : <span class="red">*</span> </h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="wt39297" value="" id="wt39297" required>
                      <!-- <option value="">select</option> -->
                      <option value="1">Present</option>
                      <option value="0">Absent</option>
                     </select>
                 </div>
                </div>
               </div>
               <div class="row">
                 <div class="col">
                   <label class="col-md-12"><h6>MUT1(A90V) : <span class="red">*</span></h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId slpa" name="mut1A90V" value="" id="mut1A90V" required>
                      <!--  <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                  <div class="col">
                  <label class="col-md-12"><h6>MUT2(S91P) : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="mut2S91P" value="" id="mut2S91P" required>
                      <!-- <option value="">select</option> -->

                      <option value="0">Absent</option>
                      <option value="1">Present</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>MUT3A(D94A) : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="mut3aD94A" value="" id="mut3aD94A" required>
                      <!-- <option value="">select</option> -->

                      <option value="0">Absent</option>
                      <option value="1">Present</option>
                     </select>
                 </div>
                </div>

               </div>

               <div class="row">

                 <div class="col">
                   <label class="col-md-12"><h6>MUT3B(D94N/Y) : <span class="red">*</span></h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId slpa" name="mut3bD94N" value="" id="mut3bD94N" required>
                       <!-- <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                 <div class="col">
                   <label class="col-md-12"><h6>MUT3C(D94G) : <span class="red">*</span></h6></label>
                   <div class="col-md-12">
                      <select class="form-control form-control-line sampleId slpa" name="mut3cD94G" value="" id="mut3cD94G" required>
                       <!-- <option value="">select</option> -->

                       <option value="0">Absent</option>
                        <option value="1">Present</option>
                      </select>
                  </div>
                 </div>
                  <div class="col">
                  <label class="col-md-12"><h6>MUT3D(D94H) : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slpa" name="mut3dD94H" value="" id="mut3dD94H" required>
                     <!--  <option value="">select</option> -->

                      <option value="0">Absent</option>
                       <option value="1">Present</option>
                     </select>
                 </div>
                </div>
               </div>


              <label class="col-md-12"><h6>gyrB :- Locus Control : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="gyrb" value="" id="gyrb">
                  <option value="">select</option>
                  <option value="1" selected="selected">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
             <br>
            <div class="row">
              <div class="col">
              <label class="col-md-12"><h6>WT1(536-541) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt1536541" value="" id="wt1536541" required>
                  <!-- <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>MUT1(N538D) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="mut1N538D" value="" id="mut1N538D" required>
                 <!--  <option value="">select</option> -->

                  <option value="0">Absent</option>
                   <option value="1">Present</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>MUT2(E540V) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="mut2E540V" value="" id="mut2E540V" required>
                  <!-- <option value="">select</option> -->

                  <option value="0">Absent</option>
                   <option value="1">Present</option>
                 </select>
             </div>
            </div>


           </div>

            <label class="col-md-12"><h6>rrs :- Locus Control : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="rrs" value="" id="rrs">
                  <option value="">select</option>
                  <option value="1" selected="selected">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
             <br>
            <div class="row">

            <div class="col">
              <label class="col-md-12"><h6>WT1(1401-02) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt1140102" value="" id="wt1140102" required>
                  <!-- <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>WT2(1484) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt21484" value="" id="wt21484" required>
                  <!-- <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>MUT1(A1401G) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="mut1A1401G" value="" id="mut1A1401G" required>
                 <!--  <option value="">select</option> -->

                  <option value="0">Absent</option>
                   <option value="1">Present</option>
                 </select>
             </div>
            </div>
           </div>
           <div class="row">
             <div class="col">
               <label class="col-md-12"><h6>MUT2(G1484T) : <span class="red">*</span></h6></label>
               <div class="col-md-12">
                  <select class="form-control form-control-line sampleId slpa" name="mut2G1484T" value="" id="mut2G1484T" required>
                  <!--  <option value="">select</option> -->

                   <option value="0">Absent</option>
                   <option value="1">Present</option>
                  </select>
              </div>
             </div>
             <div class="col">

             </div>
             <div class="col">

             </div>
           </div>

           <label class="col-md-12"><h6>eis :- Locus Control : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="eis" value="" id="eis">
                  <option value="">select</option>
                  <option value="1" selected="selected">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
             <br>
            <div class="row">

            <div class="col">
              <label class="col-md-12"><h6>WT1(37) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt137" value="" id="wt137" required>
                 <!--  <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>WT2(14,12,10) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt2141210" value="" id="wt2141210" required>
                 <!--  <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
            <div class="col">
              <label class="col-md-12"><h6>WT3(2) : <span class="red">*</span></h6></label>
              <div class="col-md-12">
                 <select class="form-control form-control-line sampleId slpa" name="wt32" value="" id="wt32" required>
                 <!--  <option value="">select</option> -->
                  <option value="1">Present</option>
                  <option value="0">Absent</option>
                 </select>
             </div>
            </div>
           </div>

           <div class="row">
             <div class="col">
               <label class="col-md-12"><h6>MUT1(C-14T) : <span class="red">*</span></h6></label>
               <div class="col-md-12">
                  <select class="form-control form-control-line sampleId slpa" name="mut1c14t" value="" id="mut1c14t" required>
                   <!-- <option value=" ">select</option> -->

                   <option value="0">Absent</option>
                   <option value="1">Present</option>
                  </select>
              </div>
             </div>
             <div class="col">
             </div>
             <div class="col">
             </div>
           </div>
          </div> 

           <br>
           <label class="col-md-12 text-center"><h6 style="font-weight: bold;">Interpretation</h6></label>


                 <br>
                <div class="row">
                  <div class="col">
                  <label class="col-md-12"><h6>Result : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId new_mtb_result" name="mtb_result" id="mtb_result" required>
                      <option value="">select</option>
                      <option value="M.Tb. not detected">M.Tb. not detected</option>
                        <option value="M.Tb. detected">M.Tb. detected</option>
                      <option value="Invalid">Invalid</option>
                      <option value="Indeterminate">Indeterminate</option>
                      <option value="Contaminated">Contaminated</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>RIF Resi : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId rif_1st_lpa" name="rif" value="" id="rif" required>
                      <option value="">select</option>
                      <option value="Not detected">Not detected</option>
                      <option value="Detected">Detected</option>
                      <!-- <option value="Indeterminate">Indeterminate</option> -->
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>KatG Resi : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId katg_resi_1st" name="katg_resi" value="" id="katg_resi" required>
                      <option value="">select</option>
                      <option value="Inferred">Inferred</option>
                      <option value="Detected">Detected</option>
                      <option value="Not detected">Not detected</option>
                      <!-- <option value="Indeterminate">Indeterminate</option> -->
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>H Resi : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId inh_1st_lpa" name="inh" value="" id="inh" required>
                      <option value="">select</option>
                      <option value="Inferred">Inferred</option>
                      <option value="Detected">Detected</option>                     
                      <option value="Not detected">Not detected</option>
                     </select>
                 </div>
                </div>
               </div>
               <div class="row">
                <div class="col">
                  <label class="col-md-12"><h6>FQ Resi : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId quinolone_2nd_lpa" name="quinolone" value="" id="quinolone" required>
                      <option value="">select</option>
                      <option value="Detected - Lfx, Mfx (high level)">Detected - Lfx, Mfx (high level)</option>
                      <option value="Detected - Lfx, Mfx (low level)">Detected - Lfx, Mfx (low level)</option>
                      <option value="Inferred- Lfx, Mfx (low level)">Inferred- Lfx, Mfx (low level)</option>
                      <option value="Not detected">Not detected</option>
                      <!-- <option value="Indeterminate">Indeterminate</option> -->
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>SLI (rrs) : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId sli_rss_2nd" name="sli_rss" value="" id="sli_rss" required>
                      <option value="">select</option>
                      <option value="Detected">Detected</option>
                      <option value="Inferred">Inferred</option>
                      <option value="Inferred* (1402 mutation)">Inferred* (1402 mutation)</option>
                      <option value="Not detected">Not detected</option>
                     </select>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>SLI (eis) : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line sampleId slid_2nd_lpa" name="slid" value="" id="slid" required>
                      <option value="">select</option>
                      <option value="Detected">Detected</option>
                      <option value="Inferred">Inferred</option>                      
                      <option value="Not detected">Not detected</option>
                     </select>
                 </div>
                </div>
                
                <div class="col">
                </div>
               </div>

               <br>

               <div class="row">
                <div class="col">
                           <label class="col-md-12"><h6>Final Interpretation : <span class="red">*</span></h6></label>
                           <div class="col-md-12">
                              <input class="form-control form-control-line final_interpretation" name="final_interpretation" value="" id="final_interpretation1" readonly>                                 
                          </div>
                         </div>
                </div><br/>

                <div class="row">
                  <div class="col">
                             <label class="col-md-12"><h6>Remarks : <span class="red">*</span></h6></label>
                             <div class="col-md-12">
                                <input class="form-control form-control-line clinical_trail" name="clinical_trail" value="" id="clinical_trail">                                 
                            </div>
                           </div>
                  </div><br/>
              
      {{-- <div class="row">
       <div class="col">
                  <label class="col-md-12"><h6>Final Interpretation : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
                     <select class="form-control form-control-line" name="final_interpretation" value="" id="final_interpretation" required>
                      <option value="">select</option>
                     </select>
                 </div>
                </div>
       </div><br/> --}}
        
               <div class="row">

                <!--ui date input field incoprated by Amrita start------> 
        <div class="col">
                  <label class="col-md-12"><h6>Date Result : <span class="red">*</span></h6></label>
                  <div class="col-md-12">
           <div class="col-md-12">
             <!--<input type="text" name="test_date" value="{{ date('d-m-Y',strtotime($data['today'])) }}" class="form-control form-control-line" disabled>---->
             <input type="date" name="test_date" id="test_date" class="form-control form-control-line" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>" required  >				   
           </div>
                  </div>
                </div>
        <!--ui date input field incoprated by Amrita End------> 
        
                <div class="col">
                  <label class="col-md-12"><h6>Date Reported :</h6></label>
                  <div class="col-md-12">
                     <input type="text" name="test_date" id="date_reported" value="{{ date('d-m-Y',strtotime($data['today'])) }}" class="form-control form-control-line" disabled>
                 </div>
                </div>
                <div class="col">
                  <label class="col-md-12"><h6>Reported By :</h6></label>
                  <div class="col-md-12">
                    <input type="text" name="created_by" value="{{$data['user']}}" class="form-control form-control-line" disabled>
                 </div>
                </div>
               </div>
               <div class="row">
                 <div class="col">
                   <label class="col-md-12"><h6>Comments : </h6></label>
                   <div class="col-md-12">
                                <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                  </div>
                 </div>
               </div>

          </div>
          <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
            <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal" id="canceled">Cancel</button>
            <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm_bulk" >Ok</button>
          </div>

    </form>
    </div>
  </div>
</div>





<script>

function showNaatResult()
  {
      $('#myModal_naat').modal('toggle');
  }

$(document).ready(function(){
	/*Changes made by amrita*/

  $(".new_mtb_result").on("change", function() {
    //alert('test');
    var final_interpretation = "";
    var clinical_trail = "";
    //$('#final_interpretation1').val("");
    if($(this).val() != "")
    {
      if($(this).val()=='M.Tb. not detected'){ 

        //alert('test');

        if($('#bulk_tag').val() == '1st line LPA')
        {          
          //alert('test');

          $('.new_mtb_result').prop('selectedIndex', 1);          

          $('.rif_1st_lpa').prop('selectedIndex', 0);
          $('.rif_1st_lpa').prop('disabled', true);

          $('.katg_resi_1st').prop('selectedIndex', 0);
          $('.katg_resi_1st').prop('disabled', true);

          $('.inh_1st_lpa').prop('selectedIndex', 0);
          $('.inh_1st_lpa').prop('disabled', true);
          

          mtb_1st_result('<?php echo csrf_token();?>', $(this).val(), "", "", "");                       

        } 
        else if( $('#bulk_tag').val() == '2nd line LPA' )
        {
          $('.new_mtb_result').prop('selectedIndex', 1); 

          $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
          $('.quinolone_2nd_lpa').prop('disabled', true);

          $('.sli_rss_2nd').prop('selectedIndex', 0);
          $('.sli_rss_2nd').prop('disabled', true);

          $('.slid_2nd_lpa').prop('selectedIndex', 0);
          $('.slid_2nd_lpa').prop('disabled', true);

          mtb_2nd_result('<?php echo csrf_token();?>', $(this).val(), "", "", "");                       


        }

      } else {        

        if($('#bulk_tag').val() == '1st line LPA')
        {
          //alert($(this).val());

          $('.rif_1st_lpa').prop('selectedIndex', 0);
          $('.rif_1st_lpa').prop('disabled', false);

          $('.katg_resi_1st').prop('selectedIndex', 0);
          $('.katg_resi_1st').prop('disabled', false);

          $('.inh_1st_lpa').prop('selectedIndex', 0);
          $('.inh_1st_lpa').prop('disabled', false);

          mtb_1st_result('<?php echo csrf_token();?>', $(this).val(), "", "", "");                       

        } else {

          $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
          $('.quinolone_2nd_lpa').prop('disabled', false);

          $('.sli_rss_2nd').prop('selectedIndex', 0);
          $('.sli_rss_2nd').prop('disabled', false);

          $('.slid_2nd_lpa').prop('selectedIndex', 0);
          $('.slid_2nd_lpa').prop('disabled', false);

          mtb_2nd_result('<?php echo csrf_token();?>', $(this).val(), "", "", "");

        }
      }

    }
    
  });

  $(".rif_1st_lpa").on("change", function() {
    
    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";
    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }

    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result :selected').text();

    }   
     

    if($(this).val() != "")
    {
      rif = $(this).val();
    }

      if( $('#'+isBulkPopup+' .katg_resi_1st').find('option:selected').text() == 'select' )
      {
        katg = "";        

      } else {

        katg = $('#'+isBulkPopup+' .katg_resi_1st').find('option:selected').text();

      }
        
        //console.log(final_interpretation);
    
    
    if($('#'+isBulkPopup+" .inh_1st_lpa").find('option:selected').text() == 'select')
    {
      var inh = "";   

    } else {

      var inh = $('#'+isBulkPopup+" .inh_1st_lpa").find('option:selected').text();

    }

    mtb_1st_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });

  $('.katg_resi_1st').on('change', function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }
      
    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text();

    }   

    if( $('#'+isBulkPopup+' .rif_1st_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('#'+isBulkPopup+' .rif_1st_lpa').find('option:selected').text();

    }        

     
    if($(this).val() != "")
    {
      katg = $(this).val();
    }
      

      if(  $('#'+isBulkPopup+' .inh_1st_lpa').find('option:selected').text() == "select")
      {
        inh = "";
        
      } else {
                inh = $('#'+isBulkPopup+' .inh_1st_lpa').find('option:selected').text();

      }   

      mtb_1st_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });


  $(".inh_1st_lpa").on("change", function() {
    
    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }
      
    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text();

    }   

    if( $('#'+isBulkPopup+' .rif_1st_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('#'+isBulkPopup+' .rif_1st_lpa').find('option:selected').text();

    } 


    if( $('#'+isBulkPopup+' .katg_resi_1st').find('option:selected').text() == 'select')
    {
      katg = "";

    } else {

      katg = $('#'+isBulkPopup+' .katg_resi_1st').find('option:selected').text();

    }     

      if($(this).val() != "")
      {
        inh = $(this).val(); 
      }  
    
      mtb_1st_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });

  $('.quinolone_2nd_lpa').on("change", function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }

    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text();

    }   
     

    if($(this).val() != "")
    {
      rif = $(this).val();
    }

      if( $('#'+isBulkPopup+' .sli_rss_2nd').find('option:selected').text() == 'select' )
      {
        katg = "";        

      } else {

        katg = $('#'+isBulkPopup+' .sli_rss_2nd').find('option:selected').text();

      }
        
        //console.log(final_interpretation);
    
    
    if($('#'+isBulkPopup+" .slid_2nd_lpa").find('option:selected').text() == 'select')
    {
      var inh = "";   

    } else {

      var inh = $('#'+isBulkPopup+" .slid_2nd_lpa").find('option:selected').text();

    }


    mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });

  $('.sli_rss_2nd').on("change", function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }
      
    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text();

    }   

    if( $('#'+isBulkPopup+' .quinolone_2nd_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('#'+isBulkPopup+' .quinolone_2nd_lpa').find('option:selected').text();

    }        

     
    if($(this).val() != "")
    {
      katg = $(this).val();
    }
      

      if(  $('#'+isBulkPopup+' .slid_2nd_lpa').find('option:selected').text() == "select")
      {
        inh = "";
        
      } else {
                inh = $('#'+isBulkPopup+' .slid_2nd_lpa').find('option:selected').text();

      }   

      mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);
  });

  $('.slid_2nd_lpa').on("change", function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    var isBulkPopup = "";

    if($('#is_bulk_popup').val() == '1')
    {

      isBulkPopup = 'myModal_bulk';

    } else {

      isBulkPopup = 'myModal';

    }
      
    if( $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('#'+isBulkPopup+' .new_mtb_result').find('option:selected').text();

    }   

    if( $('#'+isBulkPopup+' .quinolone_2nd_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('#'+isBulkPopup+' .quinolone_2nd_lpa').find('option:selected').text();

    } 


    if( $('#'+isBulkPopup+' .sli_rss_2nd').find('option:selected').text() == 'select')
    {
      katg = "";

    } else {

      katg = $('#'+isBulkPopup+' .sli_rss_2nd').find('option:selected').text();

    }     

      if($(this).val() != "")
      {
        inh = $(this).val(); 
      }  
    

      mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

});

	$("#test_date").on("change",function (){ 
      //alert('inp changed');	  
	  var dateAr = $(this).val().split('-');
      var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
	  $("#date_reported").val(newDate);
   });
   
  $("#cbnaat_result").on("submit", function(){
    $("#pageloader").fadeIn();
	var zIndex = 9999;

    if ($('body').hasClass('modal-open')) {
        zIndex = parseInt($('div.modal').css('z-index')) + 1;
    }

    $("#pageloader").css({
        'display': 'block',
        'z-index': zIndex
    });

    setTimeout(function(){$("#pageloader").css("display", "none");}, 5000);
  });//submit


  /* $('#cbnaat_result_bulk').on("submit", function(){
        $("#pageloader").fadeIn();
      var zIndex = 9999;

        if ($('body').hasClass('modal-open')) {
            zIndex = parseInt($('div.modal').css('z-index')) + 1;
        }

        $("#pageloader").css({
            'display': 'block',
            'z-index': zIndex
        });

        setTimeout(function(){$("#pageloader").css("display", "none");}, 5000);
  });//submit */

});//document ready

$(document).ready(function(){
	
	$(".modal").on("hidden.bs.modal", function(){
       //location.reload();
    });
	
    $('#myModal').on('shown.bs.modal', function () {
		//$("#firstLPA").hide();
		//$("#secondLPA").hide();
			
		//function when select is changing.	
		function displayline(){ //alert($("#tbu_band").val()); alert($("#tag").val());
			if ($("#tbu_band").val() == 1){ //alert("present"); alert($("#tag").val());
				if($("#tag").val()=="1st line LPA" || $("#tag").val()=="1st Line LPA"){
		            //alert("1st line");
					$("#secondLPA").hide();
					$("#firstLPA").show();
                   	//alert($('#wt3').val());
					//set default value as insert form
					$('#RpoB option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt2 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt3 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt4 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt5 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt6 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt7 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt8 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1DS16V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2aH526Y option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2bH526D option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3S531L option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					///////////////
					$('#katg option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1315 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1S315T1 option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2S315T2 option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					////////////////////
					$('#inha option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1516 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt28 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1C15T option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2A16G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3aT8C option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3bT8A option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
			         //Mtb detected
					if($("#mtb_result option:selected" ).text()=='MTB detected'){ 
						$("#quinolone").prop("disabled",true);
                        $("#slid").prop("disabled",true);	
                         $('#rif option').map(function () {
							//alert($(this).text());
							if ($(this).text() == 'Detected') return this;
						}).attr('selected', 'selected');						
					}
				}
                
				if($("#tag").val()=="2nd Line LPA"||$("#tag").val()=='2nd line LPA'){ //alert("2nd line");
					$("#firstLPA").hide();
					$("#secondLPA").show();
					
					//set default value as insert form
					$('#gyra option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt18590 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt28993 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt39297 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1A90V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2S91P option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3aD94A option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3bD94N option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3cD94G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3dD94H option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#gyrb option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1536541 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1N538D option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2E540V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					//////
					$('#rrs option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1140102 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt21484 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1A1401G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2G1484T option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					////////
					$('#eis option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt137 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt2141210 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt32 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1c14t option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					//MTB detected
					if($("#mtb_result option:selected" ).text()=='MTB detected'){ //alert("here");
						$("#rif").prop("disabled",true);
                        $("#inh").prop("disabled",true);				
					}
					 //Mtb detected
					if($("#mtb_result option:selected" ).text()=='MTB detected'){ 
						$("#rif").prop("disabled",true);
                        $("#inh").prop("disabled",true);	
                        						
					}
				}
                if($("#tag").val()=="1st line LPA  and for 2nd line LPA"){ //alert("both");
					$("#firstLPA").show();
				    $("#secondLPA").show();
					
					//set default value as insert form  of first line
					$('#RpoB option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt2 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt3 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt4 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt5 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt6 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt7 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt8 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1DS16V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2aH526Y option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2bH526D option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3S531L option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					///////////////
					$('#katg option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1315 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1S315T1 option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2S315T2 option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					////////////////////
					$('#inha option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1516 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt28 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1C15T option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2A16G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3aT8C option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3bT8A option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					//set default value as insert form for second line
					$('#gyra option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt18590 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt28993 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt39297 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1A90V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2S91P option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3aD94A option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3bD94N option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3cD94G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut3dD94H option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#gyrb option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1536541 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1N538D option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2E540V option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					//////
					$('#rrs option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt1140102 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt21484 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1A1401G option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					$('#mut2G1484T option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					////////
					$('#eis option').map(function () {
						if ($(this).text() == 'select') return this;
					}).attr('selected', 'selected');
					
					$('#wt137 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt2141210 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#wt32 option').map(function () {
						if ($(this).text() == 'Present') return this;
					}).attr('selected', 'selected');
					
					$('#mut1c14t option').map(function () {
						if ($(this).text() == 'Absent') return this;
					}).attr('selected', 'selected');
					
					//MTB DETCTED
					if($("#mtb_result option:selected" ).text()=='MTB detected'){
						$(".main_rif_val").prop("disabled",false);
                        $("#inh").prop("disabled",false);
                        $("#quinolone").prop("disabled",false);
                        $("#slid").prop("disabled",false);						
					}
				}				
				
			} else  {//tub band absent
				//alert("absent");
				$('#mtb_result option[value="MTB not detected"]').attr('selected','selected');
				$("#inh").prop("disabled",true);
                $("#rif").prop("disabled",true);
                $("#quinolone").prop("disabled",true);
                $("#slid").prop("disabled",true);
				
				//disabled required field
				$('#gyra').prop('required',false);
                $('#gyrb').prop('required',false);
				$('#rrs').prop('required',false);
				$('#eis').prop('required',false);				
				$('#RpoB').prop('required',false);
				$('#katg').prop('required',false);
				$('#inha').prop('required',false);

        

       
				
				$("#firstLPA").hide();
				$("#secondLPA").hide();
			}
		}
		$("#tbu_band").change(displayline);
		
		// AJAX request for final interpretation
		var linetype=1;
		//alert($("#tag").val());
		if($("#tag").val()=="1st line LPA" || $("#tag").val()=="1st Line LPA"){
			linetype=1;
		}
		else if($("#tag").val()=="2nd Line LPA" ||$("#tag").val()=='2nd line LPA'){
			linetype=2;
		}else{
			linetype=3;
		}
		
		$.ajax({
			url: '/getFinalInterpretation/'+linetype,
			type: 'GET',
            dataType: 'html',
			success: function(response){
				//console.log('nikshay======'+response);
				var len = 0;
				if(response != null){
					len = response.length;
				}
				//alert(len);

				if(len > 0){
					$("#final_interpretation").html('');
					$("#final_interpretation").html(response);
				}else{
					$("#final_interpretation").html('select');
				}

			},
			failure: function(response){
				alert("failure");

			}
		});

    });
    
});

$(function(){

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e){
		// Pass form reference to modal for submission on yes/ok
		var form = $(e.relatedTarget).closest('form');
		$(this).find('.modal-footer #confirm').data('form', form);
    });

    $('#confirm_bulk').click(function() {

      if(($('#type_direct').val()!="" || $('#type_indirect').val()!=""))
      {
        var form = $(document).find('form#cbnaat_result_bulk');

        //console.log( $('#cbnaat_result').serialize() );
        var data = $('#cbnaat_result_bulk').serialize();
        form.submit();
      }

    });

  /* Form confirm (yes/ok) handler, submits form*/
  $('#confirm').click( function(){ //alert();
	//alert($('#final_interpretation').val());
    if(($('#type_direct').val()!="" || $('#type_indirect').val()!="") &&($('#final_interpretation').val()!="" )){
       //alert("here");
      // $.post("{{ url('/lpa_interpretation') }}", data, function(ret){
      //   location.reload();
      // });
	  var form = $(document).find('form#cbnaat_result');

     //console.log( $('#cbnaat_result').serialize() );
      var data = $('#cbnaat_result').serialize();
      form.submit();
    }
  });

  $('#canceled').click( function(){

    console.log( $('#cbnaat_result').serialize() );
    var data = $('#cbnaat_result').serialize();

      $.get("{{ url('/lpa_interpretation') }}", data, function(ret){
        location.reload();
      });
    //form.submit();
  });

});





 function openCbnaatForm(enroll_id,sample_ids,tag,sample_id,service_id,rec_flag){
  //console.log("sample_ids", sample_ids.split(','));
  $("#enrollId").val(enroll_id);
  $("#tag").val(tag);
  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);

  $('#is_bulk_popup').val(0);

  if(tag == '1st line LPA')
  {

            $('.quinolone_2nd_lpa').attr('disabled', true);
              $('.sli_rss_2nd').attr('disabled', true);
              $('.slid_2nd_lpa').attr('disabled', true);

              $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.quinolone_2nd_lpa').val();

               $('.sli_rss_2nd').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.sli_rss_2nd').val();

               $('.slid_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.slid_2nd_lpa').val();

               $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.rif_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.rif_1st_lpa').val();

               $('.katg_resi_1st').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.katg_resi_1st').val();

               $('.inh_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.inh_1st_lpa').val();

              $('.rif_1st_lpa').attr('disabled', false);
              $('.katg_resi_1st').attr('disabled', false);
              $('.inh_1st_lpa').attr('disabled', false);


            
  }

  if( tag == '2nd line LPA')
  {
              $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.rif_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.rif_1st_lpa').val();

               $('.katg_resi_1st').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.katg_resi_1st').val();

               $('.inh_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.inh_1st_lpa').val();

              $('.rif_1st_lpa').attr('disabled', true);
              $('.katg_resi_1st').attr('disabled', true);
              $('.inh_1st_lpa').attr('disabled', true);

              $('.quinolone_2nd_lpa').attr('disabled', false);
              $('.sli_rss_2nd').attr('disabled', false);
              $('.slid_2nd_lpa').attr('disabled', false);

              $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.quinolone_2nd_lpa').val();

               $('.sli_rss_2nd').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.sli_rss_2nd').val();

               $('.slid_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.slid_2nd_lpa').val();
  }

              
  
  var sampleArray = sample_ids.split(',');
  $('#sampleid option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleid').append($('<option>', {
          text : item
      }));
  });



  $('#final_interpretation1').val('');
  $('#clinical_trail').val('');
  
  $('#myModal').modal('toggle');
       
	//var _sample = $("#tag").val();
	//alert(tag)

	if(tag=='1st line LPA'||tag=='1st Line LPA')
	{ //alert("1st line LPA");

	  $("#secondLPA").hide();
	  $("#firstLPA").show();
	  
	  $(".slpa"). removeAttr("required");
	  $("#quinolone").val($("#quinolone option:first").val());	  
	  $('#quinolone').attr('disabled',true);
	  $('#quinolone').removeAttr('required');
    $('#sli_rss').attr('disabled',true);
    $('#sli_rss').removeAttr('required');
		
		
		$("#slid").val($("#slid option:first").val());
		$('#slid').attr('disabled',true);
		$('#slid').removeAttr('required');
    
	  $("#mtb_result").change(function(){

			  var _sample = $("#mtb_result").val();
			  if(_sample=='Invalid' || _sample=='MTB not detected'){
				 $("#inh").val($("#inh option:first").val());				
				 $('#inh').attr('disabled',true);
				 $('#inh').removeAttr('required');				 
				
				 $("#rif").val($("#rif option:first").val());
				 $('#rif').attr('disabled',true);
				 $('#rif').removeAttr('required');
			  }else{
						 $('#inh').attr('disabled',false);
						 $('#rif').attr('disabled',false);
						 $("#inh").prop('required',true);
						 $("#rif").prop('required',true);
			  }
		});
	}
	else if(tag=='2nd Line LPA'||tag=='2nd line LPA')
	{    //alert("2nd Line LPA");
		
		  $("#secondLPA").show();
		  $("#firstLPA").hide();
		  $(".flpa"). removeAttr("required");		 
		  $("#inh").val($("#inh option:first").val());
		  $('#inh').attr('disabled',true);
		  $('#inh').removeAttr('required');
      $('#katg_resi').attr('disabled',true);
		  $('#katg_resi').removeAttr('required');
		 
		 
		  $("#rif").val($("#rif option:first").val());
		  $('#rif').attr('disabled',true);
		  $('#rif').removeAttr('required');
		  
	  $("#mtb_result").change(function(){ //alert("change");
			  var _sample = $("#mtb_result").val();
			  if(_sample=='Invalid' || _sample=='MTB not detected'){ //alert("if");
				 
				 $("#quinolone").val($("#quinolone option:first").val());
				 $('#quinolone').attr('disabled',true);
				 $('#quinolone').removeAttr('required');
				
				 $("#slid").val($("#slid option:first").val());
				 $('#slid').attr('disabled',true);
				 $('#slid').removeAttr('required');
			  }else{ //alert("else");
					 $('#quinolone').attr('disabled',false);
					 $('#slid').attr('disabled',false);
					 $("#quinolone").prop('required',true);
					 $("#slid").prop('required',true);
			  }
		});
	}
	/*else {   alert("else");
		   $("#mtb_result").change(function(){
			  var _sample = $("#mtb_result").val();
			  if(_sample=='Invalid' || _sample=='MTB not detected'){

				document.getElementById("quinolone").value = "";
				document.getElementById("slid").value = "";
				document.getElementById("inh").value = "";
				document.getElementById("quinolone").setAttribute("disabled","disabled");
				document.getElementById("inh").setAttribute("disabled","disabled");
				document.getElementById("slid").setAttribute("disabled","disabled");
				document.getElementById("rif").value = "";
				document.getElementById("rif").setAttribute("disabled","disabled");


			  }else{
					  document.getElementById("quinolone").removeAttribute("disabled","disabled");
					  document.getElementById("inh").removeAttribute("disabled","disabled");
					  document.getElementById("slid").removeAttribute("disabled","disabled");
					  document.getElementById("rif").removeAttribute("disabled","disabled");
			  }
		  });
	}*/
			
 }

</script>
<script>

  

$(document).ready(function() {

  arrangeTable('1st line LPA');

    $('#default-btn').css('background', '#1e88e5');
    $('#default-btn').css('border', '#1e88e5');

    $('#default-btn').css('background', '#FFA500');
    $('#default-btn').css('border', '#FFA500');

  $('.filterBtn').on('click', function(){

    var tag = "";

    tag = $(this).val();

    $('.filterBtn').css('background', '#1e88e5');
        $('.filterBtn').css('border', '#1e88e5');

        $(this).css('background', '#FFA500');
        $(this).css('border', '#FFA500');

    arrangeTable(tag);

  });

  
	
	//Confirm ok submit
	$('.resultbtn, #confirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enrollId").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		var tag=$("#tag").val();
		var rec_flag=$("#recFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					  
                        if(response==1){
							$('.alert-danger').removeClass('hide');
							$('.alert-danger').show();
							$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                            $('#confirm').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#confirm').prop("type", "submit");
							$("#confirm").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
} );

  

</script>

 <script>

     var $select_inputs = $('#firstLPA select,#secondLPA select');
     var $head_selects = $('#RpoB, #katg, #inha, #gyra, #gyrb, #rrs, #eis');

     var $value_selects = $select_inputs.not( $head_selects );

     $head_selects.css({'background-color': '#f9ff9d'});

     $value_selects.each(function(i, e){
         var $el = $(e);
         var selected = $.trim( $el.find('option').eq( e.selectedIndex ).text() ).toLowerCase()
         $el.data( 'default-selected', selected );
     });

     $value_selects.change(function(){

         var $select = $(this);
         var text = $.trim( $select.find('option').eq( this.selectedIndex ).text() ).toLowerCase();
         var default_selected = $select.data( 'default-selected' );

         console.log( text, default_selected );

         if( text === default_selected ){
             console.log( 'here' );
             $select.attr('style', '');
         }else{
             if( text === 'present' ){
                 $select.css({'background-color': '#baffba'});
             }else if( text === 'absent' ){
                 $select.css({'background-color': '#ffd1d1'});
             }
         }

     });

     // var $select_inputs = $('#firstLPA select,#secondLPA select');

     // function select_option_colors(){
     //     $select_inputs.each(function(){
     //
     //         var $select = $(this);
     //         var text = $.trim( $select.find('option').eq( this.selectedIndex ).text() ).toLowerCase();
     //
     //         if( text == 'present' ){
     //             $select.css({'background-color': '#baffba'});
     //         }else if( text == 'absent' ){
     //             $select.css({'background-color': '#ffd1d1'});
     //         }else if( text == 'select' ){
     //             $select.css({'background-color': '#f9ff9d'});
     //         }else{
     //             $select.css({});
     //         }
     //
     //     });
     // }
     //
     // select_option_colors();
     // $select_inputs.change( select_option_colors );
 </script>
 {{-- Option Colors --}}

 {{-- bluk store scripts --}}

 <script>

var $bulk_checkboxes = $('.bulk-selected');
        var $bulk_select_all_checkbox = $('#bulk-select-all');


        // Automatically Check or Uncheck "all select" checkbox
        // based on the state of checkboxes in the list.
        $bulk_checkboxes.click(function(){
            if( $bulk_checkboxes.length === $bulk_checkboxes.filter(':checked').length ){
                $bulk_select_all_checkbox.prop('checked', true);
            }
        });


        // Check or Uncheck checkboxes based on the state
        // of "all select" checkbox.
        $bulk_select_all_checkbox.click(function(){
            var checked = $(this).prop('checked');
            $('.bulk-selected').prop('checked', checked);
        });

   function bulk_action_review()
   {
          var $modal = $('#myModal_bulk');
            var selected = [];
            var final_interpretation = "";
            var remarks = "";
            var $checkboxes = $('.bulk-selected:checked');

            // Display an error message and stop if no checkboxes are selected.
            if( $checkboxes.length === 0 ){
                alert("First select one or more items from the list.");
                return;
            }

            if($('#bulk_tag').val() == '1st line LPA')
            {
              $('#firstLPA_bulk').show();
              $('#secondLPA_bulk').hide();

              $('.quinolone_2nd_lpa').attr('disabled', true);
              $('.sli_rss_2nd').attr('disabled', true);
              $('.slid_2nd_lpa').attr('disabled', true);

              $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.quinolone_2nd_lpa').val();

               $('.sli_rss_2nd').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.sli_rss_2nd').val();

               $('.slid_2nd_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.slid_2nd_lpa').val();

              $('.rif_1st_lpa').attr('disabled', false);
              $('.katg_resi_1st').attr('disabled', false);
              $('.inh_1st_lpa').attr('disabled', false);

               $('.new_mtb_result').prop('selectedIndex', 2);
               final_interpretation =  $('.new_mtb_result').val();

               $('.rif_1st_lpa').prop('selectedIndex', 1);
               final_interpretation +=  ', '+$('.rif_1st_lpa').val();

               $('.katg_resi_1st').prop('selectedIndex', 3);
               final_interpretation +=  ', '+$('.katg_resi_1st').val();

               $('.inh_1st_lpa').prop('selectedIndex', 3);
               final_interpretation +=  ', '+$('.inh_1st_lpa').val();

              /* $('.final_interpretation').val(final_interpretation);
              $('.clinical_trail').val(final_interpretation); */

              mtb_1st_result('<?php echo csrf_token();?>', $('.new_mtb_result').val(), $('.rif_1st_lpa').val(), $('.katg_resi_1st').val(), $('.inh_1st_lpa').val());

            } else {

              $('#firstLPA_bulk').hide();
              $('#secondLPA_bulk').show();             

               $('.new_mtb_result').prop('selectedIndex', 0);
               final_interpretation =  $('.new_mtb_result').val();

               $('.rif_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.rif_1st_lpa').val();

               $('.katg_resi_1st').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.katg_resi_1st').val();

               $('.inh_1st_lpa').prop('selectedIndex', 0);
               final_interpretation +=  ', '+$('.inh_1st_lpa').val();

              $('.rif_1st_lpa').attr('disabled', true);
              $('.katg_resi_1st').attr('disabled', true);
              $('.inh_1st_lpa').attr('disabled', true);

              $('.quinolone_2nd_lpa').attr('disabled', false);
              $('.sli_rss_2nd').attr('disabled', false);
              $('.slid_2nd_lpa').attr('disabled', false);              

              $('.new_mtb_result').prop('selectedIndex', 2);
               final_interpretation =  $('.new_mtb_result').val();

               $('.quinolone_2nd_lpa').prop('selectedIndex', 4);
               final_interpretation +=  ', '+$('.quinolone_2nd_lpa').val();

               $('.sli_rss_2nd').prop('selectedIndex', 4);
               final_interpretation +=  ', '+$('.sli_rss_2nd').val();

               $('.slid_2nd_lpa').prop('selectedIndex', 3);
               //final_interpretation +=  ', '+$('.slid_2nd_lpa').val();

              /* $('.final_interpretation').val(final_interpretation);
              $('.clinical_trail').val(final_interpretation); */
              

              mtb_2nd_result('<?php echo csrf_token();?>', $('.new_mtb_result').val(), $('.quinolone_2nd_lpa').val(), $('.sli_rss_2nd').val(), $('.slid_2nd_lpa').val());


            }

            /* $('#firstLPA_bulk').hide();
            $('#secondLPA_bulk').hide(); */

            $('#is_bulk_popup').val('1');

            $modal.modal('show');

            $checkboxes.each(function(i, e){
                selected.push( $(e).val() );

                // Last iteration of the loop.
                if( i === $checkboxes.length - 1 ){
                    $modal.find('input[name="log_ids"]').val( selected.join(',') );
                }
            });
   }


   function arrangeTable(tag)
  {
    
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      }

      if(mm<10) {
          mm = '0'+mm
      }

      today = dd + '-' + mm + '-' + yyyy;

      var url = '{{ route("ajax_lpa_list") }}';

        $('#exampl').DataTable({
            dom: 'Bfrtip',
            bDestroy: true,
            //stateSave: true,
            pageLength:25,

            processing: true,
                          language: {
                              loadingRecords: '&nbsp;',
                              //processing: 'Loading...'
                              processing: '<div class="spinner"></div>'
                          } , 		
            serverSide: true,
            serverMethod: 'post',
            ajax: {
                          url: url,	
                          data: {tag: tag},	  
                          headers: 
                          {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                        },
                        drawCallback: function (settings) { 
                            // Here the response
                            var response = settings.json;
                            //console.log(response);                            
                            $('#tot_1st_lpa').html('('+response.no_1st_lpa+')');
                            $('#tot_2nd_lpa').html('('+response.no_2st_lpa+')');
                            $('#bulk_tag').val(response.bulk_tag);
                          },
                        columns: [  
                          { data: 'inputs'}, 
                        { data: 'ID',className: "hide_column"},                                                                                    
                        { data: 'enrollment'},
                        { data: 'sample' },
                        { data: 'tag' },
                        { data: 'naat' },
                        { data: 'action' },
                        
                      ],
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'LIMS_lpa_'+today+''
                },
                        {
                            text: 'Submit',						
                            action: bulk_action_review
                        }
            ],
            "order": [[ 1, "desc" ]],
            columnDefs: [
                          { targets: [0], orderable: false }
                        ]
        });

  }

  /* Updated on 20-03-2021 */

  $(document).ready(function() {

    $('.tbu_band_cls').change(function() {

      var final_interpretation = "";
      //alert('test');
      if($(this).val() == '0')
      {
        if($('#bulk_tag').val() == '1st line LPA')
        {
          //alert('test');
          $('.new_mtb_result').prop('selectedIndex', 1);          

          $('.rif_1st_lpa').prop('selectedIndex', 0);
          $('.rif_1st_lpa').prop('disabled', true);

          $('.katg_resi_1st').prop('selectedIndex', 0);
          $('.katg_resi_1st').prop('disabled', true);

          $('.inh_1st_lpa').prop('selectedIndex', 0);
          $('.inh_1st_lpa').prop('disabled', true);

          mtb_1st_result('<?php echo csrf_token();?>', $('.new_mtb_result').val(), $('.rif_1st_lpa').val(), $('.katg_resi_1st').val(), $('.inh_1st_lpa').val());                       

        } 
        else if( $('#bulk_tag').val() == '2nd line LPA' )
        {
          $('.new_mtb_result').prop('selectedIndex', 1); 

          $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
          $('.quinolone_2nd_lpa').prop('disabled', true);

          $('.sli_rss_2nd').prop('selectedIndex', 0);
          $('.sli_rss_2nd').prop('disabled', true);

          $('.slid_2nd_lpa').prop('selectedIndex', 0);
          $('.slid_2nd_lpa').prop('disabled', true);

          mtb_2nd_result('<?php echo csrf_token();?>', $('.new_mtb_result').val(), $('.quinolone_2nd_lpa').val(), $('.sli_rss_2nd').val(), $('.slid_2nd_lpa').val());                       


        }

        //final_interpretation =  $('.new_mtb_result').val();
          

      } else {

        if($('#bulk_tag').val() == '1st line LPA')
        {
          //alert('test');
          $('.new_mtb_result').prop('selectedIndex', 0);          

          $('.rif_1st_lpa').prop('selectedIndex', 0);
          $('.rif_1st_lpa').prop('disabled', false);

          $('.katg_resi_1st').prop('selectedIndex', 0);
          $('.katg_resi_1st').prop('disabled', false);

          $('.inh_1st_lpa').prop('selectedIndex', 0);
          $('.inh_1st_lpa').prop('disabled', false);        

        } else if( $('#bulk_tag').val() == '2nd line LPA' )
        {
          $('.new_mtb_result').prop('selectedIndex', 0); 

          $('.quinolone_2nd_lpa').prop('selectedIndex', 0);
          $('.quinolone_2nd_lpa').prop('disabled', false);

          $('.sli_rss_2nd').prop('selectedIndex', 0);
          $('.sli_rss_2nd').prop('disabled', false);

          $('.slid_2nd_lpa').prop('selectedIndex', 0);
          $('.slid_2nd_lpa').prop('disabled', false);

        }

      }

    });
  });

  function mtb_1st_result(token, mtb, rif_1st_lpa, katg_resi_1st, inh_1st_lpa)
  {

          $.ajax({
                type: "post",
                url: "{{ route('get-mtb-1st-result') }}",
                data: {
                      _token: token,
                      mtb: mtb,
                      rif_1st_lpa: rif_1st_lpa,
                      katg_resi_1st: katg_resi_1st,
                      inh_1st_lpa: inh_1st_lpa
                },
                success: function (data) {
                  result = JSON.parse(data);
                  //console.log(result.final_interpretation);
                  $('.final_interpretation').val(result.final_interpretation);
                  $('.clinical_trail').val(result.clinical_interpretation);                
                }
            });

  }

  function mtb_2nd_result(token, mtb, quinolone_2nd_lpa, sli_rss_2nd, slid_2nd_lpa)
  {
    

          $.ajax({
                type: "post",
                url: "{{ route('get-mtb-2nd-result') }}",
                data: {
                      _token: token,
                      mtb: mtb,
                      rif_1st_lpa: quinolone_2nd_lpa,
                      katg_resi_1st: sli_rss_2nd,
                      inh_1st_lpa: slid_2nd_lpa
                },
                success: function (data) {
                  result = JSON.parse(data);
                  //console.log(result.final_interpretation);
                  $('.final_interpretation').val(result.final_interpretation);
                  $('.clinical_trail').val(result.clinical_interpretation);                
                }
            });

  }

</script>

@endsection
