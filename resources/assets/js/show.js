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
                    '<div class="panel-body">\n' +
                        response.category.title + '\n' +
                        '<hr>\n' +
                        '<form class="taskForm" data-project-id="' + response.category.project_id + '" data-category-id="' + response.category.id + '">\n' +
                            '<div class="form-group">\n' +
                                '<div class="form-group">\n' +
                                    '<input type="text" class="form-control" id="taskTitre" placeholder="Titre" name="title">\n' +
                                '</div>\n' +
                                '<div class="form-group">\n' +
                                    '<textarea id="projectDescription" class="form-control" rows="3" name="description" placeholder="Description"></textarea>\n' +
                                '</div>\n' +
                                '<button type="submit" class="btn btn-default">Valider</button>\n' +
                            '</div>\n' +
                        '</form>\n' +
                    '</div>\n' +
                '</div>\n' +
            '</div>'
        )
    });
});