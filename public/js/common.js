$(function(){

try{
	$('#example').DataTable( {
	     "order": [[ 0, "desc" ]],
	      dom: 'Bfrtip',
		  pageLength: 25,
	      buttons: [
	         // 'excel', 'pdf',
	         'excel'
	      ]
	 } );
	
    // Setup - add a text input to each footer cell
    $('#btdtls thead tr#filterrow th').each( function () {
        var title = $('#btdtls thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" onclick="stopPropagation(event);" placeholder="Search '+title+'" style=\"font-family:Arial, FontAwesome\" />' );
    } );
    // Apply the filter
    $("#btdtls thead input").on( 'keyup change', function () { //alert();
        table
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
    } );
 
    // DataTable
    var table =  $('#btdtls').DataTable( {
	     ordering: true,
	     dom: 'Bfrtip',
		  pageLength: 25,
	      buttons: [
		  {
           extend: 'excel',
           footer: false,
          
       },
	       
	      ]
	 } );
	/*var table = $('#btdtls').DataTable( {
    orderCellsTop: true,
    "scrollX": true
} );*/
     

  function stopPropagation(evt) {
		if (evt.stopPropagation !== undefined) {
			evt.stopPropagation();
		} else {
			evt.cancelBubble = true;
		}
	}

	//  $('#solid_culture').DataTable({
	// 	searching: false,
	// 	paging: false,
	// 	ordering: false,
	// 	dom: 'Bfrtip',
	// 		buttons: [
	// 			{
	// 				extend: 'excel',
	// 				text: 'Download Excel',
	// 				filename: 'Solid Culture'
	// 			},
	// 			{
	// 				extend: 'pdf',
	// 				text: 'Download PDF',
	// 				filename: 'Solid Culture'
	// 			}
	// 		]
	//  });

 }
 catch(e){}
 var curUrl = window.location.href;
	//console.log('curUrl', curUrl);
	//console.log(curUrl.split("/"));
	$("#menu li a").each(function(i){
		//console.log('obj:',$(this).attr('href') );
		if(curUrl.indexOf($(this).attr('href')) > -1){
			$(this).parent().addClass('active');
			//console.log("Element",$(this).parent().index());
			var position = ($(this).parent().index() * 60);
			$(".scroll-sidebar").slimScroll({ scrollTo : position+'px' })
		}
	});

	// $("#subDiagnosis li.active").each(function(i){
	// 	$(this).removeClass('active');
	// }

	$("#subDiagnosis li a").each(function(i){
		//console.log('obj:',$(this).attr('href') );
		if(curUrl.indexOf($(this).attr('href')) > -1){
			$(this).parent().addClass('active');
			$(".menu ul .submenu").attr('style', 'display:block!important;');
			//console.log("Element",$(this).parent().index());
			var position = ($(this).parent().parent().parent().index() * 60);
			$(".scroll-sidebar").slimScroll({ scrollTo : position+'px' })
		}
	});
    
	$("#subForm15A li a").each(function(i){
		//console.log('obj:',$(this).attr('href') );
		if(curUrl.indexOf($(this).attr('href')) > -1){
			$(this).parent().addClass('active');
			$(".menu ul .submenu").attr('style', 'display:block!important;');
			//console.log("Element",$(this).parent().index());
			var position = ($(this).parent().parent().parent().index() * 60);
			$(".scroll-sidebar").slimScroll({ scrollTo : position+'px' })
		}
	});
	//$("#menu").animate({ scrollTop: 1000 }, { duration: 200 } );
	//$('#menu').slimScroll({ scrollTo : '100px' });
	//console.log("common js");
// 	$( ".datepicker" ).datepicker({
// 		dateFormat: 'dd-mm-yy' ,
// 		maxDate: new Date(new Date().setDate(new Date()))
//
// });

			$(".datepicker").attr("placeholder", "dd-mm-yy").datepicker({
					dateFormat: "dd-mm-yy",
					maxDate: "+0"
			}).on("change", function(e) {
					var curDate = $(this).datepicker("getDate");
					var maxDate = new Date();
					maxDate.setDate(maxDate.getDate());
					maxDate.setHours(0, 0, 0, 0);
					if (curDate > maxDate) {
							//alert("invalid date");
							$(this).datepicker("setDate", maxDate);
					}
			});

			$(".datepicker_due").attr("placeholder", "dd-mm-yy").datepicker({
        dateFormat: "dd-mm-yy",
        minDate: "-0"
    }).on("change", function(e) {
        var curDate = $(this).datepicker("getDate");
        var minDate = new Date();
        minDate.setDate(minDate.getDate());
        minDate.setHours(0, 0, 0, 0);
        if (curDate < minDate) {
            //alert("invalid date");
            $(this).datepicker("setDate", minDate);
        }
    });


});
