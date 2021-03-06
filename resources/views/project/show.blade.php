@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="panel-heading">{{ $project->title }}
                <small>{{ $project->description }}</small>
                @if(in_array($userId, json_decode($project->admin)))
                    <a class="btn btn-primary" href="{{ route('projects.users.index', $project->id) }}">Utilisateurs</a>
                @endif
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
                        <div class="panel-drag panel-body categoryTasks" data-category-id="{{ $category->id }}">
                            @foreach($category->tasks() as $task)
                                <div class="panel panel-default" data-task-id="{{ $task->id }}" data-order="{{ $task->order }}" data-row-position="{{
                                $task->order }}">
                                    <div class="panel-body">
                                        {{ $task->title }}
                                @if(in_array($userId, json_decode($project->admin)))
                                        <button data-toggle="modal" data-target="#myModal{{ $task->id }}"><i class="fa fa-pencil"
                                                                                                                                  aria-hidden="true"></i></button>
                                        <button class="deleteTask" data-task-id="{{ $task->id }}" data-order="{{ $task->order }}"><i class="fa fa-close" aria-hidden="true"></i></button>
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
                                            <form class="taskUpdate" data-task-id="{{ $task->id }}">
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
                                @else
                                    </div>
                                </div>
                                @endif
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

            @if(in_array($userId, json_decode($project->admin)))
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
            @endif
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
            task_order_update: "{{ route('tasks.updateOrder') }}"
        }
    </script>
    <script src="{{ asset('js/projects/show.js') }}"></script>
@endsection