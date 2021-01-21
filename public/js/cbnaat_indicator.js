$(function(){
  try{
    console.log("lcdstfld");
    $('#cbnaat_indicator').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'CBNAAT Indicator'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'CBNAAT Indicator'
        }
       ]
    });
  }catch(e){}
});
