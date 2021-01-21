$(function(){
  try{
    console.log("lpa_fld");
    $('#lpa_fld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LPA FLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LPA FLD'
        }
       ]
    });
  }catch(e){}
});
