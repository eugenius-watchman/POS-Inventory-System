/*=================================
 EDIT CLIENT
=================================*/
// $(".btnEditClient").click(function(){

//     var idClient = $(this).attr("idClient");

//     var data = new FormData();
//     data.append("idClient", idClient);

//     $.ajax({

//         url:"ajax/clients.ajax.php",
//         method: "POST",
//         data: data,
//         cache:false,
//         contentType: false,
//         processData: false,
//         dataType: "json",
//         success:function(reply){

//             // $("#idClient").val(reply["id"]);
//             // $("#editClient").val(reply["name"]);
//             // $("#editDocumentId").val(reply["document"]);
//             // $("#editEmail").val(reply["email"]);
//             // $("#editTelephone").val(reply["telephone"]);
//             // $("#editAddress").val(reply["address"]);
//             // $("#editBirthday").val(reply["birthday"])

//             // $("#idClient").val(reply.id);
//             // $("#editClient").val(reply.name);
//             // $("#editDocumentId").val(reply.document);
//             // $("#editEmail").val(reply.email || "");
//             // $("#editTelephone").val(reply.telephone || "");
//             // $("#editAddress").val(reply.address || "");
//             // $("#editBirthday").val(reply.birthday || "");


//         }
//     });

// });

// $(document).on('click', '.btnEditClient', function() {
//     var clientId = $(this).attr('idClient');

//     // Use AJAX to fetch client data by ID
//     $.ajax({
//         url: "ajax/clients.ajax.php",
//         method: "POST",
//         data: { idClient: idClient },
//         dataType: "json",
//         success: function(response) {
//             // Populate form fields with the fetched data
//             $('#idClient').val(reply.id);
//             $('#editClient').val(reply.name);
//             $('#editDocumentId').val(reply.document);
//             $('#editEmail').val(reply.email || '');
//             $('#editTelephone').val(reply.telephone || '');
//             $('#editAddress').val(reply.address || '');
//             $('#editBirthday').val(reply.birthday || '');
//         },
//         error: function() {
//             alert('Error fetching client data.');
//         }
//     });
// });


$(document).on('click', '.btnEditClient', function() {
    var idClient = $(this).attr('idClient');

    $.ajax({
        url: "ajax/clients.ajax.php",
        method: "POST",
        data: { idClient: idClient },
        dataType: "json",
        success: function(data) {
            if (data) {
                $('#clientId').val(data.id);
                $('#editClient').val(data.name);
                $('#editDocumentId').val(data.document);
                $('#editEmail').val(data.email);
                $('#editTelephone').val(data.telephone);
                $('#editAddress').val(data.address);
                $('#editBirthday').val(data.birthday);
            } else {
                console.error('Error: No data returned from server');
            }
        },
        error: function() {
            console.error('Error in fetching client data');
        }
    });
});

/*=================================
  DELETE CLIENT
=================================*/

$(document).on("click", ".btnDeleteClient", function(){

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

	});

});

// $(document).on("click", ".btnDeleteClient", function() {
//     var idClient = $(this).attr("idClient");

//     swal({
//         title: 'Are you sure you want to delete this client?',
//         text: "or Cancel this action!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         cancelButtonText: 'Cancel',
//         confirmButtonText: 'Yes, delete client!'
//     }).then((reply) => {
//         if (reply.value) {
//             $.ajax({
//                 url: "ajax/clients.ajax.php",
//                 method: "POST",
//                 data: { idClient: idClient, action: 'delete' },
//                 dataType: "json",
//                 success: function(response) {
//                     if (response.success) {
//                         swal('Deleted!', 'Client has been deleted.', 'success').then(() => {
//                             location.reload();
//                         });
//                     } else {
//                         swal('Error!', 'Could not delete the client.', 'error');
//                     }
//                 },
//                 error: function() {
//                     swal('Error!', 'Error in deleting client data.', 'error');
//                 }
//             });
//         }
//     });
// });
