$(document).ready(function () {

  //Customize input label based on file
  var input = document.querySelector('.inputfile');
  if(input != null){customizeInputLabel(input);}

  //Delete files
  $(".delete-files").on("click", function(e){
    e.preventDefault();
    //create a new element, copy the attributes from the old element
    $(".event-form #file").replaceWith($("#file").val('').clone(true));
    //add event listener for file name label
    var input = document.querySelector('.inputfile');
    if(input != null){customizeInputLabel(input);}
    //reset file name label
    $(".event-form #file").next().children("span").text("Choose a photo...");
    //hide x button
    $(".event-form #file").next().children(".delete-files").hide();
  });

  //Datepicker
  addDatepicker();

  //Timepicker
  $('input.timepicker').timepicker({
    timeFormat: 'g:i a',
    interval: 30,
    minTime: '8:00 am',
    maxTime: '11:30 pm',
    // defaultTime: '5:00pm',
    startTime: '8:00 am',

    dynamic: true,
    dropdown: true,
    scrollbar: true
  });

  //Close whatever pop-up is open
  $(".close-pop-up").on("click", function (){
    $(".pop-up").fadeOut(300);
  });

  //Show login form
  $(".navbar").on("click", ".show-login", function(e){
    e.preventDefault();
    showLoginScreen();
  });

  //Login user
  $("form[name='login-form']").submit(function(e){
    e.preventDefault();
    var username = $(this).find("input[name='username']").val();
    var password = $(this).find("input[name='password']").val();
    if(username && password){
      var login = $.ajax({
        url: 'ajax/verifylogin.php',
        method: 'POST',
        data: {username: username, password: password},
        dataType: 'json',
        error: function (error){
          console.log(error);
        },
        success: function (json){
          if(json.hasOwnProperty("status")){
            showLoginStatus(json);
          }
        },
        complete: function (jqXHR, textStatus) {
          console.log(`AJAX thinks login request was a ${textStatus}`);
        }
      });
    }
  });

  //Show logout screen & logout user
  $(".navbar").on("click", ".show-logout",function (e){
    e.preventDefault();
    var logout = $.ajax({
      url: 'ajax/logoutuser.php',
      method: 'POST',
      dataType: 'json',
      error: function (error){
        console.log(error);
      },
      success: function (json){
        if(json.hasOwnProperty("status")){
          showLogoutScreen(json);
        }
      },
      complete: function (jqXHR, textStatus) {
        console.log(`AJAX thinks logout request was a ${textStatus}`);
      }
    });
  });

  //Show add event form
  $(".add-event").on("click", function (){
    fillInAddEventForm();
    $(".event-form").fadeIn(300);
  });

  //Show edit event form
  var id;
  $(".edit-event").on("click", function (){
    id = $(this).parent().attr('id');
    var request = {id: id};
    $.ajax({
      url: 'ajax/geteditevent.php',
      method: 'POST',
      data: request,
      dataType: 'json',
      error: function(error) {
        console.log(error);
      },
      //Create form based on form elements recieved from sql query
      success: function (json) {
        fillInEditEventForm(json);
      },
      //Print status of ajax request to console and fadein the form
      complete: function (jqXHR, textStatus){
        console.log(`AJAX thinks get edit request was a ${textStatus}`);
        $(".event-form").fadeIn(300);
      }
    });
  });

  //Save event edits or add event
  $("form[name='event-form']").submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    var action = $(this).find("button.submit").val();
    $(this).find(".error").remove(); //clear old error message

    //Date validation
    var start_date = $("input[name='start_date']").val();
    var start_time = $("input[name='start_time']").val();
    var start_datetime = start_date.concat(" "+start_time);
    var end_date = $("input[name='end_date']").val();
    var end_time = $("input[name='end_time']").val();
    var dateValid = true;
    var error = "";

    if(!moment(start_datetime, 'M/D/YYYY h:mm a').isValid()){
      dateValid = false;
      error = "Start date is not valid";
      console.log(error);
      console.log("start_datetime: " + start_datetime);
    }
    if(end_date || end_time){
      if(!end_date || !end_time){
        dateValid = false;
        error = "Need to fill in both end date and end time";
        console.log(error);
        console.log("end_date: " + end_date);
        console.log("end_time: " + end_time);
      }else{
        var end_datetime = end_date.concat(" "+end_time);
        if(!moment(start_datetime, 'M/D/YYYY h:mm a').isBefore(moment(end_datetime, 'M/D/YYYY h:mm a'))){
          dateValid = false;
          error = "End date is before start date";
          console.log("start_datetime is before end_datetime? " + moment(start_datetime).isBefore(end_datetime));
          console.log("start_datetime: " + start_datetime);
          console.log("end_datetime: " + end_datetime);
        }
      }
    }

    if(dateValid){
      if(action === "add-event"){
        var add_event = $.ajax({
          url: 'ajax/addevent.php',
          type: 'post',
          data: formData,
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          error: function (error){
           console.log(error);
          },
          success: function (json){
           console.log(json['error']);
           $(".event-form").fadeOut(300);
          },
          complete: function (jqXHR, textStatus) {
           console.log(`AJAX thinks add event request was a ${textStatus}`);
          }
        });
      }else if (action === "edit-event") {
        formData.append('id', id);
        if($(".event-form").find("span.file-label").text() === "Choose a photo..."){
          formData.append('delete-file', true);
        }else{
          formData.append('delete-file', false);
        }
        var edit_event = $.ajax({
          url: 'ajax/saveeditevent.php',
          type: 'post',
          data: formData,
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          error: function (error){
           console.log(error);
          },
          success: function (json){
           console.log(json['error']);
           $(".event-form").fadeOut(500);
          },
          complete: function (jqXHR, textStatus) {
           console.log(`AJAX thinks save edited event request was a ${textStatus}`);
          }
        });
      }
    }else{
      $(".form-content").append(`<p class='error'>${error}</p>`);
    }
  });

  //Delete event
  $(".delete-event").on("click", function(){
    id = $(this).parent().attr('id');
    var deleteForm = $.ajax({
      url: 'ajax/deleteevent.php',
      method: 'POST',
      data: {id: id},
      dataType: 'json',
      error: function(error) {
        console.log(error);
      },
      success: function (error) {
          console.log(error['error']);
          if(error['error'].length === 0){
            $(`#${id}.event`).prev(".seperator").fadeOut(300);
            $(`#${id}.event`).fadeOut(300);
          }
      },
      complete: function (jqXHR, textStatus){
        console.log(`AJAX thinks yes, delete event request was a ${textStatus}`);
        // $(".form-delete").fadeOut(300);
      }
    });
  });

  //Send email to club
  $("form[name='contact-club']").submit(function(e){
    console.log("get's called");
    e.preventDefault();
    var formData = new FormData(this);
    var contact_club = $.ajax({
      url: 'ajax/submitcontactmsg.php',
      type: 'post',
      data: formData,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      error: function (error){
       console.log(error);
      },
      success: function (json){
       console.log(json['error']);
       if(json['error'].length === 0){
         if(json['status']){
           $(".sent").fadeIn(300);
         }else{
           $(".not-sent").fadeIn(300);
         }
       }
      },
      complete: function (jqXHR, textStatus) {
       console.log(`AJAX thinks submit contact form request was a ${textStatus}`);
      }
    });
  });

  //Show new member form
  $(".new-member").on("click", function(){
      $(".new-member-form").fadeIn(300);
  });

  //Show new plant form
  $(".add-plant").on("click", function(){
      $(".new-plant-form").fadeIn(300);
  });

  //Show new type form
  $(".new-type").on("click", function(){
      $(".new-type-form").fadeIn(300);
  });

});

//email sent form
function showSent(){
    $(".sent").fadeIn(300);
}

//member added form
function showMemberConfirm(){
    $(".new-member-complete").fadeIn(300);
}

function showMemberFail(){
    $(".new-member-failed").fadeIn(300);
}

//type added form
function showTypeConfirm(){
    $(".new-type-complete").fadeIn(300);
}

function showTypeFail(){
    $(".new-type-failed").fadeIn(300);
}

//Fill in event form for add event
function fillInAddEventForm(){
  var $addForm = $(".event-form");
  $addForm.find("h1.form-title").text("Create Event");
  $addForm.find("button.submit").val("add-event");
  $addForm.find("button.submit").text("Add Event");
  $addForm.find("span.file-label").text("Choose a photo...");
  $addForm.find("button.delete-files").hide();
  $addForm.find("input[type=text]").val("");
}

//Fill in event form with form field values from JSON
function fillInEditEventForm(json){
  var $editForm = $(".event-form");
  $editForm.find("h1.form-title").text("Edit Event");
  $editForm.find("button.submit").val("edit-event");
  $editForm.find("button.submit").text("Save");
  $editForm.find("span.file-label").text("Choose a photo...");
  $editForm.find("button.delete-files").hide();
  for(var i = 0, len = json['fields'].length; i < len; i++){
    var field = json['fields'][i];
    var value = json[field];
    if(value){
      if(field === "file_name"){
        $editForm.find("span.file-label").text(value);
        $editForm.find("button.delete-files").show();
      }else{
        $editForm.find(`input[name='${field}']`).val(value);
      }
    }
  }
}

//Fade in elements of login screen that may have been hiddens
function showLoginScreen(){
  $(".login-form .log-msg-success").text("");
  $(".login-form .log-msg-failure").text("");
  $(".login-form .log-msg-success").hide();
  $(".login-form .log-msg-failure").hide();
  $(".login-form").fadeIn(300);
  $(".login-form h1").fadeIn(300);
  $(".login-form p").fadeIn(300);
  $(".login-form form[name='login-form']").fadeIn(300);
}

//Change login screen based on status
function showLoginStatus(json){
  if(json['status']){
    $(".login-form h1").hide();
    $(".login-form p").hide();
    $(".login-form form[name='login-form']").hide();
    var username = json['username'];
    $(".login-form .log-msg-success").show();
    $(".login-form .log-msg-success").text(`Congratulations, ${username}! You logged in successfully!`);
    $(".navbar a.show-login").replaceWith("<a href='' class='show-logout'>Logout</a>");
  }else{
    var usererror = json['user_error'];
    $(".login-form .log-msg-failure").show();
    $(".login-form .log-msg-failure").text(usererror);
  }
}

//Change logout screen to username that just logged out
function showLogoutScreen(json){
  if(json['status']){
    var user = json['user'];
    $(".logout-screen .log-message").text(`You have been logged out, see you next time ${user}!`);
    $(".logout-screen").fadeIn(300, function (){
        $(".navbar a.show-logout").replaceWith("<a href='' class='show-login'>Login</a>");
      });
  }else{
    $(".logout-screen .log-message").text(`Logout unsucessful`);
    $(".logout-screen").fadeIn(300);
  }
}

//Add datepicker
function addDatepicker(){
  $.datepicker.setDefaults({
   dateFormat: 'm/d/yy'
  });
  $(".date").datepicker({
      inline: true,
      showOtherMonths: true, dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
  });
}

//customizeInputLabel changes label when select file (for file upload button)
function customizeInputLabel(input) {
    var label = input.nextElementSibling, labelVal = label.innerHTML;
    input.addEventListener('change', function (e) {
        $("#file").next().children(".delete-files").show();
        var fileName = '';
        if (this.files && this.files.length > 1) fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
        else fileName = e.target.value.split('\\').pop();
        if (fileName) label.querySelector('span').innerHTML = fileName;
        else label.innerHTML = labelVal;
    })
}
