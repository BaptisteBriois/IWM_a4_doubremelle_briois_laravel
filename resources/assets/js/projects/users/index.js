$("#adminForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["add_admin"],
        data: {
            email: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $("#adminForm").find("input").val("");
        $("#viewerList ul").find("li:contains(" + response.user.name + ")").remove();
        $("#adminList ul").append('<li>' + response.user.name + '</li>');
    });
});

$("#viewerForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["add_viewer"],
        data: {
            email: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $("#viewerForm").find("input").val("");
        $("#viewerList ul").append('<li>' + response.user.name + '</li>')
    });
});