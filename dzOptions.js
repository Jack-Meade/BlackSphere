Dropzone.autoDiscover = false;
window.onload = function () {

  var dropzoneOptions = {
    dictDefaultMessage: 'Drop Here!',
    paramName: "file",
    maxFilesize: 100,   // MB
    thumbnailWidth: null,
    thumbnailHeight: null,
    addRemoveLinks: true,
    autoProcessQueue: false,

    init: function () {
        this.on("success", function(file) {
            console.log("success > " + file.name);
        });
    },
  };
  var submitButton = document.querySelector("#submit-all");
  var uploader = document.querySelector('#myDropzone');
  var newDropzone = new Dropzone(uploader, dropzoneOptions);
  newDropzone.on("addedfile", function() {
    var btn = document.getElementById("submit-all");
    btn.style.display = "block";
  });
  submitButton.addEventListener("click", function() {
    newDropzone.processQueue(); // Upload added files.
  });
};
