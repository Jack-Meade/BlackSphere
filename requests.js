$('#mountRequestForm').on('submit', function (event) {
    event.preventDefault();
    var ip = document.getElementById("ip");
    var username = document.getElementById("username");
    var password = document.getElementById("pass");
    var mname = document.getElementById("mname");
    var folder = document.getElementById("folder");

    requestMount(ip, username, password, mname, folder);
});

function requestMount(ip, username, password, mname, path)
{
    $.ajax({
        url: "/bs/mounter.php", // the endpoint
        type: "POST", // http method
        data: { ip: ip, username: username, password: password, mname: mname, folder: folder}, // data sent with the post request

        // handle a successful response
        success: function (html_body) {
            var response = html_body;
            // On success show something to user
            console.log(html_body);
        },

        error: function (xhr, errmsg, err) {
            // $('#results').html("<div class='alert-box alert radius' data-alert>Oops! We have encountered an error: " + errmsg +
            //     " <a href='#' class='close'>&times;</a></div>"); // add the error to the dom
            console.log(xhr.status + ": " + xhr.responseText); // provide a bit more info about the error to the console
        }
    });
}
