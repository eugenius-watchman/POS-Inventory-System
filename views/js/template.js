 /*=============================================
         SIDEBAR MENU
 =============================================*/
 
 $('.sidebar-menu').tree();


 /*=============================================
         DATA TABLE PLUGINS
 =============================================*/

 $('.tables').DataTable({

  	"language":{

  		"sProcessing":     "Processing...",
  		"sLengthMenu":     "Show _MENU_ records",
  		"sZeroRecords":    "No results found",
  		"sEmptyTable":     "No data available in this table",
  		"sInfo":           "Showing records from _START_ to _END_ of total of _TOTAL_",
  		"sInfoEmpty":      "Showing records from 0 to 0 of total of 0",
  		"sInfoFiltered":   "(filtering a total of _MAX_ records)",
  		"sInfoPostFix":    "",
  		"sSearch":         "Search:",
  		"sUrl":            "",
  		"sInfoThousands":  ",",
  		"sLoadingRecords": "Loading...",
  		"oPaginate":{
  		"sFirst":    "First",
  		"sLast":     "Last",
  		"sNext":     "Next",
  		"sPrevious": "Previous"
         },
         "oAria":{
         	"sSortAscending": 	":  Activate to sort the column in ascending order",
         	"sSortDescending": 	":	Activate to sort the column in descending order"
		}

	}

 });

 /*=============================================
    iCheck for checkbox and radio inputs
 =============================================*/
 
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
checkboxClass: 'icheckbox_minimal-blue',
radioClass   : 'iradio_minimal-blue'
})

 /*=============================================
   input mask
 =============================================*/

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()

