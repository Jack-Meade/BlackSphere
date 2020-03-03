function requestMount(ip, username, password, mname, folder) {
    $.ajax({
        url: "/bs/mounter.php", // the endpoint
        type: "POST", // http method
        data: { ip: ip, username: username, password: password, mname: mname, folder: folder }, // data sent with the post request

        // handle a successful response
        success: function (html_body) {
            var response = html_body;
            // On success show something to user
            refresh();
        },

        error: function (xhr, errmsg, err) {
            // $('#results').html("<div class='alert-box alert radius' data-alert>Oops! We have encountered an error: " + errmsg +
            //     " <a href='#' class='close'>&times;</a></div>"); // add the error to the dom
            console.log(xhr.status + ": " + xhr.responseText); // provide a bit more info about the error to the console
        }
    });
}

function refresh() {
    $.ajax({
        url: "/bs/body_builder.php", // the endpoint
        type: "POST", // http method
        data: { function: "1", folder: window.location.href.substring(window.location.hostname.length + 8) }, // data sent with the post request

        // handle a successful response
        success: function (html_body) {
            var response = html_body.replace(/\\\//g, "/");
            // On success show something to user
            $("#directoryStructure").replaceWith("<tbody id=\"directoryStructure\">" + response + " </tbody>")
        },

        error: function (xhr, errmsg, err) {
            // $('#results').html("<div class='alert-box alert radius' data-alert>Oops! We have encountered an error: " + errmsg +
            //     " <a href='#' class='close'>&times;</a></div>"); // add the error to the dom
            console.log(xhr.status + ": " + xhr.responseText); // provide a bit more info about the error to the console
        }
    });
}


function makeFolder(name) {
    $.ajax({
        url: "/bs/serverSideExecutables/makefolder.php", // the endpoint
        type: "POST", // http method
        data: { currentFolder: window.location.href.substring(window.location.hostname.length + 8), folderName: name }, // data sent with the post request

        // handle a successful response
        success: function (html_body) {
            // On success show something to user
            refresh();
        },

        error: function (xhr, errmsg, err) {
            // $('#results').html("<div class='alert-box alert radius' data-alert>Oops! We have encountered an error: " + errmsg +
            //     " <a href='#' class='close'>&times;</a></div>"); // add the error to the dom
            console.log(xhr.status + ": " + xhr.responseText); // provide a bit more info about the error to the console
        }
    });
}
