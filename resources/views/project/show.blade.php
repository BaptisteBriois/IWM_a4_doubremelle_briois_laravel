@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="panel-heading">{{ $project->title }}
                <small>{{ $project->description }}</small>
            </h1>
        </div>
    </div>

    <div id="container-categories">
        <div id="container-tasks">
            @foreach($categories as $category)
                <div class="col-category" data-category-id="{{ $category->id }}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $category->title }}
                        </div>
                        <div class="panel-drag panel-body categoryTasks">
                            @foreach($category->tasks() as $task)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ $task->title }}
                                        <button style="float: right" data-toggle="modal"
                                                data-target="#myModal{{ $task->id }}">Edit
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal{{ $task->id }}" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                            </div>
                                            <form class="taskForm" data-project-id="{{ $project->id }}" data-category-id="{{ $category->id }}">
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="taskTitle">Titre</label>
                                                        <input id="taskTitle" type="text" class="form-control"
                                                               placeholder="Titre" value="{{ $task->title }}"
                                                               name="title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="taskDescription">Description</label>
                                                        <textarea id="taskDescription" class="form-control" rows="3" name="description">{{ $project->description }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="taskLimitDate">Échéance</label>
                                                        <input id="taskLimitDate" type="text" class="datepicker form-control"
                                                               placeholder="Titre" value="{{ $task->limit_date }}"
                                                               name="title">
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Valider</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                        <div class="panel-footer">
                            <form class="taskForm" data-project-id="{{ $project->id }}"
                                  data-category-id="{{ $category->id }}">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Titre" name="title">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <div id="newCategory" class="col-category">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="categoryForm" data-project-id="{{ $project->id }}">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Titre" name="title">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')

    <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        Routes = {
            category_store: "{{ route('categories.store') }}",
            task_store: "{{ route('tasks.store') }}"
        }
    </script>
    <script src="{{ asset('js/show.js') }}"></script>
@endsection

