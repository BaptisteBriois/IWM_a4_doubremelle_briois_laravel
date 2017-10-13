/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 41);
/******/ })
/************************************************************************/
/******/ ({

/***/ 41:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(42);


/***/ }),

/***/ 42:
/***/ (function(module, exports) {

dragula($('.panel-drag').toArray());
$('.datepicker').pickadate();

$("#categoryForm").submit(function (e) {
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
        $("#newCategory").before('<div class="col-category">' + '<div class="panel panel-default">' + '<div class="panel-heading">' + response.category.title + '' + '</div>' + '<div class="panel-drag panel-body"></div>' + '<div class="panel-footer">' + '<form class="taskForm" data-project-id="' + response.category.project_id + '" data-category-id="' + response.category.id + '">' + '<div class="form-group">' + '<div class="form-group">' + '<input type="text" class="form-control" id="taskTitle" placeholder="Titre" name="title">' + '</div>' + '</div>' + '</form>' + '</div>' + '</div>' + '</div>');
    });
});

$(".taskForm").submit(function (e) {
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
        $(".col-category[data-category-id=" + response.task.category_id + "]").find(".categoryTasks").append('<div class="panel panel-default">' + '<div class="panel-body">' + response.task.title + '<button style="float: right" data-toggle="modal" data-target="#myModal' + response.task.id + '">Edit</button>' + '</div>' + '</div>' + '<div class="modal fade" id="myModal' + response.task.id + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' + '<div class="modal-dialog" role="document">' + '<div class="modal-content">' + '<div class="modal-header">' + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' + '<span aria-hidden="true">&times;</span>' + '</button>' + '<h4 class="modal-title" id="myModalLabel">Détails de la tâche</h4>' + '</div>' + '<form class="taskForm" data-project-id="' + response.task.project_id + '" data-category-id="' + response.task.category_id + '">' + '<div class="modal-body">' + '<div class="form-group">' + '<label for="taskTitle">Tâche</label>' + '<input id="taskTitle" type="text" class="form-control" placeholder="Titre" value="' + response.task.title + '" name="title">' + '</div>' + '<div class="form-group">' + '<label for="taskDescription">Description</label>' + '<textarea id="taskDescription" class="form-control" rows="3" name="description">' + response.task.description + '</textarea>' + '</div>' + '<div class="form-group">' + '<label for="taskLimitDate">Échéance</label>' + '<input id="taskLimitDate" type="text" class="datepicker form-control" placeholder="Titre" value="' + response.task.limit_date + '" name="limit-date">' + '</div>' + '</div>' + '<div class="modal-footer">' + '<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>' + '<button type="submit" class="btn btn-primary">Valider</button>' + '</div>' + '</form>' + '</div>' + '</div>' + '</div>');
    });
});

/***/ })

/******/ });