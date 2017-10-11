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
                        <div class="panel-body">
                            {{ $category->title }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ route('categories.store') }}" method="post">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">

                                <label for="categoryTitre">Titre</label>
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
