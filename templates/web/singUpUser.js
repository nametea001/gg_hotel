$("#sign-up-user").on("submit", function (event) {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else {
    alert("Password not match");
    $('#message').html('Not Matching').css('color', 'red');
  }

});