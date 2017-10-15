@extends('layouts.app')

@section('content')
    <div id="global" class="project-edit">
        <div class="container">
            <h1 class="text-center"><i class="fa fa-user" aria-hidden="true"></i> Créer un projet</h1>

            <div id="global-projects" class="row">

                <div class="panel-project col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ route('projects.store') }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="projectTitre">Titre</label>
                            <input type="text" class="form-control" id="projectTitre" placeholder="Titre" name="title">
                        </div>
                        <div class="form-group">
                            <label for="projectDescription">Description</label>
                            <textarea id="projectDescription" class="form-control" rows="3" name="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Valider</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
