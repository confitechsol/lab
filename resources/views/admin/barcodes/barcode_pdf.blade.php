<?php  //echo "<pre>"; print_r($data); echo "</pre>"; die; ?>
<?php  //echo "<pre>"; print_r($data); echo "</pre>"; die; ?>
<link rel="stylesheet" type="text/css" href="{{ ('css/print.css') }}" media="print">

<style>

    @media print {

            @page {
              margin-top:0px;
              size: 100mm 25mm;
              #size: 100mm 25mm;
            }

            img {
                margin-top: 5%;
                margin-right: 2%;
                }


              }
img {
    margin-top: -3px;
    margin-right: 2%;
     }
</style>

<body>

  <?php
//dd($data['set_a']);
if($data['set_a'] == 1){

   foreach ($data['barcode_arr'] as $key => $value) {
     // print_r($value);
    $barcode_A= $value['barcodeA_val'];
    $barcode_B= $value['barcodeB_val'];
    $codeA=$value['codeA'];
    $codeB=$value['codeB'];
    echo "<br>";

    ?>
    <img style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>

    <img  style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>

    <img  style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_B,"ptext"=>$codeB])}}'/>

    <img  src='{{ url("/printcode",["text"=>$barcode_B,"ptext"=>$codeB])}}'/>

    <div style="margin-bottom: 0px;"></div>

    <?php  } 

}else{ 
   foreach ($data['barcode_arr'] as $key => $value) {
     // print_r($value);
    $barcode_A= $value['barcodeA_val'];
    //$barcode_B= $value['barcodeB_val'];
    $codeA=$value['codeA'];
   // $codeB=$value['codeB'];
    echo "<br>";

    ?>
    <img style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>

    <img  style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>

    <img style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>

    <img  style="margin-right: 4%;" src='{{ url("/printcode",["text"=>$barcode_A,"ptext"=>$codeA])}}'/>
    

    <div style="margin-bottom: 0px;"></div>

    <?php  } 

}
 ?>

</body>
