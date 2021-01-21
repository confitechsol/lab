<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Barcodes;
use App\Model\Config;
use App\Model\Letter;
use App\Model\PrintLog;
use \Milon\Barcode\DNS1D;
 use PDF;
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


    $bar_int1 = Letter::where('year',$year)->select('Bar_Yr_Int1')->get();
    $bar_int2 = Letter::where('year',$year)->select('Bar_Yr_Int2')->get();

    $bar_char1 = Letter::where('year',$year)->select('Bar_Yr_Char1')->get();
    $bar_char2 = Letter::where('year',$year)->select('Bar_Yr_Char2')->get();
// dd($bar_int2);

 $Bar_Yr_Int1=$bar_int1[0]['original']['Bar_Yr_Int1'];
 $Bar_Yr_Int2=$bar_int2[0]['original']['Bar_Yr_Int2'];

 $Bar_Yr_Char1=$bar_char1[0]['original']['Bar_Yr_Char1'];
 $Bar_Yr_Char2=$bar_char2[0]['original']['Bar_Yr_Char2'];

 // echo substr($barcode_offset->barcode_offset,2,3);


        for($i = $startIndex;$i <= $startIndex + 21; $i++){


          $strA = substr($year,-2).substr($barcode_offset->barcode_offset,2,3).str_pad($i, 5, "0", STR_PAD_LEFT)."A";
          $strB = substr($year,-2).substr($barcode_offset->barcode_offset,2,3).str_pad($i, 5, "0", STR_PAD_LEFT)."B";
          // echo $strA;
          // echo $strB;
          // die;
          // $strA = substr($year,-2).str_pad($i, 5, "0", STR_PAD_LEFT)."A";
          // $strB = substr($year,-2).str_pad($i, 5, "0", STR_PAD_LEFT)."B";
$strA2=str_pad($i, 5, "0", STR_PAD_LEFT).$Bar_Yr_Int1;
$strB2=str_pad($i, 5, "0", STR_PAD_LEFT).$Bar_Yr_Int2;
// dd($strA2);
          Barcodes::create([
            'year'=>$year,
            'code'=>$i,
            'codeA'=>$strA,
            'codeB'=>$strB,
            'barcodeA'=>$strA2,
            'barcodeB'=>$strB2

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
 $set_a = $request->inlineRadioOptions;
 //dd( $set_a );
 $barcodeArray=array();
  $data=[];
    $query= PrintLog::create([
        'r_year' => $year ,
        'r_from' => $seqFrm,
        'r_to' => $seqTo,
        'created_by' => $request->user()->id
      ]);

      // echo "<pre>"; print_r($query); die;
      if($set_a == 1){
        $barcodes = Barcodes::whereBetween('code',[$seqFrm, $seqTo])->where('year',$year)
        ->get(['barcodeA','barcodeB','codeA','codeB']);
      }else{
         $barcodes = Barcodes::whereBetween('code',[$seqFrm, $seqTo])->where('year',$year)
        ->get(['barcodeA','codeA']);
      }

    // dd($barcodes);
    if(count($barcodes) > 0){
      foreach ($barcodes as $key => $value) { 
                $codeAval_final="";
                $codeBval_final="";
                // $year=substr($value->codeA,0,2);

                if($set_a == 1){
                  $codeAval_final=$value->barcodeA;
                  $codeBval_final=$value->barcodeB;
                  $codeA=$value->codeA;
                  $codeB=$value->codeB;

                  $barcodeArray[]=array
                (
                  "barcodeA_val"=>$codeAval_final,
                  "barcodeB_val"=>$codeBval_final,
                  "codeA"=>$codeA,
                  "codeB"=>$codeB
                );


                }else{
                  $codeAval_final=$value->barcodeA;
                 // $codeBval_final=$value->barcodeB;
                  $codeA=$value->codeA;
                 // $codeB=$value->codeB;

                  $barcodeArray[]=array
                (
                  "barcodeA_val"=>$codeAval_final,
                  //"barcodeB_val"=>$codeBval_final,
                  "codeA"=>$codeA,
                  //"codeB"=>$codeB
                );

                } 
  }
//dd($barcodeArray);
$data['barcode_arr']=$barcodeArray;
$data['year']=$year;
$data['seqFrm']=$seqFrm;
$data['seqTo']=$seqTo;
$data['set_a']=$set_a;
// dd($data);
        return view('admin.barcodes.barcode_pdf', compact('data'));
      }else{
          echo "<style>
        body{
          background-color:#F2F2DA;
        }

          </style>";
          echo "<h3>Sorry! Unable to find Barcode generation list for this year.</h3>";
        }
}






public function newprintBarcodes($pdf_param,$year,$seqFrm,$seqTo)
{
// dd($request->all());
$barcodeArray=array();
$data=[];

  // echo "<pre>"; print_r($query); die;

  $barcodes = Barcodes::whereBetween('code',[$seqFrm, $seqTo])->where('year',$year)
  ->get(['codeA','codeB']);

if(count($barcodes) > 0){


?>





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


            $barcodeArray[]=array(
              "barcodeA"=> DNS1D::getBarcodeSVG($codeAval, "C93",0.70,35) ,
              "barcodeACopy"=> DNS1D::getBarcodeSVG($codeAval, "C93",0.70,35) ,
              "barcodeB" => DNS1D::getBarcodeSVG($codeBval, "C93",0.70,35) ,
              "barcodeBCopy"=> DNS1D::getBarcodeSVG($codeBval, "C93",0.70,35),
              "barcodeA_val"=>$codeAval_final,
              "barcodeAcopy_val"=>$codeAval_final,
              "barcodeB_val"=>$codeBval_final,
              "barcodeBcopy_val" =>$codeBval_final);

}


$data['barcode_arr']=$barcodeArray;


if($pdf_param){
$file=$year.'_'.'Barcode.pdf';
//$pdf = PDF::loadView('admin.barcodes.barcode_pdf',compact('data'))
  //  ->setPaper([0, 0, 102.5, 25.0], 'portrait');
//return $pdf->download($file);
$pdf = \View::make('admin.barcodes.barcode_pdf', compact('data'));
return PDF::loadHtml($pdf)->setPaper(array(0,0,235,130))->download($file);
}




}
}


        }
