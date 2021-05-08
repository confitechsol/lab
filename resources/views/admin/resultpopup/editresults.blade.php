<div class="modal fade" id="lparesultpopupDiv" role="dialog">
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
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollIdlpa" value="">
                <input type="hidden" name="editresult" id="editresult" value="edit">
                <input type="hidden" name="tag" id="tag" value="">

                <label class="col-md-12"><h6>Sample ID:</h6></label>
                    <div class="col-md-12">
                       <input class="form-control form-control-line" name="sampleid" id="sampleidlpa">

                     </input>
                   </div>

                <label class="col-md-12"><h6>Lab Serial </h6></label>
                    <div class="col-md-6">
                       <!-- <select class="form-control form-control-line sampleId" name="type" value="" id="type" required >
                        <option value="">select</option>
                        <option value="Direct">Direct</option>
                        <option value="Indirect">Indirect</option>
                       </select> -->
                        <input type="text" class="form-control form-control-line sampleId" name="type" id="type">
                       <input type="checkbox"  name="type_direct" value="Direct" checked> Direct<br>
                       <input type="checkbox" name="type_indirect" value="Indirect"> Indirect<br>

                   </div>
                   <br>
                  <label class="col-md-6"><h6>TUB Band : <span class="red">*</span> </h6></label>
                    <div class="col-md-6">
                       <select class="form-control form-control-line tbu_band_cls" name="tbu_band" value="" id="tbu_band" required>                        
                        <option value="0">Absent</option>
						            <option value="1">Present</option>
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
					   <input type="hidden" name="hid_final_interpretation" id="hid_final_interpretation" value="">
                       <input type="text" class="form-control form-control-line final_interpretation" name="final_interpretation" value="" id="final_interpretation" readonly>                        
                   </div>
                  </div>
				 </div><br/>
         <div class="row">
          <div class="col">
                     <label class="col-md-12"><h6>Remarks : <span class="red">*</span></h6></label>
                     <div class="col-md-12">              
                      <input class="form-control form-control-line clinical_trail" name="clinical_trail" value="" id="clinical_trail" readonly>                        
                    </div>
                   </div>
          </div><br/>
				 
                 <div class="row">
                  <div class="col">
                    <label class="col-md-12"><h6>Date Result :</h6></label>
                    <div class="col-md-12">
                       <div class="col-md-12">
                       <input type="text" name="test_date" value="{{date('d-m-Y')}}" class="form-control form-control-line" readonly>
                   </div>
                   </div>

                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>Date Reported :</h6></label>
                    <div class="col-md-12">
                       <input type="text" name="test_date" value="" class="form-control form-control-line" readonly>
                   </div>
                  </div>
                  <div class="col">
                    <label class="col-md-12"><h6>Reported By :</h6></label>
                    <div class="col-md-12">
                      <input type="text" name="created_by" value="" class="form-control form-control-line" readonly>
                   </div>
                  </div>
                  <label class="col-md-12">Comments : <span class="red">*</span></label>
                     <div class="col-md-12">
                         <input type="text" name="reason_edit" class="form-control form-control-line comments_edit"  id="reason_edit" >
                     </div>
                 </div>

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <!--<button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal" id="canceled">Cancel</button>-->
			  <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
 <script>
$(window).on('load',function(){
	
	$(".modal").on("hidden.bs.modal", function(){
       //location.reload();
    });
    $('#lparesultpopupDiv').on('shown.bs.modal', function () {
		if ($("#tbu_band").val() == 1 ) {
				if($("#tag").val()=="1st line LPA"){
					$("#secondLPA").hide();
					$("#firstLPA").show();
					if($("#mtb_result option:selected" ).text()=='MTB detected'){
						$("#quinolone").prop("disabled",true);
                        $("#slid").prop("disabled",true);				
					}
				}
                if($("#tag").val()=="2nd line LPA"){
					$("#firstLPA").hide();
					$("#secondLPA").show();
					if($("#mtb_result option:selected" ).text()=='MTB detected'){
						$(".main_rif_val").prop("disabled",true);
                        $("#inh").prop("disabled",true);				
					}
				}
                if($("#tag").val()=="1st line LPA  and for 2nd line LPA"){
					$("#firstLPA").show();
				    $("#secondLPA").show();
					if($("#mtb_result option:selected" ).text()=='MTB detected'){
						$(".main_rif_val").prop("disabled",false);
                        $("#inh").prop("disabled",false);
                        $("#quinolone").prop("disabled",false);
                        $("#slid").prop("disabled",false);						
					}
				}				
				
			} else  {
				//alert("here");
				$('#mtb_result option[value="MTB not detected"]').attr('selected','selected');
				$(".main_rif_val").prop("disabled",true);
				//$("#rif").prop("disabled", "disabled");
				$("#inh").prop("disabled",true);                
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
		//function when select is changing.	
		function displayline(){
			if ($("#tbu_band").val() == 1){ //alert("present"); alert($("#tag").val());
				if($("#tag").val()=="1st line LPA" || $("#tag").val()=="1st Line LPA"){//alert("1st line");
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
                
				if($("#tag").val()=="2nd Line LPA"||$("#tag").val()=='2nd line LPA'){  //alert("2nd line");
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
					if($("#mtb_result option:selected" ).text()=='MTB detected'){
						$(".main_rif_val").prop("disabled",true);
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
				
			} else  {
				//alert("absent");
				$('#mtb_result option[value="MTB not detected"]').attr('selected','selected');
				$("#inh").prop("disabled",true);
                $(".main_rif_val").prop("disabled",true);
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
		//alert($("#tag").val());
		var linetype=1;
		if($("#tag").val()=="1st line LPA" || $("#tag").val()=="1st Line LPA"){
			linetype=1;
		}
		else if($("#tag").val()=="2nd Line LPA" ||$("#tag").val()=='2nd line LPA'){
			linetype=2;
		}else{
			linetype=3;
		}
		//alert($("#hid_final_interpretation").val());
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

     $('#confirmDelete').on('show.bs.modal', function (e) {


     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
   });

   /* Form confirm (yes/ok) handler, submits form*/
   $('#confirm').click( function(){
     //var form = $(document).find('form#resultpopup');

     console.log( $('#cbnaat_result').serialize() );
     var data = $('#cbnaat_result').serialize();
     if($('#type_direct').val()!="" || $('#type_indirect').val()!=""){

       // $.post("{{ url('/lpa_interpretation') }}", data, function(ret){
       //   location.reload();
       // });
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

     $(document).ready(function() {

      $(".new_mtb_result").on("change", function() {
    //alert('test');
    var final_interpretation = "";
    var clinical_trail = "";
    //$('#final_interpretation1').val("");
    if($(this).val() != "")
    {
      if($(this).val()=='M.Tb. not detected'){ 

        //alert('test');

        if($('#tag').val() == '1st line LPA')
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
        else if( $('#tag').val() == '2nd line LPA' )
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

        if($('#tag').val() == '1st line LPA')
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
    

    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result :selected').text();

    }   
     

    if($(this).val() != "")
    {
      rif = $(this).val();
    }

      if( $('.katg_resi_1st').find('option:selected').text() == 'select' )
      {
        katg = "";        

      } else {

        katg = $('.katg_resi_1st').find('option:selected').text();

      }
        
        //console.log(final_interpretation);
    
    
    if($(".inh_1st_lpa").find('option:selected').text() == 'select')
    {
      var inh = "";   

    } else {

      var inh = $(".inh_1st_lpa").find('option:selected').text();

    }

    mtb_1st_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });

  $('.katg_resi_1st').on('change', function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    
      
    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result').find('option:selected').text();

    }   

    if( $('.rif_1st_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('.rif_1st_lpa').find('option:selected').text();

    }        

     
    if($(this).val() != "")
    {
      katg = $(this).val();
    }
      

      if(  $('.inh_1st_lpa').find('option:selected').text() == "select")
      {
        inh = "";
        
      } else {
                inh = $('.inh_1st_lpa').find('option:selected').text();

      }   

      mtb_1st_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });


  $(".inh_1st_lpa").on("change", function() {
    
    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    
      
    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result').find('option:selected').text();

    }   

    if( $('.rif_1st_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('.rif_1st_lpa').find('option:selected').text();

    } 


    if( $('.katg_resi_1st').find('option:selected').text() == 'select')
    {
      katg = "";

    } else {

      katg = $('.katg_resi_1st').find('option:selected').text();

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

    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result').find('option:selected').text();

    }   
     

    if($(this).val() != "")
    {
      rif = $(this).val();
    }

      if( $('.sli_rss_2nd').find('option:selected').text() == 'select' )
      {
        katg = "";        

      } else {

        katg = $('.sli_rss_2nd').find('option:selected').text();

      }
        
        //console.log(final_interpretation);
    
    
    if($(".slid_2nd_lpa").find('option:selected').text() == 'select')
    {
      var inh = "";   

    } else {

      var inh = $(".slid_2nd_lpa").find('option:selected').text();

    }


    mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

  });

  $('.sli_rss_2nd').on("change", function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";
      
    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result').find('option:selected').text();

    }   

    if( $('.quinolone_2nd_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('.quinolone_2nd_lpa').find('option:selected').text();

    }        

     
    if($(this).val() != "")
    {
      katg = $(this).val();
    }
      

      if(  $('.slid_2nd_lpa').find('option:selected').text() == "select")
      {
        inh = "";
        
      } else {
                inh = $('.slid_2nd_lpa').find('option:selected').text();

      }   

      mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);
  });

  $('.slid_2nd_lpa').on("change", function() {

    var mtb = "";
    var rif = "";
    var katg = "";
    var inh = "";

    
    if( $('.new_mtb_result').find('option:selected').text() == 'select')
    {
      mtb = "";

    } else {

      mtb = $('.new_mtb_result').find('option:selected').text();

    }   

    if( $('.quinolone_2nd_lpa').find('option:selected').text() == 'select')
    {
      rif = "";

    } else {

      rif = $('.quinolone_2nd_lpa').find('option:selected').text();

    } 


    if( $('.sli_rss_2nd').find('option:selected').text() == 'select')
    {
      katg = "";

    } else {

      katg = $('.sli_rss_2nd').find('option:selected').text();

    }     

      if($(this).val() != "")
      {
        inh = $(this).val(); 
      }  
    

      mtb_2nd_result('<?php echo csrf_token();?>', mtb, rif, katg, inh);

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
