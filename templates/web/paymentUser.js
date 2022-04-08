$(document).on('change', '#imgUpload', function (event) {
  let files = event.currentTarget.files;
  console.log(files[0]);

  var output = document.getElementById('output');
    output.src = URL.createObjectURL(files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
    document.getElementById("output").className += "display_image";
});


