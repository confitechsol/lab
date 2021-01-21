{{-- Change by Vidhi --}}
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

</style>
<div class="container">

    <br/>
    <button onclick="myFunction()" style="padding: 5px 15px;
    border-radius: 4px;
    background: #009efb;
    color: #ffffff;
		cursor:pointer;
    margin-right: 3px;">PRINT
    </button>


    <h2 align="center" style="font-family:Lucida Console;">TB Laboratory Register</h2>


    <h4 align="center"><u>Sample Registrar Details</u></h4>


    <a style="padding: 5px 15px;
		border-radius: 4px;
		background: #009efb;
		color: #ffffff;
		margin-right: 3px; cursor:pointer;" onclick="fnExcelReport();">Excel for Sample Registrar Details</a>
    <br> <br>

    <table id="result1" class="tg">


        <tr>
            <th class="tg-yw4l" rowspan="3"><span
                        style="    writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Lab Serial No.</span>
            </th>
            <th class="tg-yw4l" rowspan="3">NIKSHAY ID</th>
            <!-- <th class="tg-yw4l" rowspan="3">Date of colllection of first specimen</th> -->
            <th class="tg-yw4l" rowspan="3">Patient's full name (Address/contact details)</th>
            <th class="tg-yw4l" rowspan="3">Age</th>
            <th class="tg-yw4l" rowspan="3"><span
                        style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Gender (M/F/TG)</span>
            </th>
            <th class="tg-yw4l" rowspan="3">Key Population</th>
            <!-- <th class="tg-yw4l" rowspan="3">Complete Address</th> -->
            <th class="tg-yw4l" rowspan="3">Name of referring health facility</th>
            <th class="tg-yw4l" colspan="5">Reasons for Testing</th>
            <!-- <th class="tg-yw4l" colspan="3">Date</th> -->
            <th class="tg-yw4l" colspan="3">Date</th>
            <th class="tg-yw4l" rowspan="3">Type(Sputum/other-specify)</th>
            <th class="tg-yw4l" rowspan="3">Specimen Condition ( M/B/S/C)</th>
            <th class="tg-yw4l" rowspan="3">C&DST Lab Microscopy Result</th>



            <!-- =============== -->
            <!-- Result Headings -->
            <!-- =============== -->

            <th class="tg-031e" colspan="10">Rapid DST Results</th>
            <th class="tg-031e" colspan="4">Culture Results</th>
            <th class="tg-031e" colspan="24">Reporting of Results</th>

            <!-- ===================== -->
            <!-- Result Headings - END -->
            <!-- ===================== -->

        </tr>
        <tr>
            <td class="tg-yw4l" colspan="3">Diagnosis/DST</td>
            <td class="tg-yw4l" colspan="2">Follow-up</td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen Collection</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen sent to lab</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Specimen receipt at laboratory</span>
            </td>
            <!-- <td class="tg-yw4l"></td>
            <td class="tg-yw4l"></td> -->


            <!-- =============== -->
            <!-- Result Headings -->
            <!-- =============== -->

            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Test performed (FL-LPA/SL-LPA/CBNAAT)</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Valid* (Y/N)</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">TB + (Y/N)</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">RIF</span>
            </td>
            {{-- <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (InhA)</span> --}}
           <!-- </td> -->
            <!-- <span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (KatG)</span> -->
            {{-- </td> --}}
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">FQ</span>
            </td>
            {{-- <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">SLID</span></td> --}}

            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Type (LJ/LC)</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Results</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt </span>
            </td>

            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Rifampicin</span>
            </td>
            <td class="tg-031e" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.1</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.4</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Streptomycin</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethambutol</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Pyrazinamide</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Kanamycin</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Capreomycin</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Amicacin</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Levofloxacin</span>
            </td>

            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (0.25)</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (1.0)</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethionamide</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">PAS</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Linezolid</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clofazimine</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Bedaquiline</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Delamanid</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Azythromycin</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clarithromycin</span>
            </td>
            <!-- <td class="tg-yw4l" rowspan="2"><span
                        style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;"></span></td> -->
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting culture result</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting DST result</span>
            </td>
            <td class="tg-yw4l" rowspan="2"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Remarks</span>
            </td>


            <!-- ===================== -->
            <!-- Result Headings - END -->
            <!-- ===================== -->


        </tr>
        <tr>
            <td class="tg-yw4l">New PT</td>
            <td class="tg-yw4l">Presumptive MDR TB</td>
            <td class="tg-yw4l">Predominant symptom and duration</td>
            <td class="tg-yw4l">PMDT TB No</td>
            <td class="tg-yw4l">Month of FU</td>

            <td class="tg-yw4l"></td>
            <td class="tg-yw4l"></td>
            <td class="tg-yw4l"></td>
        </tr>

        <?php

       $final_data = new Illuminate\Support\Collection();
       
        // Map Result with Lab Details ============================
		foreach( $data['result'] as $result ){		  
          foreach( $data['lab'] as $lab ){
           
                if( $lab->id === $result->sampleId ){
                    $final_data->push((object)[
                        'lab' => $lab,
                        'result' => $result,
                    ]);
                    break;
                }
            }
        }

     // dd( $final_data );

        ?>


        @foreach( $final_data as $final_datum )
            @php( $lab = $final_datum->lab )
            @php( $result = $final_datum->result )
            


            <tr>
                <td class="tg-yw4l">{{$lab->label}}</td>
                <td class="tg-yw4l"><?php echo $lab->nikshay; ?></td>
            <!-- <td class="tg-yw4l">{{$lab->receive_date}}</td> -->
                <td class="tg-yw4l">{{$lab->fullname}}<br>
                    @if(!empty($lab->house_no))    {{$lab->house_no}}
                    , @endif @if(!empty($lab->district))    {{$lab->district}}
                    ,@endif @if(!empty($lab->state)) {{$lab->state}},@endif @if(!empty($lab->pincode)){{$lab->pincode}}
                    , @endif<br>
                    {{$lab->mobile}}
                </td>
                <td class="tg-yw4l">{{$lab->age}}</td>
                <td class="tg-yw4l">{{$lab->gender}}</td>
                <td class="tg-yw4l">{{$lab->key_population}}</td>
            <!-- <td class="tg-yw4l">{{$lab->house_no}},{{$lab->district}},{{$lab->state}},{{$lab->pincode}}</td> -->
                <td class="tg-yw4l"><?php echo $lab->facility_name.', '.$lab->facility_district; ?></td>
                <td class="tg-yw4l">
                    
                    <?php echo $lab->newpt; ?>
                    
                </td>
                <td class="tg-yw4l"><?php echo $lab->mdrtb; ?></td>
                <td class="tg-yw4l"> <?php echo $lab->psymptom; ?><br>
                                    <?php echo $lab->duration; ?>
                   
                </td>
            <!-- <td class="tg-yw4l">{{$lab->nikshay_id}}</td> -->
                <td class="tg-yw4l">{{$lab->pmdt_tb_no}}</td>
                <td class="tg-yw4l">{{$lab->treatment}}</td>
                <td class="tg-yw4l">{{$lab->collection_date}}</td>
                <td class="tg-yw4l">{{$lab->request_date}}</td>
                <!-- <td class="tg-yw4l"></td> -->
                <td class="tg-yw4l">{{$lab->receive_date}}</td>
                <td class="tg-yw4l">{{$lab->sample_type}}</td>
                <td class="tg-yw4l">{{$lab->sample_quality}}</td>
                <td class="tg-yw4l">{{$lab->mresult}}</td>


                <td class="tg-031e">
                    @if($result->c_id)
                        CBNAAT:{{$result->MTB}}, {{$result->RIF}}
                    @elseif($result->flpa_id && $result->slpa_id)
                       
                    @elseif($result->flpa_id)
                        FLLPA:{{$result->lpaResult}}
                    @elseif($result->slpa_id)
                        SLLPA:{{$result->lpaResult}}    
                    @elseif($result->flpa_id && $result->slpa_id && $result->c_id)
                        CBNAAT:{{$result->MTB}}, {{$result->RIF}}<br>
                        @if($result->lf.tag == '1st line LPA')
                        FLLPA:{{$result->lpaResult}}
                        @endif
                        <br>
                        @if($result->lf.tag == '2nd line LPA')
                        SLLPA:{{$result->lpaResult}}
                        @endif
                    @endif
                </td>
                <td class="tg-031e">
                    @if($result->service_id=='4' || $result->service_id=='8')
                        {{$result->receive_date}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if($result->h_result=='Valid')
                        Y
                    @else
                        N
                    @endif
                </td>

                <td class="tg-031e">
                    @if($result->MTB == 'MTB Detected' || $result->mtb_result == 'MTB detected')
                        Y
                    @else 
                        N   
                    @endif
                </td>
                <td class="tg-031e"> 
                    @if($result->c_id)
                    {{$result->RIF}}
                    @elseif($result->lf_id)
                    {{$result->lpaRIF}}
                    @endif
                </td>

                <td class="tg-031e">{{$result->INH}}</td>
                <td class="tg-031e">{{$result->quinolone}}</td>
           
                <td class="tg-031e">
                    @if($result->ld_id)
                        LJ
                    @elseif($result->lfmf_id)
                        LC
                    @elseif($result->ld_id && $result->lfmf_id)
                        LC, LJ
                    @endif
                </td>

                <td class="tg-031e">
                    @if($result->lfmf_result)
                       LC:{{$result->lfmf_result}}
                    @endif
                    @if($result->ld_result)
                        LJ:{{$result->ld_result}}
                    @endif
                </td>

                <td class="tg-031e">
                    @if($result->service_id=='16')
                        {{$result->receive_date}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('R',$result->drug_name))
                        {{$result->lcdrugresult[array_search('R',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('R',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('R',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('H(inh_A)',$result->drug_name))
                        {{$result->lcdrugresult[array_search('H(inh_A)',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('H(inh A)',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('H(inh_A)',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('H(Kat_G)',$result->drug_name))
                        {{$result->lcdrugresult[array_search('H(Kat_G)',$result->drug_name)]}}
                    @endif
                        @if(in_array('H(Kat_G)',$result->drug_name_lj))
                            {{$result->ljdrugresult[array_search('H(Kat_G)',$result->drug_name_lj)]}}
                        @endif
                    <br>
                    @if(in_array('H(Kat_G)',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('H(Kat_G)',$result->drug_name_lj)]}}
                    @endif
                    @if(in_array('H(Kat G)',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('H(Kat G)',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('S',$result->drug_name))
                        {{$result->lcdrugresult[array_search('S',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('S',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('S',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('E',$result->drug_name))
                        {{$result->lcdrugresult[array_search('E',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('E',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('E',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Z',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Z',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Z',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Z',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Km',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Km',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Km',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Km',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Cm',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Cm',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Cm',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Cm',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Am',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Am',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Am',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Am',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Lfx',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Lfx',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Lfx',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Lfx',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Mfx(0_5)', $result->drug_name))
                        {{$result->lcdrugresult[array_search('Mfx(0_5)',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Mfx(0.5)',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Mfx(0_5)',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Mfx(2)',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Mfx(2)',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Mfx(2)',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Mfx(2)',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Eto',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Eto',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Eto',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Eto',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('PAS',$result->drug_name))
                        {{$result->lcdrugresult[array_search('PAS',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('PAS',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('PAS',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Lzd',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Lzd',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Lzd',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Lzd',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Cfz',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Cfz',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Cfz',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Cfz',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Others',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Others',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Others',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Others',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Others',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Others',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Others',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Others',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Azi',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Azi',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Azi',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Azi',$result->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Clr',$result->drug_name))
                        {{$result->lcdrugresult[array_search('Clr',$result->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Clr',$result->drug_name_lj))
                        {{$result->ljdrugresult[array_search('Clr',$result->drug_name_lj)]}}
                    @endif
                </td>

                <td class="tg-yw4l">
                    {{-- @if(in_array(17,$sendNikshay->service) || in_array(20,$sendNikshay->service))
                        {{$sendNikshay->submit}}
                    @endif --}}
                </td>
                <td class="tg-yw4l">
                    {{-- @if($sendNikshay->service == 4)
                    {{$sendNikshay->submit}}
                    @endif

                    @if($sendNikshay->service == 15)
                    {{$sendNikshay->submit}}
                    @endif

                    @if($sendNikshay->service == 21)
                    {{$sendNikshay->submit}}
                    @endif

                    @if($sendNikshay->service == 22)
                    {{$sendNikshay->submit}}
                    @endif --}}
                </td>
            <td class="tg-yw4l">{{$lab->rejection}}</td>

<!--PRADIP-->


            </tr>

        @endforeach



    </table>


    <br/><br/>


    {{--<h4 align="center"><u>Sample DST Details</u></h4>--}}
    {{--<a style="padding: 5px 15px;--}}
		{{--border-radius: 4px;--}}
		{{--background: #009efb;--}}
		{{--color: #ffffff;--}}
		{{--margin-right: 3px; cursor:pointer;" onclick="fnExcelReport1();">Excel for Sample DST Details</a><br>--}}

    {{--<br>--}}


    {{--<table id="result2" class="tg">--}}
        {{--<tr>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Test performed (FL-LPA/SL-LPA/CBNAAT)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Valid* (Y/N)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">TB + (Y/N)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">RIF </span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (InhA)</span>--}}
            
            {{--<span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (KatG)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">FQ</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">SLI class resi (ED/RD/ND)</span></td> -->--}}

            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Type (LJ/LC)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Results</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt </span>--}}
            {{--</td>--}}

            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Rifampicin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.1</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.4</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Streptomycin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethambutol</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Pyrazinamide</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Kanamycin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Capreomycin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Amicacin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Levofloxacin</span>--}}
            {{--</td>--}}

            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (0.25)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (1.0)</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethionamide</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">PAS</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Linezolid</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clofazimine</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Bedaquiline</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Delamanid</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Azythromycin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clarithromycin</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span--}}
                        {{--style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;"></span></td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting culture result</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting DST result</span>--}}
            {{--</td>--}}
            {{--<td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Remarks</span>--}}
            {{--</td>--}}
        {{--</tr>--}}
        {{--@foreach($data['result'] as $key1=> $result)--}}
            {{--<tr>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if($result->c_id)--}}
                        {{--CBNAAT--}}
                    {{--@elseif($result->lf_id)--}}
                        {{--LPA--}}
                    {{--@else--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if($result->service_id=='4' || $result->service_id=='8')--}}
                        {{--{{$result->receive_date}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if($result->mtb_result=='MTB detected' && $result->mtb=='MTB Detected')--}}
                        {{--Y--}}
                    {{--@else--}}
                        {{--N--}}
                    {{--@endif--}}
                {{--</td>--}}
            {{--<!-- <td class="tg-031e">{{$result->ld_id?$result->ld_result:$result->lfmf_result}}</td> -->--}}
                {{--<td class="tg-031e"></td>--}}
                {{--<td class="tg-031e">{{$result->rif}}</td>--}}
                {{--<td class="tg-031e"></td>--}}
                {{--<td class="tg-031e"></td>--}}
                {{--<td class="tg-031e">{{$result->quinolone}}</td>--}}
            {{--<!-- <td class="tg-031e">{{$result->slid}}</td> -->--}}
            {{--<!-- <td class="tg-031e">--}}
      {{--@if($result->c_id)--}}
                {{--{{$result->result_MTB}}--}}
            {{--@elseif($result->lf_id)--}}
                {{--{{$result->mtb_result}}--}}
            {{--@else--}}
            {{--@endif--}}
                    {{--</td> -->--}}

            {{--<!-- <td class="tg-031e">--}}
      {{--@if($result->c_id)--}}
                {{--{{$result->result_RIF}}--}}
            {{--@elseif($result->lf_id)--}}
                {{--{{$result->rif}}--}}
            {{--@else--}}
            {{--@endif--}}
                    {{--</td> -->--}}
                {{--<td class="tg-031e">--}}
                    {{--@if($result->ld_id)--}}
                        {{--LJ--}}
                    {{--@endif--}}
                    {{--@if($result->lfmf_id)--}}
                        {{--LC--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if($result->lfmf_result)--}}
                        {{--{{$result->lfmf_result}}--}}
                    {{--@endif--}}
                    {{--@if($result->ld_result)--}}
                        {{--{{$result->ld_result}}--}}
                    {{--@endif--}}
                {{--</td>--}}

                {{--<td class="tg-031e">--}}
                    {{--@if($result->service_id=='16')--}}
                        {{--{{$result->receive_date}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if(in_array('R',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('R',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('R',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('R',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if(in_array('I0.1',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('I0.1',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('I0.1',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('I0.1',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-031e">--}}
                    {{--@if(in_array('I0.4',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('I0.4',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('I0.4',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('I0.4',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('S',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('S',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('S',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('S',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('E',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('E',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('E',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('E',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Py',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Py',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Py',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Py',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Km',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Km',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Km',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Km',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Cm',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Cm',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Cm',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Cm',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Am',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Am',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Am',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Am',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Lfx',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Lfx',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Lfx',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Lfx',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Mfx(0.5)',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Mfx(0.5)',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Mfx(0.5)',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Mfx(0.5)',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Mfx(2)',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Mfx(2)',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Mfx(2)',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Mfx(2)',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Eto',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Eto',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Eto',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Eto',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('PAS',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('PAS',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('PAS',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('PAS',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Lzd',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Lzd',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Lzd',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Lzd',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Cfz',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Cfz',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Cfz',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Cfz',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Others',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Others',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Others',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Others',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Others',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Others',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Others',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Others',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Azi',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Azi',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Azi',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Azi',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l">--}}
                    {{--@if(in_array('Cla',$result->drug_name))--}}
                        {{--{{$result->lcdrugresult[array_search('Cla',$result->drug_name)]}}--}}
                    {{--@endif--}}
                    {{--<br>--}}
                    {{--@if(in_array('Cla',$result->drug_name_lj))--}}
                        {{--{{$result->ljdrugresult[array_search('Cla',$result->drug_name_lj)]}}--}}
                    {{--@endif--}}
                {{--</td>--}}
                {{--<td class="tg-yw4l"></td>--}}
                {{--<td class="tg-yw4l">{{$result->lfmf_date}}</td>--}}
                {{--<td class="tg-yw4l">{{$result->ld_date}}</td>--}}
                {{--<td class="tg-yw4l"></td>--}}

            {{--</tr>--}}
        {{--@endforeach--}}
    {{--</table>--}}

</div>
<style>
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
    }
</style>
<style type="text/css" media="print">
    @page {
        size: landscape;
    }
</style>

<script>
    function myFunction() {
        window.print();
    }
</script>
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
            var data_uri = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
            var today = new Date();
            var day = today.getDate();
            day = day < 10 ? '0' + day : day;
            var time = day + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
            return saveContent( data_uri, 'LIMS_<?php echo $lab_details->name?>_<?php echo $lab_details->city?>_Annexure15L_' + time + '.xls' );

        return (sa);
    }
</script>

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


    function fnExcelReport1() {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('result2'); // id of table

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
            // sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Wlt.xls");
        }
        else
            //other browser not tested on IE 11
            // sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            var data_uri = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
            var today = new Date();
            var day = today.getDate();
            day = day < 10 ? '0' + day : day;
            var time = day + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
            saveContent( data_uri, 'LIMS_<?php echo $lab_details->name?>_<?php echo $lab_details->city?>' + time + '.xlsx' );


        return (sa);
    }

    function saveContent(uri, fileName){
        var link = document.createElement('a');
        link.download = fileName;
        link.href = uri;
        link.click();
    }

</script>
