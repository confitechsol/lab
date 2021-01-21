
        <div class="page-wrapper">
            <div class="container-fluid">

              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">


                  </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">

                                        <tbody>

                                          @foreach ($barcodes as $key=> $barcode)
                                            <tr>
                                              <td>{{ $barcode->codeA }}</td>
                                              <td>{{ $barcode->codeB }}</td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
