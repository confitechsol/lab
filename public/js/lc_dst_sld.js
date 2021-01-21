$(function(){
  try{
    console.log("lc_dst_sld");
    $('#lc_dst_sld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LC DST SLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LC DST SLD'
        }
       ]
    });
  }catch(e){}
});
