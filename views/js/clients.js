/*=================================
 EDIT CLIENT
=================================*/
$(".btnEditClient").click(function(){

    var idClient = $(this).attr("idClient");

    var data = new FormData();
    data.append("idClient", idClient);

    $.ajax({

        url:"ajax/clients.ajax.php",
        method: "POST",
        data: data,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            $("#idClient").val(reply["id"]);
            $("#editClient").val(reply["name"]);
	        $("#editDocumentId").val(reply["document"]);
	        $("#editEmail").val(reply["email"]);
	        $("#editTelephone").val(reply["telephone"]);
	        $("#editAddress").val(reply["address"]);
            $("#editBirthday").val(reply["birthday"])

        }
    })

})

/*=================================
  DELETE CLIENT
=================================*/

$(".btnDeleteClient").click(function(){

    var idClient = $(this).attr("idClient");

    swal({

		title: 'Are you sure you want to delete this client?',
		text: "or Cancel this action!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete client!'
        }).then((reply)=>{
        if (reply.value) {

        	window.location = "index.php?route=clients&idClient="+idClient;

        }

	})

})