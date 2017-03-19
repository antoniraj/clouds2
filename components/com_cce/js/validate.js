// JavaScript Document

var messageDelay = 2000;  // How long to display status messages (in milliseconds)

// Init the form once the document is ready

// Submit the form via Ajax

function submitForm() {
  var contactForm = $(this);

  // Are all the fields filled in?

  if ( !$('#mtype').val() || !$('#description').val() || !$('#filename').val() ) {

    // No; display a warning message and return to the form
    $('#incompleteMessage').fadeIn().delay(messageDelay).fadeOut();
    contactForm.fadeOut().delay(messageDelay).fadeIn();

  } else {

    // Yes; submit the form to the PHP script via Ajax

    $('#sendingMessage').fadeIn();
    contactForm.fadeOut();

    $.ajax( {
      url: contactForm.attr( 'action' ) + "?ajax=true",
      type: contactForm.attr( 'method' ),
      data: contactForm.serialize(),
      success: submitFinished
    } );
  }

  // Prevent the default form submission occurring
  return false;
}


// Handle the Ajax response
function validateEmailaddress() {
	 id=validatePinCode.caller.arguments[0].target.id;
    var emailText = document.getElementById('email').value;
    var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
    if (pattern.test(emailText)) {
        return true;
    } else {
        alert('Bad email address: ' + emailText);
        return false;
    }
}

function submitFinished( response ) {
  response = $.trim( response );
  $('#sendingMessage').fadeOut();

  if ( response == "success" ) {

    // Form submitted successfully:
    // 1. Display the success message
    // 2. Clear the form fields
    // 3. Fade the content back in

    $('#successMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#senderName').val( "" );
    $('#senderEmail').val( "" );
    $('#message').val( "" );

    $('#content').delay(messageDelay+500).fadeTo( 'slow', 1 );

  } else {

    // Form submission failed: Display the failure message,
    // then redisplay the form
    $('#failureMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#contactForm').delay(messageDelay+500).fadeIn();
  }
}



function compareDate() {
    //In javascript
     id=compareDate.caller.arguments[0].target.id;
    var dateEntered = document.getElementById(id).value; 
    var dateToCompare = new Date(dateEntered);
    var currentDate = new Date();
    if (dateToCompare > currentDate) {
		  document.getElementById(id).value = "";
        alert("Date Entered is greater than Current Date ");

    }
   
}
function check()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }
 
 function validatePinCode()
		{
			// Change the {5} to what ever size the pin code length is of.
			 id=validatePinCode.caller.arguments[0].target.id;
			var pattern = new RegExp("^[0-9]{6}$");
			if(!pattern.test(document.getElementById(id).value))
			 {
				 document.getElementById(id).value = "";
				alert("Please enter a valid pin code.");
			}
			
		}
   function validateEmailaddress() {
	    id=validatePinCode.caller.arguments[0].target.id;
    var emailText = document.getElementById(id).value;
    var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
    if (pattern.test(emailText)) 
    {
        return true;
    } 
    else {
		document.getElementById(id).value="";
        alert('Bad email address: ' + emailText);
        return false;
    }
}


    function imageURL(input) {
var imgpath = document.getElementById('photoimg').value;
var arr1 = new Array;
arr1 = imgpath.split("\\");
var len = arr1.length;
var filesize = (input.files[0].size)/1024;
var img1 = arr1[len-1];
var filext = img1.substring(img1.lastIndexOf(".")+1);

        if ((input.files && input.files[0] && filext == "png") || filext == 'jpg') {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result)
                 .width('138px')
                 .height('140px');
            }
            reader.readAsDataURL(input.files[0]);
        }
        else if (filesize > 2048)
        {
			    alert("Filesize is greater than 2MB");
				var imgpath = document.getElementById('photoimg').value="";
		}
        else{
				alert("Please select only png format");
				var imgpath = document.getElementById('photoimg').value="";
				
		}
    }
