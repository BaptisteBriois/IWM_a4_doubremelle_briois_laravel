var container = $('.panel-drag').toArray();
var drake = dragula(container);

drake.on('drop', function (el, target) {
    category_id = $(target).data('category-id');
    task_id = $(el).data('task-id');
});

var nodeListForEach = function (array, callback, scope) {
    for (var i = 0; i < array.length; i++) {
        callback.call(scope, i, array[i]);
    }
};

drake.on('dragend', function (el) {
    elParent = $(el).parent();
    rows = $(elParent).find('.panel');

    nodeListForEach(rows, function (index, row) {
        row.lastElementChild.textContent = index + 1;
        row.dataset.rowPosition = index + 1;
    })
});


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
            '<div id="col-category-' + response.category.id + '" class="col-category">' +
                '<div class="panel-category panel panel-default">' +
                    '<div class="panel-heading">' +
                        response.category.title + '' +
                    '</div>' +
                    '<div class="panel-drag panel-body categoryTasks"></div>' +
                    '<div class="panel-footer">' +
                        '<form class="taskForm" data-category-id="' + response.category.id + '">' +
                            '<div class="form-group">' +
                                '<input type="text" class="form-control" placeholder="Titre" name="title">' +
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
            category_id: $(this).data('category-id'),
            title: $(this).find("input").val()
        },
        dataType: "json"
    }).done(function (response, status, jqXHR) {
        $(".taskForm[data-category-id=" + response.task.category_id + "]").find("input").val("");
        $("#col-category-" + response.task.category_id).find(".categoryTasks").append(
            '<div class="panel panel-default">' +
                '<div class="panel-body">' +
                    response.task.title +
                    '<button style="float: right" data-toggle="modal" data-target="#myModal' + response.task.id + '">Edit</button>' +
                '</div>' +
            '</div>' +
            '<div class="modal fade" id="myModal' + response.task.id + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' +
                '<div class="modal-dialog" role="document">' +
                    '<div class="modal-content">' +
                        '<div class="modal-header">' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                                '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '<h4 class="modal-title" id="myModalLabel">Détails de la tâche</h4>' +
                        '</div>' +
                        '<form class="taskForm" data-project-id="' + response.task.project_id + '" data-category-id="' + response.task.category_id + '">' +
                            '<div class="modal-body">' +
                                '<div class="form-group">' +
                                    '<label for="taskTitle">Tâche</label>' +
                                    '<input id="taskTitle" type="text" class="form-control" placeholder="Titre" value="' + response.task.title + '" name="title">' +
                                '</div>' +
                                '<div class="form-group">' +
                                    '<label for="taskDescription">Description</label>' +
                                    '<textarea id="taskDescription" class="form-control" rows="3" name="description">' + response.task.description + '</textarea>' +
                                '</div>' +
                                '<div class="form-group">' +
                                    '<label for="taskLimitDate">Échéance</label>' +
                                    '<input id="taskLimitDate" type="text" class="datepicker form-control" placeholder="Titre" value="' + response.task.limit_date + '" name="limit-date">' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>' +
                                '<button type="submit" class="btn btn-primary">Valider</button>' +
                            '</div>' +
                        '</form>' +
                    '</div>' +
                '</div>' +
            '</div>'
        )
    });
});