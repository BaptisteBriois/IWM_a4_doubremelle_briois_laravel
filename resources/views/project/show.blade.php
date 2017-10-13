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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="panel-footer">
                            <form class="taskForm" data-project-id="{{ $project->id }}" data-category-id="{{ $category->id }}">
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

