$(function(){
  try{
    console.log("solid_culture");
    $('#solid_culture').DataTable({
     searching: false,
     paging: false,
     ordering: false,
     dom: 'Bfrtip',
       buttons: [
         {
           extend: 'excel',
           text: 'Download Excel',
           filename: 'Solid Culture'
         },
         {
           extend: 'pdf',
           text: 'Download PDF',
           filename: 'Solid Culture'
         }
       ]
    });
  }
  catch(e){}
});
