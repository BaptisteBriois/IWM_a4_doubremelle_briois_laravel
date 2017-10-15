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

$(".removeUser").submit(function(e) {
    form = $(this);
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["remove_user"],
        data: {
            user_id: $(this).find(".user_id").val(),
            user_role: $(this).find(".user_role").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $(form).parent().remove();
    });
});