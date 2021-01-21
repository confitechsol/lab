$(function(){
  try{
    console.log("lj_dst_sld");
    $('#lj_dst_sld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LJ DST SLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LJ DST SLD'
        }
       ]
    });
  }catch(e){}
});
