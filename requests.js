$('#mountRequestForm').on('submit', function (event) {
    event.preventDefault();
    var ip = document.getElementById();
    var username = document.getElementById();
    var password = document.getElementById();
    var mname = document.getElementById();
    var path = document.getElementById();

    requestMount(ip, username, password,mname, path);
});

function requestMount(ip, user, password, path)
{
    $.ajax({
        url: "https://jmpi.ddns.net/mounter.php", // the endpoint
        type: "POST", // http method
        data: { ip: ip, username: username, password: password, mname: mname, path: path}, // data sent with the post request

        // handle a successful response
        success: function (json) {
            var response = json;
            
            // On success show something to user
        },

        error: function (xhr, errmsg, err) {
            // $('#results').html("<div class='alert-box alert radius' data-alert>Oops! We have encountered an error: " + errmsg +
            //     " <a href='#' class='close'>&times;</a></div>"); // add the error to the dom
            console.log(xhr.status + ": " + xhr.responseText); // provide a bit more info about the error to the console
        }
    });
}