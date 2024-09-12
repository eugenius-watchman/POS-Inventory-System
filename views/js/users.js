/*=====================================
   INPUT/UPLOADING PICTURE FOR USERS
====================================== */

$(".newPicture").change(function(){

	var image = this.files[0];

  /* VALIDATING FORMAT ...only PNG and JPEG*/

  if(image["type"] != "image/jpeg" && image["type"] != "image/png"){

  	   $(".newPicture").val("");

  	   swal({
  	   		title: "Error uploading image!",
  	   		text: "The image must be a jpg or png format.",
  	   		type: "error",
          showConfirmButton: true,
  	   		confirmButtonText: "Close!"

  	   });
	}else if(image["size"] > 2000000){

		$(".newPicture").val("");

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

				var routeImage = event.target.result;

				$(".preview").attr("src",routeImage);

			});
	}

  /* VALIDATE IMAGE ENDS */

})

/*================================
  EDIT USER PICTURE
================================= */
$(document).on("click",".btnEditUser",function(){

    var idUser = $(this).attr("idUser");

    var data = new FormData();
    data.append("idUser",idUser);

    $.ajax({

        url:"ajax/users.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(reply){

          $("#editName").val(reply["name"]);
          $("#editUser").val(reply["user"]);
          $("#editProfile").html(reply["profile"]);
          $("#editProfile").val(reply["profile"]);
          $("#currentPassword").val(reply["password"]);
          $("#currentPicture").val(reply["picture"]);


          if(reply["picture"] != ""){

            $(".preview").attr("src", reply["picture"]);

          }

        }


    });

});

/*================================
 ACTIVATE USER
================================= */
$(document).on("click",".btnActivate",function(){

  var idUser = $(this).attr("idUser");
  var userStatus = $(this).attr("userStatus");

  var data = new FormData();
  data.append("idActivate", idUser);
  data.append("userActivate", userStatus);

  $.ajax({

      url:"ajax/users.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType:false,
      processData:false,
      success: function(result){

        if(window.matchMedia("(max-width:767px)").matches){

          swal({
            title: "User has been activated",
            type: "success",
            confirmButtonText: "Close"
          }).then(function(result){

              if (result.value){

                window.location = "users";

              }

          })

        }
        //{
        //  $stmt = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE $item2 = :$item2");
  
          //$stmt->bindParam(":{$item1}", $value1, PDO::PARAM_STR);
  
      
     }

  })

  if(userStatus == 0){

    $(this).removeClass('btn-success');
    $(this).addClass('btn-danger');
    $(this).html('Deactivated');
    $(this).attr('userStatus',1);

  }else{

    $(this).addClass('btn-success');
    $(this).removeClass('btn-danger');
    $(this).html('Activated');
    $(this).attr('userStatus',0);


  }

});



/*=======================================
 CHECK/VALIDATE IF USER ALREADY EXISTS
========================================= */
$("#newUser").change(function(){

  $(".alert").remove();

  var user = $(this).val();  

  var data = new FormData();
  data.append("validateUser", user);

  $.ajax({

        url:"ajax/users.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(reply){

          if(reply){

              $("#newUser").parent().after('<div class="alert alert-warning">Sorry! Username already exists.</div>');

              $("#newUser").val("");

          }

        }
 });

});

/*=======================================
  DELETE USER
========================================= */
$(document).on("click",".btnDeleteUser",function(){

    var userId = $(this).attr("userId");
    var userPicture = $(this).attr("userPicture");
    var user = $(this).attr("user");

    swal({
      title:'Are you sure you want to delete user ?',
      text: 'or Cancel action.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor:'#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancel',
      confirmButtonText: 'Yes! Delete user.'
     }).then(function(reply){

        if(reply.value){

            window.location = "index.php?route=users&userId="+userId+"&user="+user+"&userPicture="+userPicture; 
          
        }
        

      })

});
