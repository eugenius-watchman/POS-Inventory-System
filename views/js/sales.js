/*=======================================
    VARIABLE LOCAL STORAGE
=========================================*/
if(localStorage.getItem("captureRange") != null){

    $("#daterange-btn span").html(localStorage.getItem("captureRange"));    

}else{

    $("#daterange-btn span").html('<i class="fa fa-calendar"></i> Date range')

}


/*=======================================
    LOAD THE DYNAMIC TABLE OF SALES
=========================================*/
 $.ajax({

        url: "ajax/datatable-sales.ajax.php",
        method: "GET",
        success: function(reply){

            console.log("reply", reply);

        }

})

$('.tableSales').DataTable({

    "ajax": "ajax/datatable-sales.ajax.php",
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
    ADDING PRODUCTS TO SALE FROM TABLE 
=============================================*/
$(".tableSales tbody").on("click", "button.addProduct", function(){

    var idProduct = $(this).attr("idProduct");

    $(this).removeClass("btn-primary addProduct");

    $(this).addClass("btn-default");

    var data = new FormData();
    data.append("idProduct", idProduct);

    $.ajax({

        url:"ajax/products.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            var description = reply["description"];
            var stock = reply["stock"];
            var price = reply["sale_price"];
            
            /*=================================================
          	    STOP ADDING PRODUCT WHEN STOCK IS ZERO 
          	==================================================*/

          	if(stock == 0){

                swal({
                title: "Stock not available!",
                type: "error",
                confirmButtonText: "Close!"
              });
              
              $("button[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");

              return;

            }
            //append to newProduct from create-sales
            $(".newProduct").append(

            '<div class="row" style="padding:5px 15px">'+
            
                '<!--**Product Type/Description**-->'+

                '<div class="col-xs-6" style="padding-right:0px">'+

                    '<div class="input-group">'+
                    
                        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct="'+idProduct+'">'+
                        '<i class="fa fa-times"></i></button></span>'+

                        '<input type="text" class="form-control  newProductType" idProduct="'+idProduct+'" name="addProduct" value="'+description+'" readonly required>'+
                
                    '</div>'+
                                            
                '</div>'+ 

                '<!--**Product Quantity**-->'+

                '<div class="col-xs-3">'+

                     '<input type="number" class="form-control newProductQty" name="newProductQty" min="1" value="1" stock="'+stock+'" newStock="'+Number(stock-1)+'" required>'+
                                                
                '</div>'+

                '<!--**Product Price**-->'+

                '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+

                '<div class="input-group">'+

                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

                    '<input type="text" class="form-control newProductPrice" realPrice="'+price+'" name="newProductPrice" value="'+price+'" readonly required>'+
                    
                '</div>'+                             

                '</div>'+

            '</div>')

            // SUM OF TOTAL PRICES
 
            sumTotalPrices()

            // ADD TAX

            addTax()

            //ADD PRODUCTS IN JASON FORMAT

            listProducts()

            // SET FORMAT TO THE PRODUCT PRICE

	        $(".newProductPrice").number(true, 2);

        }
    })

});

/*=====================================================
    WHEN YOU LOAD TABLE EVERY TIME THEY NAVIGATED IN IT
=======================================================*/

$(".tableSales").on("draw.dt", function(){

    if(localStorage.getItem("removeProduct") != null){

        var listIdProducts = JSON.parse(localStorage.getItem("removeProduct"));

        for(var i = 0; i < listIdProducts.length; i++){

            $("button.recoverButton[idProduct='"+listIdProducts[i]["idProduct"]+"']").removeClass('btn-default');
			$("button.recoverButton[idProduct='"+listIdProducts[i]["idProduct"]+"']").addClass('btn-primary addProduct');

        }

    }

})

/*===============================================
    REMOVE PRODUCTS FROM SALE AND RECOVER BUTTON
==================================================*/

var idRemoveProduct = [];

localStorage.removeItem("removeProduct");

$(".formSales ").on("click", "button.removeProduct", function(){

    $(this).parent().parent().parent().parent().remove();

    var idProduct = $(this).attr("idProduct");

    /*============================================================
    STORE IN LOCALSTORAGE THE ID OF THE PRODUCT WE WANT TO DELETE
    ===============================================================*/
    
    if(localStorage.getItem("removeProduct") == null){

		idRemoveProduct = [];
	
	}else{

		idRemoveProduct.concat(localStorage.getItem("removeProduct"))

	}

    idRemoveProduct.push({"idProduct":idProduct});

	localStorage.setItem("removeProduct", JSON.stringify(idRemoveProduct));
   
    $("button.recoverButton[idProduct='"+idProduct+"']").removeClass('btn-default');

    $("button.recoverButton[idProduct='"+idProduct+"']").addClass('btn-primary addProduct');

    if($(".newProduct").children().length == 0){

        $("#newTaxPrice").val(0);
        $("#newTotalSale").val(0);
        $("#totalSale").val(0);
        $("#newTotalSale").attr("total",0);

    }else{ 

        // SUM OF TOTAL PRICES

        sumTotalPrices()

        // ADD TAX

        addTax()

        //ADD PRODUCTS IN JASON FORMAT

        listProducts()
        
    }
    
})

/*===============================================================
    ADDING PRODUCT FROM OTHER DEVICES
=================================================================*/

var numProduct = 0;

$(".btnAddProduct").click(function(){

    numProduct ++;

    var data = new FormData();
    data.append("getProducts", "ok");

    $.ajax({

        url:"ajax/products.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            $(".newProduct").append(

                '<div class="row" style="padding:5px 15px">'+
                
                    '<!--**Product Type/Description**-->'+
    
                    '<div class="col-xs-6" style="padding-right:0px">'+
    
                        '<div class="input-group">'+
                        
                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct>'+
                            '<i class="fa fa-times"></i></button></span>'+
    
                            '<select class="form-control newProductType " id="product'+numProduct+'" idProduct name="newProductType" required>'+
                            
                            '<option>Select product </option>'+

                            '</select>'+
                    
                        '</div>'+
                                                
                    '</div>'+
    
                    '<!--**Product Quantity**-->'+
    
                    '<div class="col-xs-3 enterQty">'+
    
                        '<input type="number" class="form-control newProductQty" name="newProductQty" min="1" value="1" stock newStock required>'+
                                                    
                    '</div>'+
    
                    '<!--**Product Price**-->'+
    
                    '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+
    
                    '<div class="input-group">'+
    
                        '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
    
                        '<input type="text" class="form-control newProductPrice" realPrice="" name="newProductPrice"  readonly required>'+
                        
                    '</div>'+                             
    
                    '</div>'+
    
                '</div>')

                // ADDING PRODUCTS TO SELECT
                reply.forEach(functionForEach);

                function functionForEach(item, index) {

                        if(item.stock != 0){
                        
                        $("#product"+numProduct).append(

                            '<option idProduct="'+item.id+'" value="'+item.description+'">'+item.description+'</option>'

                        )

                    }
                   
                }

            // SUM OF TOTAL PRICES

            sumTotalPrices()

            // ADD TAX

            addTax()
           
            // SET FORMAT TO THE PRODUCT PRICE

	        $(".newProductPrice").number(true, 2);
                           
        }
    })

})

/*=====================================================
    SELECT PRODUCT
=======================================================*/
$(".formSales").on("change", "select.newProductType", function(){

    var productName = $(this).val();

    var newProductPrice = $(this).parent().parent().parent().children(".enterPrice").children().children(".newProductPrice");

    var newProductQty = $(this).parent().parent().parent().children(".enterQty").children(".newProductQty");


    var data = new FormData();
    data.append("productName", productName);

    $.ajax({

        url:"ajax/products.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(reply){

            $(newProductQty).attr("stock", reply["stock"]);
            $(newProductQty).attr("newStock", Number(reply["stock"])-1);
            $(newProductPrice).val(reply["sale_price"]);
            $(newProductPrice).attr("realPrice",reply["sale_price"]);

            //ADD PRODUCTS IN JASON FORMAT

            listProducts()

        }

    })
})

/*===============================================================
    MODIFY PRODUCT QTY
=================================================================*/
$(".formSales").on("change", "input.newProductQty", function(){

    var price = $(this).parent().parent().children(".enterPrice").children().children(".newProductPrice")

    var finalPrice = $(this).val() * price.attr("realPrice");
 
    price.val(finalPrice);

    var newStock = Number($(this).attr("stock")) - $(this).val();

    $(this).attr("newStock", newStock);

    if(Number($(this).val()) > Number($(this).attr("stock"))){

        /*=====================================================================
		    IF QUANTITY IS MORE THAN THE STOCK VALUE RETURN TO INITIAL VALUES
		======================================================================*/

        $(this).val(1);

        var finalPrice = $(this).val() * price.attr("realPrice");

        price.val(finalPrice);

        sumTotalPrices() ;

        swal({
            title: "The quantity is more than your stock!",
            text: "There are only "+$(this).attr("stock")+" units available!",
            type: "error",
            confirmButtonText: "Close!"
          });
  
          return;

    }
     // SUM OF TOTAL PRICES

     sumTotalPrices()

     // ADD TAX

     addTax()

     //ADD PRODUCTS IN JASON FORMAT

     listProducts()

}) 

/*====================================
  SUM OF ALL/TOTAL PRICES
======================================*/
function sumTotalPrices(){

    var itemPrice = $(".newProductPrice");
    var arraySumPrice = [];

    for (var i = 0; i < itemPrice.length; i++){

        arraySumPrice.push(Number($(itemPrice[i]).val())); 

    }

    function sumArrayPrices(total, number){

        return total + number;

    }

    var sumTotalPrice = arraySumPrice.reduce(sumArrayPrices);

    $("#newTotalSale").val(sumTotalPrice); 
    $("#totalSale").val(sumTotalPrice); 
    $("#newTotalSale").attr("total",sumTotalPrice); 

}
/*====================================
    FUNCTION ADD TAX
======================================*/

function addTax(){

    var tax = $("#newTaxPrice").val();

    var priceTotal = $("#newTotalSale").attr("total");

    var taxPrice = Number(priceTotal * tax/100);

    var totalWithTax = Number(taxPrice) + Number(priceTotal);

    $("#newTotalSale").val(totalWithTax);  

    $("#totalSale").val(totalWithTax);  

    $("#currentTaxPrice").val(taxPrice);

    $("#newNetPrice").val(priceTotal);  

}

/*=============================================
    WHEN TAX CHANGES
=============================================*/

$("#newTaxPrice").change(function(){

	addTax();

});

/*=========================================
    SET FORMAT TO THE PRODUCT PRICE
===========================================*/

$("#newTotalSale").number(true, 2);

/*=========================================
    SELECT METHOD/MODE of PAYMENT
===========================================*/

$("#newPaymentMode").change(function(){
    
	var mode = $(this).val();

	if(mode == "Cash"){

		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".paymentModeBoxes").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 

			 		'<input type="text" class="form-control" id="newCashValue" placeholder="000000" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="getCashChange" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="newCashChange"  placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 )

         // ADDING FORMAT TO THE PRICE 

		$('#newCashValue').number( true, 2);
        $('#newCashChange').number( true, 2);

        // LIST PAYMENT MODE IN THE INPUT

        listModes()

    }else{

        $(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		$(this).parent().parent().parent().children('.paymentModeBoxes').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="newTransactionCode" placeholder="Transaction code"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

            '</div>')

    }
    
})

/*=============================================
`      CASH CHANGE
=============================================*/
$(".formSales").on("change", "input#newCashValue", function(){
	
	var cash = $(this).val();

	var change =  Number(cash) - Number($('#newTotalSale').val());

	var newCashChange = $(this).parent().parent().parent().children('#getCashChange').children().children('#newCashChange');

	newCashChange.val(change);

})

/*=============================================
`     TRANSACTION CODE CHANGE
=============================================*/
$(".formSales").on("change", "input#newTransactionCode", function(){

     // LIST PAYMENT MODE IN THE INPUT

     listModes()
		
})


/*=============================================
LIST ALL THE PRODUCTS
=============================================*/

function listProducts(){

	var productsList = [];
 
	var description = $(".newProductType");

	var quantity = $(".newProductQty");

	var price = $(".newProductPrice");

	for(var i = 0; i < description.length; i++){

		productsList.push({ "id" : $(description[i]).attr("idProduct"), 
                            "description" : $(description[i]).val(),
                            "quantity" : $(quantity[i]).val(),
                            "stock" : $(quantity[i]).attr("newStock"),
                            "price" : $(price[i]).attr("realPrice"),
                            "total" : $(price[i]).val()})
	}

	$("#productsList").val(JSON.stringify(productsList)); 

} 

/*=============================================
    PAYMENT MODE LISTS
=============================================*/

function listModes(){

	var listModes = "";

	if($("#newPaymentMode").val() == "Cash"){

		$("#listPaymentMode").val("Cash");

	}else{

		$("#listPaymentMode").val($("#newPaymentMode").val()+"-"+$("#newTransactionCode").val());

	}

}

/*=============================================
   BUTTON TO EDIT SALE 
=============================================*/
$(".tables").on("click", ".btnEditSale", function(){

    var idSale = $(this).attr("idSale");

    window.location = "index.php?route=edit-sales&idSale="+idSale;

    
})

/*====================================================================================
FUNCTION TO DEACTIVATE "ADD" BUTTONS WHEN THE PRODUCT HAS BEEN SELECTED IN THE FOLDER
=======================================================================================*/

function removeAddProductSale(){

	//Capture all the products' id that were selected in the sale
	var idProducts = $(".removeProduct");

	//Capture all the buttons to add that appear in the table
	var tableButtons = $(".tableSales tbody button.addProductSale");

	//Navigate the cycle to get the different idProducts that were added to the sale
	for(var i = 0; i < idProducts.length; i++){

		//Capture the IDs of the products added to the sale
		var button = $(idProducts[i]).attr("idProduct");
		
		//Go over the table that appears to deactivate the "add" buttons
		for(var j = 0; j < tableButtons.length; j ++){

			if($(tableButtons[j]).attr("idProduct") == button){

				$(tableButtons[j]).removeClass("btn-primary addProductSale");
				$(tableButtons[j]).addClass("btn-default");

			}
		}

	}
	
}

/*==================================================================================
EVERY TIME THE TABLE IS LOADED WHEN NAVIGATED THROUGH, IT EXECUTES A FUNCTION
====================================================================================*/

$('.tableSales').on('draw.dt', function(){

	removeAddProductSale();

})

/*=============================================
    DELETE SALE
=============================================*/

$(".tables").on("click", ".btnDeleteSale",function(){

    var idSale = $(this).attr("idSale");
  
    swal({
          title: 'Are you sure you want to delete this sale?',
          text: "Or else, Cancel!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancel',
          confirmButtonText: 'Yes, delete sale!'
        }).then((result) => {
          if (result.value) {
            
              window.location = "index.php?route=sales&idSale="+idSale;
         
           }
  
    })
  
  })

/*=============================================
   PRINTING BILL
=============================================*/

$(".tables").on("click", ".btnPrintBill", function(){

    var saleCode = $(this).attr("saleCode");

    window.open("extensions/tcpdf/pdf/bill.php?code="+saleCode, "_blank");


})

/*=============================================
    DATE RANGE
=============================================*/

$('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 days': [moment().subtract(29, 'days'), moment()],
        'this month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment(),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  
      var initialDate = start.format('YYYY-MM-DD');
  
      var finalDate = end.format('YYYY-MM-DD');
  
      var captureRange = $("#daterange-btn span").html();
     
         localStorage.setItem("captureRange", captureRange);
         console.log("localStorage", localStorage);
  
         window.location = "index.php?route=sales&initialDate="+initialDate+"&finalDate="+finalDate;
  
    }
  
  )

/*=============================================
    CANCEL DATE RANGE
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("captureRange");
	localStorage.clear();
	window.location = "sales";
})

/*=============================================
    BUTTON FOR CAPTURE TODAY 
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var todayButton = $(this).attr("data-range-key");

	if(todayButton == "Today"){

		var d = new Date();
		
		var day = d.getDate();
		var month= d.getMonth()+1;
		var year = d.getFullYear();

		if(month < 10){

			var initialDate = year+"-0"+month+"-"+day;
			var finalDate = year+"-0"+month+"-"+day;

		}else if(day < 10){

			var initialDate = year+"-"+month+"-0"+day;
			var finalDate = year+"-"+month+"-0"+day;

		}else if(month < 10 && day < 10){

			var initialDate = year+"-0"+month+"-0"+day;
			var finalDate = year+"-0"+month+"-0"+day;

		}else{

			var initialDate = year+"-"+month+"-"+day;
	    	var finalDate = year+"-"+month+"-"+day;

		}	

    	localStorage.setItem("captureRange", "Today");

    	window.location = "index.php?route=sales&initialDate="+initialDate+"&finalDate="+finalDate;

	}

})








