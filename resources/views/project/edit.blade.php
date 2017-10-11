@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Modifier</div>

                    <div class="panel-body">

                        <form method="POST" action="{{ route('projects.update', $project->id) }}">

                            <input name="_method" type="hidden" value="PUT">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="projectTitre">Titre</label>
                                <input type="text" class="form-control" id="projectTitre" placeholder="Titre" name="title" value="{{ $project->title }}">
                            </div>
                            <div class="form-group">
                                <label for="projectDescription">Description</label>
                                <textarea id="projectDescription" class="form-control" rows="3" name="description">{{ $project->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-default">Valider</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
