/*=======================================
    EDIT CATEGORY 
=========================================*/
$(document).on('click', '.btnEditCategory', function() {
    var idCategory = $(this).attr("idCategory");
    console.log("Clicked category ID:", idCategory); // Verify correct ID
    
    // Add cache buster and verify URL
    $.ajax({
        url: "ajax/categories.ajax.php?nocache="+new Date().getTime(),
        method: "POST",
        data: {idCategory: idCategory},
        dataType: "json",
        success: function(reply) {
            console.log("Response for ID", idCategory, ":", reply);
            if(reply.id == idCategory) { // Verify ID matches
                $("#editCategory").val(reply.category);
                $("#idCategory").val(reply.id);
            } else {
                console.error("ID mismatch! Requested:", idCategory, "Got:", reply.id);
            }
        }
    });
});

/*=======================================
    DELETE CATEGORY 
=========================================*/

$(document).on('click', '.btnDeleteCategory', function(e){
    e.preventDefault(); // Prevent default button behavior

    const idCategory = $(this).attr("idCategory");
    
    swal({
        title: "Are you sure?",
        text: "This will permanently delete the category!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete"
    }).then((result) => {
        if (result.value) {
            //window.location = "categories?idCategory=" + idCategory;
             window.location = "index.php?route=categories&idCategory="+idCategory;
        }
    });
});
// $(".btnDeleteCategory").click(function(){

//     var idCategory = $(this).attr("idCategory");

//     swal({
//         title: "Are you sure to delete this category?",
//         text: "Cancel the action.",
//         type:"warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         cancelButtonText: "Cancel",
//         confirmButtonText: "Yes,delete category!"
//     }).then((reply)=>{

//         if(reply.value){

//          window.location = "index.php?route=categories&idCategory="+idCategory;

//         }


//     })

// })
// $(document).on('click', '.btnDeleteCategory', function(e) {
//     e.preventDefault();
//     var idCategory = $(this).attr('idCategory');
    
//     swal({
//         title: "Are you sure?",
//         text: "This will permanently delete the category!",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#d33",
//         cancelButtonColor: "#3085d6",
//         confirmButtonText: "Yes, delete it!",
//         allowOutsideClick: false
//     }).then((result) => {
//         if (result.value) {
//             // Create a temporary iframe to handle the response
//             var iframe = document.createElement('iframe');
//             iframe.style.display = 'none';
//             iframe.src = 'index.php?route=categories&action=deleteCategory&idCategory=' + idCategory;
//             document.body.appendChild(iframe);
            
//             // Clean up after loading
//             iframe.onload = function() {
//                 document.body.removeChild(iframe);
//             };
//         }
//     });
// });
// $(document).on('click', '.btnDeleteCategory', function() {
//     const idCategory = $(this).attr('idCategory');
//     const deleteUrl = `index.php?route=categories&action=deleteCategory&idCategory=${idCategory}`;
    
//     if (!confirm('Permanently delete this category?')) return;
    
//     // Visual feedback
//     const $btn = $(this);
//     $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
    
//     // Debugging - Log the exact URL being called
//     console.log('DELETE REQUEST TO:', deleteUrl); 
    
//     $.ajax({
//         url: deleteUrl,
//         type: 'GET',
//         dataType: 'json',
//     })
//     .done(function(response) {
//         console.log('SERVER RESPONSE:', response);
//         if (response?.success) {
//             location.reload(); // Force page refresh
//         } else {
//             alert('Error: ' + (response?.message || 'Deletion failed'));
//         }
//     })
//     .fail(function(xhr) {
//         console.error('AJAX ERROR:', xhr.responseText);
//         alert('Server error: Check console for details');
//     })
//     .always(function() {
//         $btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
//     });
// });


// $(document).on('click', '.btnEditCategory', function(){
//     var idCategory = $(this).attr("idCategory");
    
//     $.ajax({
//         url: "ajax/categories.ajax.php",
//         method: "POST",
//         data: {idCategory: idCategory},
//         dataType: "json",
//         success: function(reply){
//             // Check if reply is an array and get first element
//             var categoryData = Array.isArray(reply) ? reply[0] : reply;
            
//             $("#editCategory").val(categoryData.category);
//             $("#idCategory").val(categoryData.id);
//         },
//         error: function(xhr, status, error) {
//             console.error("AJAX Error:", status, error);
//         }
//     });
// });

// $(".btnEditCategory").click(function(){

//     var idCategory = $(this).attr("idCategory");

//     var data = new FormData();
//     data.append("idCategory", idCategory);

//     $.ajax({
//         url: "ajax/categories.ajax.php",
//         method: "POST",
//         data: data,
//         cache: false,
//         contentType: false,
//         processData: false,
//         dataType: "json",
//         success: function(reply){

//             $("#editCategory").val(reply["category"]);
//             $("#idCategory").val(reply["id"]);

//             //console.log("reply",reply);
//         }

//     })
    
// });