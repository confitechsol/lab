@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Test Request</h3>

                  </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                  <p>Enrolment No: {{ str_pad($data['testrequest']->enroll_id, 10, "0", STR_PAD_LEFT) }}</p>


                                  @if($data['testrequest']->req_test_type == 1)
                                      <p>Test: {{$data['test_type']}}</p>
                                      <p>Facility Type: {{$data['test_type']}}</p>
                                      <p>State: {{$data['state']->name}}</p>
                                      <p>District: {{$data['district']->name}}</p>
                                      <p>TBU: {{$data['testrequest']->tbu}}</p>
                                      <p>Name of Facility: {{$data['testrequest']->facility_type}}</p>
                                      <p>H/O anti TB Rx for > 1 month: {{$data['testrequest']->ho_anti_tb}}</p>
                                      <p>Diagnosis of TB: {{$data['testrequest']->req_test_type}}</p>
                                      <p>Predominant Symptom: {{$data['testrequest']->predmnnt_symptoms}}</p>
                                      <p>Duration in days: {{$data['testrequest']->duration}}</p>

                                  @elseif ($data['testrequest']->req_test_type == 2)
                                      <p>Test: {{$data['test_type']}}</p>
                                      <p>Facility Type: {{$data['test_type']}}</p>
                                      <p>State: {{$data['state']->name}}</p>
                                      <p>District: {{$data['district']->name}}</p>
                                      <p>TBU: {{$data['testrequest']->tbu}}</p>
                                      <p>Name of Facility: {{$data['testrequest']->facility_type}}</p>
                                      <p>RNTCP TB Reg No x: {{$data['testrequest']->ho_anti_tb}}</p>
                                      <p>Regimen: {{$data['testrequest']->regimen}}</p>
                                      <p>Reason: {{$data['testrequest']->reason}}</p>

                                  @elseif ($data['testrequest']->req_test_type == 3)
                                      <p>Test: {{$data['test_type']}}</p>
                                      <p>Facility Type: {{$data['test_type']}}</p>
                                      <p>State: {{$data['state']->name}}</p>
                                      <p>District: {{$data['district']->name}}</p>
                                      <p>TBU: {{$data['testrequest']->tbu}}</p>

                                  @else
                                      <p>Test: {{$data['test_type']}}</p>
                                      <p>Facility Type: {{$data['test_type']}}</p>
                                      <p>State: {{$data['state']->name}}</p>
                                      <p>District: {{$data['district']->name}}</p>
                                      <p>TBU: {{$data['testrequest']->tbu}}</p>

                                  @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
        </div>
@endsection
