dragula($('.panel-drag').toArray());
$('.datepicker').pickadate();

$("#categoryForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["category_store"],
        data: {
            project_id: $(this).data('project-id'),
            title: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $("#categoryForm").find("input").val("");
        $("#newCategory").before(
            '<div class="col-category">' +
                '<div class="panel panel-default">' +
                    '<div class="panel-heading">' +
                        response.category.title + '' +
                    '</div>' +
                    '<div class="panel-drag panel-body"></div>' +
                    '<div class="panel-footer">' +
                        '<form class="taskForm" data-project-id="' + response.category.project_id + '" data-category-id="' + response.category.id + '">' +
                            '<div class="form-group">' +
                                '<div class="form-group">' +
                                    '<input type="text" class="form-control" id="taskTitle" placeholder="Titre" name="title">' +
                                '</div>' +
                            '</div>' +
                        '</form>' +
                    '</div>' +
                '</div>' +
            '</div>'
        )
    });
});

$(".taskForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["task_store"],
        data: {
            project_id: $(this).data('project-id'),
            category_id: $(this).data('category-id'),
            title: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $(".taskForm[data-category-id=" + response.task.category_id + "]").find("input").val("");
        $(".col-category[data-category-id=" + response.task.category_id + "]").find(".categoryTasks").append(
            '<div class="panel panel-default">' +
                '<div class="panel-body">' +
                    response.task.title +
                '</div>' +
            '</div>'
        )
    });
});