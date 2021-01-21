$(function(){
  try{
    console.log("lcdstfld");
    $('#lj_dst_fld').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
          extend: 'excel',
          text: 'Download Excel',
          filename: 'LJ DST FLD'
        },
        {
          extend: 'pdf',
          text: 'Download PDF',
          filename: 'LJ DST FLD'
        }
       ]
    });
  }catch(e){}
});
