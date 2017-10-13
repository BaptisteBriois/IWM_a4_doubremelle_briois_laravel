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
                <div id="col-category-{{ $category->id }}" class="col-category">
                    <div class="panel-category panel panel-default">
                        <div class="panel-heading">
                            {{ $category->title }}
                        </div>
                        <div class="panel-drag panel-body categoryTasks">
                            @foreach($category->tasks() as $task)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ $task->title }}
                                        <button style="float: right" data-toggle="modal" data-target="#myModal{{ $task->id }}">Edit</button>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Détails de la tâche</h4>
                                            </div>
                                            <form id="taskDetail{{ $task->id }}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="taskTitle">Tâche</label>
                                                        <input id="taskTitle" type="text" class="form-control" placeholder="Titre" value="{{ $task->title }}" name="title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="taskDescription">Description</label>
                                                        <textarea id="taskDescription" class="form-control" rows="3" name="description">{{ $task->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="taskLimitDate">Échéance</label>
                                                        <input id="taskLimitDate" type="text" class="datepicker form-control" placeholder="Date" value="{{ $task->limit_date }}" name="limit-date">
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
                            <form class="taskForm" data-category-id="{{ $category->id }}">
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
            task_store: "{{ route('tasks.store') }}",
            task_update: "{{ route('tasks.update') }}"
        }
    </script>
    <script src="{{ asset('js/show.js') }}"></script>
@endsection

