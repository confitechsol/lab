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
            <th class="tg-yw4l" rowspan="3">Patient's full name is full (Address/contact details)</th>
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
        @foreach ($data['lab'] as $key=> $lab)

            <tr>
                <td class="tg-yw4l">{{$lab->sample_label}}</td>
                <td class="tg-yw4l"><?php echo $lab->nikshay; ?></td>
            <!-- <td class="tg-yw4l">{{$lab->receive_date}}</td> -->
                <td class="tg-yw4l">{{$lab->name}}<br>
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
                <td class="tg-yw4l"><?php echo $lab->facility_name; ?></td>
                <td class="tg-yw4l"><?php echo $lab->regimenname; ?></td>
                <td class="tg-yw4l"><?php echo $lab->mdrtb; ?></td>
                <td class="tg-yw4l"><?php echo $lab->duration; ?><br>
                    <?php echo $lab->psymptom; ?>
                </td>
            <!-- <td class="tg-yw4l">{{$lab->nikshay_id}}</td> -->
                <td class="tg-yw4l">{{$lab->pmdt_tb_no}}</td>
                <td class="tg-yw4l">{{$lab->treatment}}</td>
                <td class="tg-yw4l">{{$lab->collection_date}}</td>
                <td class="tg-yw4l">{{$lab->receive_date}}</td>
                <td class="tg-yw4l"></td>
            <!-- <td class="tg-yw4l">{{$lab->regr_date}}</td> -->
                <td class="tg-yw4l">{{$lab->sample_type}}</td>
                <td class="tg-yw4l">{{$lab->sample_quality}}</td>
                <td class="tg-yw4l">{{$lab->mresult}}</td>
            </tr>
        @endforeach


    </table>


    <br/><br/>


    <h4 align="center"><u>Sample DST Details</u></h4>
    <a style="padding: 5px 15px;
		border-radius: 4px;
		background: #009efb;
		color: #ffffff;
		margin-right: 3px; cursor:pointer;" onclick="fnExcelReport1();">Excel for Sample DST Details</a><br>

    <br>


    <table id="result2" class="tg">
        <tr>
            <th class="tg-031e" colspan="10">Rapid DST Results</th>
            <th class="tg-031e" colspan="4">Culture Results</th>
            <th class="tg-031e" colspan="24">Reporting of Results</th>
        </tr>
        <tr>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Test performed (FL-LPA/SL-LPA/CBNAAT)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Valid* (Y/N)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">TB + (Y/N)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">RIF Resi (ND/D)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (InhA) (Present/Absent)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">INH (KatG) (Present/Absent)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">FQ class resistance (ND/D)</span>
            </td>
            <!-- <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">SLI class resi (ED/RD/ND)</span></td> -->

            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Type (LJ/LC)</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Results</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of receipt </span>
            </td>

            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Rifampicin</span>
            </td>
            <td class="tg-031e"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.1</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Isoniazid 0.4</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Streptomycin</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethambutol</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Pyrazinamide</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Kanamycin</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Capreomycin</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Amicacin</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Levofloxacin</span>
            </td>

            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (0.5)</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Maxifloxacin (2.0)</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Ethionamide</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">PAS</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Linezolid</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clofazimine</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Bedaquiline</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Delamanid</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Azythromycin</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Clarithromycin</span>
            </td>
            <td class="tg-yw4l"><span
                        style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;"></span></td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting culture result</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Date of reporting DST result</span>
            </td>
            <td class="tg-yw4l"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Renarks</span>
            </td>
        </tr>
        @foreach($data['result'] as $key1=> $data1)
            <tr>
                <td class="tg-031e">
                    @if($data1->c_id)
                        CBNAAT
                    @elseif($data1->lf_id)
                        LPA
                    @else
                    @endif
                </td>
                <td class="tg-031e">
                    @if($data1->service_id=='4' || $data1->service_id=='8')
                        {{$data1->receive_date}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if($data1->mtb_result=='MTB detected' && $data1->mtb=='MTB Detected')
                        Y
                    @else
                        N
                    @endif
                </td>
            <!-- <td class="tg-031e">{{$data1->ld_id?$data1->ld_result:$data1->lfmf_result}}</td> -->
                <td class="tg-031e"></td>
                <td class="tg-031e">{{$data1->rif}}</td>
                <td class="tg-031e"></td>
                <td class="tg-031e"></td>
                <td class="tg-031e">{{$data1->quinolone}}</td>
            <!-- <td class="tg-031e">{{$data1->slid}}</td> -->
            <!-- <td class="tg-031e">
      @if($data1->c_id)
                {{$data1->result_MTB}}
            @elseif($data1->lf_id)
                {{$data1->mtb_result}}
            @else
            @endif
                    </td> -->

            <!-- <td class="tg-031e">
      @if($data1->c_id)
                {{$data1->result_RIF}}
            @elseif($data1->lf_id)
                {{$data1->rif}}
            @else
            @endif
                    </td> -->
                <td class="tg-031e">
                    @if($data1->ld_id)
                        LJ
                    @endif
                    @if($data1->lfmf_id)
                        LC
                    @endif
                </td>
                <td class="tg-031e">
                    @if($data1->lfmf_result)
                        {{$data1->lfmf_result}}
                    @endif
                    @if($data1->ld_result)
                        {{$data1->ld_result}}
                    @endif
                </td>

                <td class="tg-031e">
                    @if($data1->service_id=='16')
                        {{$data1->receive_date}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('R',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('R',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('R',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('R',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('I0.1',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('I0.1',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('I0.1',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('I0.1',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-031e">
                    @if(in_array('I0.4',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('I0.4',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('I0.4',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('I0.4',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('S',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('S',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('S',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('S',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('E',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('E',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('E',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('E',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Py',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Py',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Py',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Py',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Km',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Km',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Km',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Km',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Cm',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Cm',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Cm',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Cm',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Am',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Am',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Am',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Am',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Lfx',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Lfx',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Lfx',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Lfx',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Mfx(0.5)',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Mfx(0.5)',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Mfx(0.5)',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Mfx(0.5)',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Mfx(2)',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Mfx(2)',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Mfx(2)',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Mfx(2)',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Eto',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Eto',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Eto',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Eto',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('PAS',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('PAS',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('PAS',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('PAS',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Lzd',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Lzd',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Lzd',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Lzd',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Cfz',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Cfz',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Cfz',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Cfz',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Others',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Others',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Others',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Others',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Others',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Others',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Others',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Others',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Azi',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Azi',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Azi',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Azi',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l">
                    @if(in_array('Cla',$data1->drug_name))
                        {{$data1->lcdrugresult[array_search('Cla',$data1->drug_name)]}}
                    @endif
                    <br>
                    @if(in_array('Cla',$data1->drug_name_lj))
                        {{$data1->ljdrugresult[array_search('Cla',$data1->drug_name_lj)]}}
                    @endif
                </td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l">{{$data1->lfmf_date}}</td>
                <td class="tg-yw4l">{{$data1->ld_date}}</td>
                <td class="tg-yw4l"></td>

            </tr>
        @endforeach
    </table>

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
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

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
            sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Wlt.xls");
        }
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }
</script>
