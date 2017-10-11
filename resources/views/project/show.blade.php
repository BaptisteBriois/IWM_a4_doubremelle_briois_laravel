@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $project->title }}</div>

                    <div class="panel-body">


                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        {{ $category->title }}
                    </div>
                </div>
            @endforeach

            <div class="col-md-4">
                <div class="panel panel-default">
                    <form action="{{ route('categories.create') }}" method="post">
                        <div class="form-group">
                            <input type="hidden" name="project-id" value="{{ $project->id }}">

                            <label for="categoryTitre">Titre</label>
                            <input type="text" class="form-control" id="categoryTitre" placeholder="Titre" name="title">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
