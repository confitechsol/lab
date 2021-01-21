$(function(){
  try{
    console.log("lpa_sld");
    $('#lpa_sld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LPA SLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LPA SLD'
        }
       ]
    });
  }catch(e){}
});
