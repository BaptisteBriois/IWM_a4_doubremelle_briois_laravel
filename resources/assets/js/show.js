dragula($('.panel-drag').toArray());

$("#categoryForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: Routes["category_store"],
        data: {
            project_id: $(this).data('project-id'),
            title: $("#categoryTitle").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $("#categoryTitle").val("");
        $("#newCategory").before(
            '<div class="col-category">\n' +
                '<div class="panel panel-default">\n' +
                    '<div class="panel-heading">\n' +
                        response.category.title + '\n' +
                    '</div>\n' +
                    '<div class="panel-drag panel-body"></div>\n' +
                    '<div class="panel-footer">\n' +
                        '<form class="taskForm" data-project-id="' + response.category.project_id + '" data-category-id="' + response.category.id + '">\n' +
                            '<div class="form-group">\n' +
                                '<div class="form-group">\n' +
                                    '<input type="text" class="form-control" id="taskTitle" placeholder="Titre" name="title">\n' +
                                '</div>\n' +
                            '</div>\n' +
                        '</form>\n' +
                    '</div>\n' +
                '</div>\n' +
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
            category_id: $(this).data('category_id'),
            title: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {

    });
});