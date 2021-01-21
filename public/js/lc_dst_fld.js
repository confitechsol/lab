$(function(){
  try{
    console.log("lcdstfld");
    $('#lcdstfld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LC DST FLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LC DST FLD'
        }
       ]
    });
  }catch(e){}
});
