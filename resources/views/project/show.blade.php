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
                <div class="col-category">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $category->title }}
                        </div>
                        <div class="panel-body">
                            @foreach($category->tasks() as $task)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ $task->title }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="panel-footer">
                            <form class="newTask" data-project-id="{{ $project->id }}" data-category-id="{{ $category->id }}">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="taskTitre" placeholder="Titre"
                                               name="title">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="projectDescription" class="form-control" rows="3" name="description" placeholder="Description"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default">Valider</button>
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
                                <input type="text" class="form-control" id="categoryTitle" placeholder="Titre"
                                       name="title">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
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

