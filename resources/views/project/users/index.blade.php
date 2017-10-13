@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="panel-heading">{{ $project->title }}
                <small>{{ $project->description }}</small>
                <a class="btn btn-primary" href="{{ route('projects.show', $project->id) }}">Retour</a>
            </h1>
        </div>
    </div>

    <div class="container" id="container-users">
        <div class="panel panel-default">
            <div class="panel-heading">
                Administrateurs
            </div>
            <div class="panel-body">
                @foreach($admins as $admin)
                    {{ $admin->name }}
                @endforeach
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Spectateurs
            </div>
            <div class="panel-body">
                @foreach($viewers as $viewer)
                    {{ $viewer->name }}
                @endforeach
            </div>
        </div>
    </div>
@endsection