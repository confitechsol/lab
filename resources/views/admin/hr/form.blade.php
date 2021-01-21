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

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">HR</h3>

                    </div>

                </div>

               <!--  <form action="{{ url('/enroll') }}" class="form-horizontal form-material" method="post" enctype='multipart/form-data'>
 -->
                @if($data['hr']->id>0)
                   <form id="createForm" action="{{ url('/hr/'.$data['hr']->id) }}" method="post">
                     <input name="_method" type="hidden" value="patch">
                   @else
                   <form id="createForm" action="{{ url('/hr') }}" method="post" role="alert">
                 @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">


                                	<div class="row">
                                		<div class="col ">
	                                        <label class="col-md-12">Name <span class="red">*</span></label>
	                                        <div class="col-md-12">
	                                            <input type="text" name="name" class="form-control form-control-line" value="{{ old('name', $data['hr']->name) }}" required="required">
	                                        </div>
                                    	</div>

                                        <div class="col ">
                                             <label class="col-md-12">Adhaar </label>
                                            <div class="col-md-12">
                                                <input type="text" name="adhaar" value="<?php if(!empty($data['hr']->adhaar)){
                                                    echo '********'.substr($data['hr']->adhaar,8);
                                                  } ?>" class="form-control form-control-line" minlength="12" maxlength="12" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">Designation <span class="red">*</span></label>
	                                        <div class="col-sm-12">

                                              <select name="designation" class="form-control form-control-line" id="designation" required>
                                                  <option value="">Select</option>
                                                  @foreach ($data['designation'] as $key => $designation)
                                                          <option value="{{$designation->designation}}"
                                                            @if($data['hr']->designation == $designation->designation)
                                                              selected
                                                            @endif
                                                          >{{$designation->designation}}</option>

                                                  @endforeach
                                              </select>
                                          </div>
                                        </div>

                                        <div class="col hide" id="other_designation">
                                            <label class="col-sm-12">Other Designation <span class="red">*</span> </label>
  	                                        <div class="col-md-12">
  	                                            <input type="text" name="other_designation" class="form-control form-control-line" value="{{ old('other_designation', $data['hr']->other_designation) }}" >
  	                                        </div>
	                                        <div class="col-sm-12">

                                          </div>
                                        </div>

                                        <div class="col ">
                                             <label class="col-md-12">Type of Employment <span class="red">*</span></label>
	                                        <div class="col-md-12">

                                                <select name="type_qualification" class="form-control form-control-line" required="required">
                                                    <option value="">--Select--</option>
                                                    <option value="Partime"
                                                    @if($data['hr']->type_qualification=="Partime")
                                                            selected="selected"
                                                    @endif
                                                    >Partime</option>
                                                    <option value="Fulltime"
                                                    @if($data['hr']->type_qualification=="Fulltime")
                                                            selected="selected"
                                                    @endif
                                                    >Fulltime</option>
                                                </select>
	                                        </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">Qualification </label>
                                            <div class="col-md-12">
                                                <input type="text" name="qualification" value="{{ old('qualification', $data['hr']->qualification) }}" class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="col ">

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">Mode of Employment <span class="red">*</span></label>
	                                        <div class="col-sm-12">
	                                            <select  name="mode" class="form-control form-control-line" required="required">
                                                    <option value="">--Select--</option>
	                                                <option value="Central Govt."
                                                    @if($data['hr']->mode=="Central Govt.")
                                                            selected="selected"
                                                    @endif
                                                    >Central Govt.</option>
	                                                <option value="State Govt."
                                                    @if($data['hr']->mode=="State Govt.")
                                                            selected="selected"
                                                    @endif
                                                    >State Govt.</option>
	                                                <option value="Institutional"
                                                    @if($data['hr']->mode=="Institutional")
                                                            selected="selected"
                                                    @endif
                                                    >Institutional</option>
	                                                <option value="Contractual(RNTCP,Private,Project,Others)"
                                                    @if($data['hr']->mode=="Contractual(RNTCP,Private,Project,Others)")
                                                            selected="selected"
                                                    @endif
                                                    >Contractual(RNTCP,Private,Project,Others)</option>
	                                            </select>
	                                        </div>
                                        </div>
                                        <div class="col">
                                           <label class="col-md-12">Date of Joining <span class="red">*</span></label>
                                         <!-- <div class="col-md-12" id="sandbox-container1"> -->
                                        <div id=5 class="date_class col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                               <input type="date" placeholder="dd-mm-yy"
                                                name="date_joining" value="{{ old('date_joining', $data['hr']->date_joining) }}" class="form-control" required="required">
                                         </div>
                                       </div>
                                    </div>
                                    <div class="row">
										  <div class="col">
											 <!----<label class="col-md-12">Date of Reliving </label>
											  <div class="col-md-12">
												<input type="date" placeholder="dd-mm-yy"
												max="{{ date('Y-m-d')}}" name="date_reliving" value="{{ old('date_reliving', $data['hr']->date_reliving) }}" class="form-control" >
											  </div>----->
										  </div>
                                        <div class="col">
                                            <label class="col-sm-12">Annual Health Checkup </label>
	                                        <div class="col-sm-12">
	                                            <select name="health_check" class="form-control form-control-line" >
                                                    <option value="">--Select--</option>
	                                                <option value="Yes"
                                                    @if($data['hr']->health_check=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
	                                                <option value="No"
                                                    @if($data['hr']->health_check=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
	                                                <option value="Ongoing"
                                                    @if($data['hr']->health_check=="Ongoing")
                                                            selected="selected"
                                                    @endif
                                                    >Ongoing</option>
	                                            </select>
	                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">Vaccination (Hep B) </label>
	                                        <div class="col-sm-12">
	                                            <select name="vaccination" class="form-control form-control-line" >
                                                    <option value="">--Select--</option>
	                                                <option value="Yes"
                                                    @if($data['hr']->vaccination=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
	                                                <option value="No"
                                                    @if($data['hr']->vaccination=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
	                                                <option value="N/A"
                                                    @if($data['hr']->vaccination=="N/A")
                                                            selected="selected"
                                                    @endif
                                                    >N/A</option>
	                                            </select>
	                                        </div>
                                        </div>
                                        <div class="col">
                                           <label class="col-md-12">Organization/Source of funding for position </label>

                                           <div class="col-sm-12">
                                                <select name="org_source" id="org_source" class="form-control form-control-line" >
                                                    <option value="">--Select--</option>
                                                    <option value="Central Govt."
                                                    @if($data['hr']->org_source=="Central Govt.")
                                                            selected="selected"
                                                    @endif
                                                    >Central Govt.</option>
                                                    <option value="State Govt."
                                                    @if($data['hr']->org_source=="State Govt.")
                                                            selected="selected"
                                                    @endif
                                                    >State Govt.</option>
                                                    <option value="Institutional"
                                                    @if($data['hr']->org_source=="Institutional")
                                                            selected="selected"
                                                    @endif
                                                    >Institutional</option>

                                                    <option value="Contractual"
                                                    @if($data['hr']->org_source=="Contractual")
                                                            selected="selected"
                                                    @endif
                                                    >Contractual</option>
                                                    <option value="RNTCP"
                                                    @if($data['hr']->org_source=="RNTCP")
                                                            selected="selected"
                                                    @endif
                                                    >RNTCP</option>
                                                    <option value="Private"
                                                    @if($data['hr']->org_source=="Private")
                                                            selected="selected"
                                                    @endif
                                                    >Private</option>

                                                    <option value="Project"
                                                    @if($data['hr']->org_source=="Project")
                                                            selected="selected"
                                                    @endif
                                                    >Project</option>
                                                    <option value="Others"
                                                    @if($data['hr']->org_source=="Others")
                                                            selected="selected"
                                                    @endif
                                                    >Others</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col hide" id="org_source_other">
                                          <label class="col-sm-6">Organization/Source of funding for position Other</label>
                                              <div class="col-sm-6">
                                                   <input type="text" class="form-control form-control-line" value="{{ old('org_source_other', $data['hr']->org_source_other) }}" name="org_source_other">
                                              </div>
                                        </div>

                                    </div>

                                     <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">Date of Reliving from current post </label>
                                            <div class="col-md-12">
                                                <input type="date" name="date_reliving_curr"
                                                max="{{ date('Y-m-d')}}" value="{{ old('date_reliving_curr', $data['hr']->date_reliving_curr) }}" class="form-control form-control-line" >
                                            </div>
                                        </div>

                                        <div class="col ">

                                            <div class="col-md-12">


                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                      <div class="col ">
                                        <label class="col-md-12">Name of Refresher Training</label>
                                       <div class="col-md-12">
                                         <input type="text" name="refresher_training_name" value="<?php if(!empty($data['hr']->refresher_training_name)){
                                          echo $data['hr']->refresher_training_name;
                                          }else{
                                            echo "";
                                          } ?>" class="form-control"/>
                                       </div>
                                      </div>
                                        <div class="col">
                                          <label class="col-md-12">Date for Refresher Training</label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="refresher_training_date" value="{{ $data['hr']->refresher_training_date  }}" class="form-control " >

                                         </div>
                                        </div>
                                    </div>







                                    <div class="row">
                                      <div class="col ">
                                        <label class="col-md-12">Bio Safety Training </label>
                                       <div class="col-md-12">

                                         <select name="bio_safe_t" class="form-control form-control-line onchange" >
                                             <option value="">--Select--</option>
                                             <option value="Yes"
                                            <?php if($data['hr']->bio_safe_t =="Yes"):
                                                echo "selected";
                                             endif; ?>
                                             >Yes</option>
                                             <option value="No"
                                              <?php if($data['hr']->bio_safe_t =="No"):
                                                echo "selected";
                                             endif; ?>
                                             >No</option>
                                         </select>
                                       </div>
                                      </div>



                                        <div class="col">
                                          <label class="col-md-12">Date for biosafety Training </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_biosafty" value="{{ old('date_biosafty', $data['hr']->date_biosafty) }}" class="form-control" >

                                         </div>
                                        </div>
                                    </div>










                                    <div class="row">
                                      <div class="col ">
                                        <label class="col-md-12">Orientation Training  </label>
                                       <div class="col-md-12">

                                           <select name="orientation_training" class="form-control form-control-line onchange" >
                                               <option value="">--Select--</option>
                                               <option value="Yes"
                                               @if($data['hr']->orientation_training=="Yes")
                                                       selected="selected"
                                               @endif
                                               >Yes</option>
                                               <option value="No"
                                               @if($data['hr']->orientation_training=="No")
                                                       selected="selected"
                                               @endif
                                               >No</option>
                                           </select>
                                       </div>
                                      </div>
                                        <div class="col">
                                          <label class="col-md-12">Date for Orientation Training </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_orientation" value="{{ old('date_orientation', $data['hr']->date_orientation) }}" class="form-control " >

                                         </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                       <div class="col">
                                           <label class="col-md-12">Fire Safety training </label>
                                           <div class="col-md-12">

                                               <select name="fire_safe_t" class="form-control form-control-line onchange" >
                                                   <option value="">--Select--</option>
                                                   <option value="Yes"
                                                   @if($data['hr']->fire_safe_t=="Yes")
                                                           selected="selected"
                                                   @endif
                                                   >Yes</option>
                                                   <option value="No"
                                                   @if($data['hr']->fire_safe_t=="No")
                                                           selected="selected"
                                                   @endif
                                                   >No</option>
                                               </select>
                                           </div>


                                       </div>
                                       <div class="col">
                                         <label class="col-md-12">Date for Fire safety training </label>
                                        <div class="col-md-12">
                                          <input type="date" placeholder="dd-mm-yy"
                                          max="{{ date('Y-m-d')}}" name="date_firesafty" value="{{ old('date_firesafty', $data['hr']->date_firesafty) }}" class="form-control" >

                                        </div>


                                       </div>
                                   </div>
                                   <div class="row">
                                     <div class="col ">
                                       <label class="col-md-12">QMS training </label>
                                       <div class="col-md-12">

                                            <select name="qms" class="form-control form-control-line onchange" >
                                                <option value="">--Select--</option>
                                                <option value="Yes"
                                                @if($data['hr']->qms=="Yes")
                                                        selected="selected"
                                                @endif
                                                >Yes</option>
                                                <option value="No"
                                                @if($data['hr']->qms=="No")
                                                        selected="selected"
                                                @endif
                                                >No</option>
                                            </select>
                                        </div>

                                     </div>
                                       <div class="col">
                                         <label class="col-md-12">Date for QMS training </label>
                                        <div class="col-md-12">
                                          <input type="date" placeholder="dd-mm-yy"
                                          max="{{ date('Y-m-d')}}" name="date_qms" value="{{ old('date_qms', $data['hr']->date_qms) }}" class="form-control" >

                                        </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                     <div class="col ">
                                         <label class="col-md-12">Bio Waste management training</label>
                                        <div class="col-md-12">

                                             <select name="bio_waste_man" class="form-control form-control-line onchange" >
                                                 <option value="">--Select--</option>
                                                 <option value="Yes"
                                                 @if($data['hr']->bio_waste_man=="Yes")
                                                         selected="selected"
                                                 @endif
                                                 >Yes</option>
                                                 <option value="No"
                                                 @if($data['hr']->bio_waste_man=="No")
                                                         selected="selected"
                                                 @endif
                                                 >No</option>
                                             </select>
                                         </div>
                                     </div>
                                      <div class="col">
                                        <label class="col-md-12">Date for Bio Waste management </label>
                                       <div class="col-md-12">
                                         <input type="date" placeholder="dd-mm-yy"
                                         max="{{ date('Y-m-d')}}" name="date_biowaste" value="{{ old('date_biowaste', $data['hr']->date_biowaste) }}" class="form-control" >

                                       </div>


                                      </div>
                                  </div>

                                    <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">Liquid Culture Training (MGIT 960) </label>
                                           <div class="col-md-12">

                                                <select name="lc" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->lc=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->lc=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date for Liquid Culture Training </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_lc" value="{{ old('date_lc', $data['hr']->date_lc) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">Solid Culture (LJ) training</label>
                                           <div class="col-md-12">

                                                <select name="lj" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->lj=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->lj=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date for Solid Culture Training </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_lj" value="{{ old('date_lj', $data['hr']->date_lj) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">GeneXpert </label>
                                            <div class="col-md-12">

                                                <select name="geneXpert" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->geneXpert=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->geneXpert=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of GeneXpert </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_GeneXpert" value="{{ old('date_GeneXpert', $data['hr']->date_GeneXpert) }}" class="form-control" >
                                         </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">DST (LC) First Line </label>
                                           <div class="col-md-12">

                                                <select name="dst" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->dst=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->dst=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of DST (LC) First Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_dst" value="{{ old('date_dst', $data['hr']->date_dst) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">DST (LC) Second Line </label>
                                           <div class="col-md-12">

                                                <select name="dst_lc_2" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->dst_lc_2=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->dst_lc_2=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of DST (LC) Second Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_dst_lc_2" value="{{ old('date_dst_lc_2', $data['hr']->date_dst_lc_2) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">DST (LJ) First Line </label>
                                           <div class="col-md-12">

                                                <select name="dst_lj_1" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->dst_lj_1=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->dst_lj_1=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of DST (LJ) First Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_dst_lj_1" value="{{ old('date_dst_lj_1', $data['hr']->date_dst_lj_1) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">DST (LJ) Second Line </label>
                                           <div class="col-md-12">

                                                <select name="dst_lj_2" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->dst_lj_2=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->dst_lj_2=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of DST (LJ) Second Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_dst_lj_2" value="{{ old('date_dst_lj_2', $data['hr']->date_dst_lj_2) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">

                                        <div class="col ">
                                             <label class="col-md-12">LPA 1st Line </label>
                                            <div class="col-md-12">

                                                <select name="lpa" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->lpa=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->lpa=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of LPA 1st Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_lpa" value="{{ old('date_lpa', $data['hr']->date_lpa) }}" class="form-control" >
                                         </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">LPA 2st Line </label>
                                            <div class="col-md-12">

                                                <select name="lpa_2" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->lpa_2=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->lpa_2=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of LPA 2st Line </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_lpa_2" value="{{ old('date_lpa_2', $data['hr']->date_lpa_2) }}" class="form-control" >
                                         </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">Microscopy </label>
                                            <div class="col-md-12">
                                                <select name="microscopy" class="form-control form-control-line onchange" >
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->microscopy=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->microscopy=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                          <label class="col-md-12">Date of Microscopy </label>
                                         <div class="col-md-12">
                                           <input type="date" placeholder="dd-mm-yy"
                                           max="{{ date('Y-m-d')}}" name="date_microscopy" value="{{ old('date_microscopy', $data['hr']->date_microscopy) }}" class="form-control" >
                                         </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col ">
                                             <label class="col-md-12">Other </label>
                                            <div class="col-md-12">
                                                <select name="other" class="form-control form-control-line onchange" id="other">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                    @if($data['hr']->other=="Yes")
                                                            selected="selected"
                                                    @endif
                                                    >Yes</option>
                                                    <option value="No"
                                                    @if($data['hr']->other=="No")
                                                            selected="selected"
                                                    @endif
                                                    >No</option>
                                                </select>
                                            </div>
                                        </div>

                                          <div class="col hide" id="other_view1">
                                            <label class="col-md-12">Other training name</label>
                                           <div class="col-md-12">
                                             <input type="text" name="name_other" value="{{ old('name_other', $data['hr']->name_other) }}" class="form-control" >
                                           </div>
                                          </div>
                                          <div class="col hide" id="other_view2">
                                            <label class="col-md-12">Date of other training </label>
                                           <div class="col-md-12">
                                             <input type="date" placeholder="dd-mm-yy"
                                             max="{{ date('Y-m-d')}}" name="date_other" value="{{ old('date_other', $data['hr']->date_other) }}" class="form-control" >
                                           </div>
                                          </div>

                                    </div>
									<div class="row">
									  <div class="col">
                                         <label class="col-md-12">Date of Reliving </label>
                                          <div class="col-md-12">
                                            <input type="date" placeholder="dd-mm-yy"
                                            max="{{ date('Y-m-d')}}" name="date_reliving" value="{{ old('date_reliving', $data['hr']->date_reliving) }}" class="form-control" >
                                          </div>
                                      </div>
									  <div class="col">
									  </div>
									</div>






                                </div>
                            </div>
                        </div>





                        <div class="col-12">

                            <button class="btn btn-info">Save</button>
                            <a class="btn btn-warning" href="{{url('/hr')}}">Cancel</a>
                        </div>

                    </div>
                </form>

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

<script type="text/javascript">
  $(document).ready(function() {

    var _sample = $('#org_source').find(":selected").val();
    if(_sample=='Others'){
      $("#org_source_other").removeClass("hide");
    }else{
      $("#org_source_other").addClass("hide");
    }
  });
  $(function () {
        $("#org_source").change(function(){
            var _sample = $(this).find(":selected").val();
            if(_sample=='Others'){
              $("#org_source_other").removeClass("hide");
              document.getElementById("org_source_other").setAttribute("required","required");
            }else{
              $("#org_source_other").addClass("hide");
              document.getElementById("org_source_other").removeAttribute("required","required");
            }
        });
        $("#other").change(function(){
          var _sample = $(this).val();
          console.log(_sample);
          if(_sample=='Yes'){
            $("#other_view1").removeClass("hide");
            $("#other_view2").removeClass("hide");
            //document.getElementById("name_other").setAttribute("required","required");
          }else{
            $("#other_view1").addClass("hide");
            $("#other_view2").addClass("hide");
          }
        });
        $(document).on("change", "#designation" , function() {
          var _sample = $(this).val();
          if(_sample=='Others'){
            $("#other_designation").removeClass("hide");
            document.getElementById("other_designation").setAttribute("required","required");
          }else{
            $("#other_designation").addClass("hide");
          }
        });

  });
</script>


<script>
$(document).ready(function(){


var biosafety=$("input[name='date_biosafty']").val();
var orient=$("input[name='date_orientation']").val();
var fire=$("input[name='date_firesafty']").val();
var qms_safe=$("input[name='date_qms']").val();
var biowast=$("input[name='date_biowaste']").val();
var lc_dt=$("input[name='date_lc']").val();
var lj_dt=$("input[name='date_lj']").val();
var GeneXpert=$("input[name='date_GeneXpert']").val();
var dst_dt=$("input[name='date_dst']").val();
var dst_lc2=$("input[name='date_dst_lc_2']").val();
var dst_lj1=$("input[name='date_dst_lj_1']").val();
var dst_lj2=$("input[name='date_dst_lj_2']").val();
var lpa_dt=$("input[name='date_lpa']").val();
var lpa2_dt=$("input[name='date_lpa_2']").val();
var micro_date=$("input[name='date_microscopy']").val();
var other_dt=$("input[name='date_other']").val();



if(biosafety == '' || biosafety == null){
    $("input[name='date_biosafty']").attr("readonly",true);
}




if(orient == '' || orient == null){
    $("input[name='date_orientation']").attr("readonly",true);
}



if(fire == '' || fire == null){
    $("input[name='date_firesafty']").attr("readonly",true);
}

if(qms_safe == '' || qms_safe == null){
    $("input[name='date_qms']").attr("readonly",true);
}

if(biowast == '' || biowast == null){
    $("input[name='date_biowaste']").attr("readonly",true);
}




if(lc_dt == '' || lc_dt == null){
    $("input[name='date_lc']").attr("readonly",true);
}



if(lj_dt == '' || lj_dt == null){
    $("input[name='date_lj']").attr("readonly",true);
}


if(GeneXpert == '' || GeneXpert == null){
    $("input[name='date_GeneXpert']").attr("readonly",true);
}


if(dst_dt == '' || dst_dt == null){
    $("input[name='date_dst']").attr("readonly",true);
}
if(dst_lc2 == '' || dst_lc2 == null){
    $("input[name='date_dst_lc_2']").attr("readonly",true);
}

if(dst_lj1 == '' || dst_lj1 == null){
    $("input[name='date_dst_lj_1']").attr("readonly",true);
}


if(dst_lj2 == '' || dst_lj2 == null){
    $("input[name='date_dst_lj_2']").attr("readonly",true);
}

if(lpa_dt == '' || lpa_dt == null){
    $("input[name='date_lpa']").attr("readonly",true);
}
if(lpa2_dt == '' || lpa2_dt == null){
    $("input[name='date_lpa_2']").attr("readonly",true);
}

if(micro_date == '' || micro_date == null){
  $("input[name='date_microscopy']").attr("readonly",true);
}

if(other_dt == '' || other_dt == null){
    $("input[name='date_other']").attr("readonly",true);
}




$(".onchange").on("change",function(){

var val=$(this).val();
var attr_name=$(this).attr('name');


if(val == 'No' || val == '' || val == null){
  //alert(attr_name)
  if(attr_name == 'bio_safe_t'){
    $("input[name='date_biosafty']").attr("readonly",true);
    $("input[name='date_biosafty']").prop("required",false);
  }else if(attr_name == 'orientation_training'){

    $("input[name='date_orientation']").attr("readonly",true);
$("input[name='date_orientation']").prop("required",false);

  }else if(attr_name =='fire_safe_t'){

    $("input[name='date_firesafty']").attr("readonly",true);
$("input[name='date_firesafty']").prop("required",false);
  }else if(attr_name =='qms'){

    $("input[name='date_qms']").attr("readonly",true);
$("input[name='date_qms']").prop("required",false);
  }else if(attr_name =='bio_waste_man'){
    $("input[name='date_biowaste']").attr("readonly",true);
$("input[name='date_biowaste']").prop("required",false);

  }else if(attr_name =='lc'){
    $("input[name='date_lc']").attr("readonly",true);
$("input[name='date_lc']").prop("required",false);


  }else if(attr_name =='lj'){
$("input[name='date_lj']").attr("readonly",true);
$("input[name='date_lj']").prop("required",false);

  }else if(attr_name =='geneXpert'){
$("input[name='date_GeneXpert']").attr("readonly",true);
$("input[name='date_GeneXpert']").prop("required",false);

  }else if(attr_name =='dst'){

$("input[name='date_dst']").attr("readonly",true);
$("input[name='date_dst']").prop("required",false);
  }else if(attr_name =='dst_lc_2'){
$("input[name='date_dst_lc_2']").attr("readonly",true);
$("input[name='date_dst_lc_2']").prop("required",false);

  }else if(attr_name =='dst_lj_1'){
$("input[name='date_dst_lj_1']").attr("readonly",true);
$("input[name='date_dst_lj_1']").prop("required",false);

  }else if(attr_name =='dst_lj_2'){
    $("input[name='date_dst_lj_2']").attr("readonly",true);
$("input[name='date_dst_lj_2']").prop("required",false);

  }else if(attr_name =='lpa'){
    $("input[name='date_lpa']").attr("readonly",true);
  $("input[name='date_lpa']").prop("required",false);

  }else if(attr_name =='lpa_2'){
    $("input[name='date_lpa_2']").attr("readonly",true);
$("input[name='date_lpa_2']").prop("required",false);

  }else if(attr_name =='microscopy'){
    $("input[name='date_microscopy']").attr("readonly",true);
$("input[name='date_microscopy']").prop("required",false);

  }else if(attr_name =='other'){
    $("input[name='date_other']").attr("readonly",true);
    $("input[name='date_other']").prop("required",false);
  }

}else{


  if(attr_name == 'bio_safe_t'){
    $("input[name='date_biosafty']").attr("readonly",false);
    $("input[name='date_biosafty']").prop("required",true);
  }else if(attr_name == 'orientation_training'){

    $("input[name='date_orientation']").attr("readonly",false);
  $("input[name='date_orientation']").prop("required",true);

  }else if(attr_name =='fire_safe_t'){

    $("input[name='date_firesafty']").attr("readonly",false);
  $("input[name='date_firesafty']").prop("required",true);

  }else if(attr_name =='qms'){

    $("input[name='date_qms']").attr("readonly",false);
  $("input[name='date_qms']").prop("required",true);
  }else if(attr_name =='bio_waste_man'){
    $("input[name='date_biowaste']").attr("readonly",false);
  $("input[name='date_biowaste']").prop("required",true);

  }else if(attr_name =='lc'){
    $("input[name='date_lc']").attr("readonly",false);

  $("input[name='date_lc']").prop("required",true);

  }else if(attr_name =='lj'){
$("input[name='date_lj']").attr("readonly",false);
  $("input[name='date_lj']").prop("required",true);

  }else if(attr_name =='geneXpert'){
$("input[name='date_GeneXpert']").attr("readonly",false);

  $("input[name='date_GeneXpert']").prop("required",true);
  }else if(attr_name =='dst'){
  $("input[name='date_dst']").prop("required",true);
$("input[name='date_dst']").attr("readonly",false);

  }else if(attr_name =='dst_lc_2'){
$("input[name='date_dst_lc_2']").attr("readonly",false);
  $("input[name='date_dst_lc_2']").prop("required",true);

  }else if(attr_name =='dst_lj_1'){
$("input[name='date_dst_lj_1']").attr("readonly",false);
  $("input[name='date_dst_lj_1']").prop("required",true);

  }else if(attr_name =='dst_lj_2'){
    $("input[name='date_dst_lj_2']").attr("readonly",false);
  $("input[name='date_dst_lj_2']").prop("required",true);

  }else if(attr_name =='lpa'){

    $("input[name='date_lpa']").attr("readonly",false);
  $("input[name='date_lpa']").prop("required",true);

  }else if(attr_name =='lpa_2'){
    $("input[name='date_lpa_2']").attr("readonly",false);
  $("input[name='date_lpa_2']").prop("required",true);

  }else if(attr_name =='microscopy'){
    $("input[name='date_microscopy']").attr("readonly",false);
  $("input[name='date_microscopy']").prop("required",true);

  }else if(attr_name =='other'){
    $("input[name='date_other']").attr("readonly",false);
  $("input[name='date_other']").prop("required",true);
  }


}





});

});
</script>

@endsection
