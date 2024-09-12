/*=======================================
    EDIT CATEGORY 
=========================================*/
$(".btnEditCategory").click(function(){

    var idCategory = $(this).attr("idCategory");

    var data = new FormData();
    data.append("idCategory", idCategory);

    $.ajax({
        url: "ajax/categories.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(reply){

            $("#editCategory").val(reply["category"]);
            $("#idCategory").val(reply["id"]);

            //console.log("reply",reply);
        }

    })
    
});

/*=======================================
    DELETE CATEGORY 
=========================================*/

$(".btnDeleteCategory").click(function(){

    var idCategory = $(this).attr("idCategory");

    swal({
        title: "Are you sure to delete this category?",
        text: "Cancel the action.",
        type:"warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancel",
        confirmButtonText: "Yes,delete category!"
    }).then((reply)=>{

        if(reply.value){

            window.location = "index.php?route=categories&idCategory="+idCategory;

        }


    })

})