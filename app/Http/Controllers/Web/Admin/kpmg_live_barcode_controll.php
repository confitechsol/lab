<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Barcodes;
use App\Model\Config;
use App\Model\PrintLog;
use \Milon\Barcode\DNS1D;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = Barcodes::distinct()->get(['year']);

        return view('admin.barcodes.list',compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $year = Barcodes::distinct()->get(['year'])->last();
        $last = Barcodes::orderBy('id','DESC')->first();
        $_next = $request->_next;
        $lab_name = Config::where('status',1)->select('lab_name')->first();

        $barcode_offset = Config::where('status',1)->select('barcode_offset')->first();

        $offset=substr($barcode_offset->barcode_offset,-5);
        $offset=$offset+1;

        if(!$year){
          $year = date("Y");
          $startIndex = $offset;
        }else{
          if($_next == 0){
            $year = $year->year + 1;
            $startIndex = 1;
          }else{
            $year = $year->year;
            $startIndex = $last->code +1;
          }
        }

 // echo substr($barcode_offset->barcode_offset,2,3);


        for($i = $startIndex;$i <= $startIndex + 21; $i++){


          $strA = substr($year,-2).substr($barcode_offset->barcode_offset,2,3).str_pad($i, 5, "0", STR_PAD_LEFT)."A";

          $strB = substr($year,-2).substr($barcode_offset->barcode_offset,2,3).str_pad($i, 5, "0", STR_PAD_LEFT)."B";
          // echo $strA;
          // echo $strB;
          // die;
          // $strA = substr($year,-2).str_pad($i, 5, "0", STR_PAD_LEFT)."A";
          // $strB = substr($year,-2).str_pad($i, 5, "0", STR_PAD_LEFT)."B";


          Barcodes::create([
            'year'=>$year,
            'code'=>$i,
            'codeA'=>$strA,
            'codeB'=>$strB
          ]);
        }
        return response()->json([
            'count' => $i,

            'year' => $year
        ]);
        //return redirect('/barcodes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printBarcodes(Request $request)
    {
// dd($request->all());
 $year = $request->year;
 $seqFrm = $request->seqFrm;
 $seqTo = $request->seqTo;

    $query= PrintLog::create([
        'r_year' => $year ,
        'r_from' => $seqFrm,
        'r_to' => $seqTo,
        'created_by' => $request->user()->id
      ]);

      // echo "<pre>"; print_r($query); die;

      $barcodes = Barcodes::whereBetween('code',[$seqFrm, $seqTo])->where('year',$year)
      ->get(['codeA','codeB']);

if(count($barcodes) > 0){
      echo "<style>
      @media print {
     @page {
          size: 102.5mm 25mm;
          #size: 102.5mm 25mm;
        }
      }
      body {
         margin-top: -25px;
         margin-left:0px;
        background-color:#F2F2DA;
      }
      .page-break {
          page-break-after: always;
      }
          </style>";?>
    <!--       <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->

  <!-- <script type="text/javascript">
   function PrintDiv() {
      var divToPrint = document.getElementById('divToPrint');
      var popupWin = window.open('', '_blank', 'width=300,height=300');
      popupWin.document.open();
      popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
       popupWin.document.close();
           }
</script> -->



<div id="divToPrint">
    <?php  foreach ($barcodes as $key => $value) {    #echo '<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('22', 'MSI+')}}" alt="barcode" />'

        // echo DNS1D::getBarcodeSVG($value->codeA, "C93",0.6,20);//C93
        // echo "&emsp;&emsp;&emsp;&nbsp;&nbsp;".DNS1D::getBarcodeSVG($value->codeA, "C93",0.6,20);//C93
        // echo "<br/>".strtoupper($value->codeA);
        // echo "&emsp;&emsp;&emsp;&nbsp;&nbsp;".strtoupper($value->codeA);
        // echo "<br/><br/>".DNS1D::getBarcodeSVG($value->codeB, "C93",0.6,20);//C93
        // echo "&emsp;&emsp;&emsp;&nbsp;&nbsp;".DNS1D::getBarcodeSVG($value->codeB, "C93",0.6,20);//C93
        // echo "<br/>".strtoupper($value->codeB);
        // echo "&emsp;&emsp;&emsp;&nbsp;&nbsp;".strtoupper($value->codeB);
        // echo "<div class='page-break'></div>";
echo "<br>";



                $barcode_valueA="";
                $barcode_valueB="";


               $barcode_valueA = substr($value->codeA,5);

      // echo $barcode_valueA; die();


                $barcode_valueB =substr($value->codeB,5);
//barcodegeneration val
                $codeAval=strtoupper($barcode_valueA);
                $codeBval=strtoupper($barcode_valueB);
//barcode text generation val

              $codeAval_final=strtoupper($value->codeA);
              $codeBval_final=strtoupper($value->codeB);
                // echo $codeBval_final; die;

                //dd($barcode_valueA);

                ?>


                <table id="barcode_generation_tb" style="margin-top:0px;">
                  <tr>
                  <td class="margin-td-val"><?php echo DNS1D::getBarcodeSVG($codeAval, "C93",0.78,25);//C93 ?></td>
                  <td class="margin-td-val" style="margin-left:20px; display: inline-block;"><?php echo DNS1D::getBarcodeSVG($codeAval, "C93",0.78,25);//C93 ?></td>
                  <td class="margin-td-val" style="margin-left:20px; display: inline-block;"><?php echo DNS1D::getBarcodeSVG($codeBval, "C93",0.78,25);//"C93",1,15 ?></td>
                  <td class="margin-td-val" style="margin-left:20px; display: inline-block;"><?php echo DNS1D::getBarcodeSVG($codeBval, "C93",0.78,25);//"C93",1,15 ?></td>
                  </tr>
                  <tr>
                    <td class="margin-td-val" style="font-size:9px;"><?php echo $codeAval_final; ?></td>
                    <td class="margin-td-val" style="margin-left:20px; display: inline-block; font-size:9px;"><?php echo $codeAval_final; ?></td>
                    <td class="margin-td-val" style="margin-left:40px; display: inline-block; font-size:9px;"><?php echo $codeBval_final; ?></td>
                    <td class="margin-td-val" style="margin-left:40px; display: inline-block; font-size:9px;"><?php echo $codeBval_final; ?></td>
                  </tr>
                </table>


                <?php }
                ?>

                </div>
         <!--         <input type="button" value="print" onclick="PrintDiv();" /> -->
                <?php
      }else{
          echo "<style>
        body{
          background-color:#F2F2DA;
        }

          </style>";
          echo "<h3>Sorry! Unable to find Barcode generation list for this year.</h3>";
        }



            }
        }
