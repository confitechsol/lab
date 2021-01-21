<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Barcodes extends Model
{
  protected $table = 'm_barcodes';
  protected $fillable = ['year','code','codeA','codeB','barcodeA','barcodeB','barcode_status_A','barcode_status_B','Bar_Yr_Int1','Bar_Yr_Int2','Bar_Yr_Char1','Bar_Yr_Char2'];


public static function FetchCodeA($scanval){

  $status=Barcodes::select('barcode_status_A')->where('barcodeA',$scanval)->get();
  $status=$status[0]['original']['barcode_status_A'];

// echo $status; die;
  if($status == 'Y'){
  return "access_denied";
  }else{
  $query=Barcodes::select('codeA')->where('barcodeA',$scanval)->get();
  return $query[0]['original']['codeA'];
}
}


public static function FetchCodeA_2($enterscan_val){

  $status=Barcodes::select('barcode_status_A')->where('codeA',$enterscan_val)->get();

  if(count($status) > 0){
    // dd("hi");
    $status=$status[0]['original']['barcode_status_A'];
  }else{
    $status='Y';
  }


// echo $status; die;
  if($status == 'Y'){
  return "access_denied";
  }else{
  $query=Barcodes::select('codeA')->where('codeA',$enterscan_val)->get();
  // dd($query);
  return $query[0]['original']['codeA'];

}
}



public static function GetCodeA($scanval){
  $query=Barcodes::select('codeA')->where('barcodeA',$scanval)->get();
  if(!empty($query[0]['original']['codeA'])){
  return $query[0]['original']['codeA'];
  }

}



public static function GetCodeB($scanval){
  $query=Barcodes::select('codeB')->where('barcodeB',$scanval)->get();
  if(!empty($query[0]['original']['codeB'])){

      return $query[0]['original']['codeB'];
  }

}


public static function FetchCodeB($scanval){
    $status=Barcodes::select('barcode_status_B')->where('barcodeB',$scanval)->get();
    $status=$status[0]['original']['barcode_status_B'];

  if($status == 'Y'){
  return "access_denied";
  }else{
  $query=Barcodes::select('codeB')->where('barcodeB',$scanval)->get();
    return $query[0]['original']['codeB'];
}
}




public static function FetchCodeB_2($enterscan_val){
    $status=Barcodes::select('barcode_status_B')->where('codeB',$enterscan_val)->get();
      if(count($status) > 0){
        $status=$status[0]['original']['barcode_status_B'];
      }else{
          $status='Y';
      }


  if($status == 'Y'){
  return "access_denied";
  }else{
  $query=Barcodes::select('codeB')->where('codeB',$enterscan_val)->get();
    return $query[0]['original']['codeB'];
}
}




}
