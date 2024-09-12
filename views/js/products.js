/*=======================================
    LOAD THE DYNAMIC TABLE OF PRODUCTS
=========================================*/
//  $.ajax({

//         url: "ajax/datatable-products.ajax.php",
//         method: "GET",
//         success: function(reply){

//             console.log("reply",reply);

//         }

// })

var hiddenProfile = $('#hiddenProfile').val();

$('.tableProducts').DataTable({
	"ajax": "ajax/datatable-products.ajax.php?hiddenProfile="+hiddenProfile, 
	"deferRender": true,
	"retrieve": true,
	"processing": true
});


$('.tableProducts').DataTable({

    "ajax": "ajax/datatable-products.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,

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
    ASSIGN A CODE AFTER GETTING CATEGORY 
=============================================*/
$("#newCategory").change(function(){

    var idCategory = $(this).val();

    var data = new FormData();
    data.append("idCategory", idCategory);

    $.ajax({

        url:"ajax/products.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            if(!reply){
                
                var newCode = idCategory+"01";
                $("#newCode").val(newCode);

            }else{

                var newCode = Number(reply["code"]) + 1;
                $("#newCode").val(newCode);

            }           

        }

    })

})

 /*=============================================
    ADDING SALE PRICE 
  =============================================*/
  $("#newBuyingPrice, #editBuyingPrice").change(function(){

        if($(".percentage").prop("checked")){

            var percentValue = $(".newPercentage").val();

            //Calculate Percent Value
            var Percent = Number(($("#newBuyingPrice").val()*percentValue/100))+Number($("#newBuyingPrice").val());

            var editPercent = Number(($("#editBuyingPrice").val()*percentValue/100))+Number($("#editBuyingPrice").val());

            $("#newSalePrice").val(Percent);
            $("#newSalePrice").prop("readonly", true);

            $("#editSalePrice").val(editPercent);
            $("#editSalePrice").prop("readonly", true);

        }

  })

 /*=============================================
    CHANGE THE PERCENTAGE 
  =============================================*/
$(".newPercentage").change(function(){

    if($(".percentage").prop("checked")){

        var percentValue = $(this).val();

        //Calculate Percent Value
        var Percent = Number(($("#newBuyingPrice").val()*percentValue/100))+Number($("#newBuyingPrice").val());

        var editPercent = Number(($("#editBuyingPrice").val()*percentValue/100))+Number($("#editBuyingPrice").val());

        $("#newSalePrice").val(Percent);
        $("#newSalePrice").prop("readonly", true);

        $("#editSalePrice").val(editPercent);
        $("#editSalePrice").prop("readonly", true);

    }

})

$(".percentage").on("ifUnchecked",function(){

    $("#newSalePrice").prop("readonly", false);
    $("#editSalePrice").prop("readonly", false);

})


$(".percentage").on("ifChecked",function(){

    $("#newSalePrice").prop("readonly", true);
    $("#editSalePrice").prop("readonly", true);

})

/*=========================================
   INPUT/UPLOADING IMAGE FOR PRODUCT
========================================== */

$(".newImage").change(function(){

	var image = this.files[0];

  /* VALIDATING FORMAT ...only PNG and JPEG*/

  if(image["type"] != "image/jpeg" && image["type"] != "image/png"){

  	   $(".newImage").val("");

  	   swal({
  	   		title: "Error uploading image!",
  	   		text: "The image must be a jpg or png format.",
  	   		type: "error",
            showConfirmButton: true,
  	   		confirmButtonText: "Close!"

  	   });
	}else if(image["size"] > 2000000){

		$(".newImage").val("");

  	   swal({
  	   		
  	   		title: "Error uploading image!",
  	   		text: "The image size cannot exceed 2MB.",
  	   		type: "error",
            showConfirmButton: true,
  	   		confirmButtonText: "Close!"

  	   		});

	}else{

			var imageData = new FileReader;
			imageData.readAsDataURL(image);

			$(imageData).on("load", function(event){

				var routeImg = event.target.result;

				$(".preview").attr("src",routeImg);

			});
	}

  /* VALIDATE IMAGE ENDS */

})

/*======================================
    EDIT PRODUCT
=========================================*/

$(".tableProducts tbody").on("click", "button.btnEditProduct", function(){

    var idProduct = $(this).attr("idProduct");
   
    var data = new FormData();
    data.append("idProduct",idProduct);

    $.ajax({

        url:"ajax/products.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            var dataCategory = new FormData();
            dataCategory.append("idCategory",reply["id_category"]);

            $.ajax({

                url:"ajax/categories.ajax.php",
                method: "POST",
                data: dataCategory,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success:function(reply){

                    $("#editCategory").val(reply["id"]);
                    $("#editCategory").html(reply["category"]);

                }
                         
            })       
            
                $("#editCode").val(reply["code"]);

                $("#editDescription").val(reply["description"]);

                $("#editStock").val(reply["stock"]);

                $("#editBuyingPrice").val(reply["buying_price"]);

                $("#editSalePrice").val(reply["sale_price"]);

                if(reply["image"] != ""){

                    $("#actualImage").val(reply["image"]);

                    $(".preview").attr("src", reply["image"]);

                }
                   
        }

  })

})

/*======================================
 DELETE PRODUCT
=========================================*/

$(".tableProducts tbody").on("click", "button.btnDeleteProduct", function(){

    var idProduct = $(this).attr("idProduct");
    var code      = $(this).attr("code");
    var image     = $(this).attr("image");

    swal({

		title: 'Are you sure you want to delete this product?',
		text: "or Cancel this action!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete product!'
        }).then((result)=>{
        if (result.value) {

        	window.location = "index.php?route=products&idProduct="+idProduct+"&image="+image+"&Code="+code;

        }

	})

})