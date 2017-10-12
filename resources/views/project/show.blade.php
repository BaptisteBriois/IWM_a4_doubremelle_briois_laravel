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
                        <div class="panel-body">
                            {{ $category->title }}
                            <hr>
                            @foreach($category->tasks() as $task)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ $task->title }}
                                    </div>
                                </div>
                            @endforeach
                            <form action="{{ route('tasks.store') }}" method="post">

                                {{ csrf_field() }}

                                <div class="form-group">
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="taskTitre" placeholder="Titre"
                                               name="title">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="projectDescription" class="form-control" rows="3"
                                                  name="description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-category">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ route('categories.store') }}" method="post">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">

                                <input type="text" class="form-control" id="categoryTitre" placeholder="Titre"
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
        $(function () {
            var count = $('.col-category').length;
            var size = 270 * count;
            $('#container-tasks').css('width', size);
            console.log(count);
        });
    </script>
@endsection

