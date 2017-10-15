@extends('layouts.app')

@section('content')
    <div id="global">
        <div class="container">
            <h1><i class="fa fa-user" aria-hidden="true"></i> Tableaux personnels</h1>

            <div id="global-projects" class="row">

                @foreach($projects as $project)
                    <div class="col-md-3 col-sm-4">
                        <div class="panel-project">
                            <a href="{{ route('projects.show', $project->id) }}">
                                {{ $project->title }}
                            </a>
                            <div class="panel-project-options">
                                <a href="{{ route('projects.edit', $project->id) }}">
                                    <button class="project-edit" type="submit"><i class="fa fa-pencil"
                                                                                  aria-hidden="true"></i></button>
                                </a>
                                <form action="{{ route('projects.destroy', $project->id ) }}" method="post">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="project-remove" type="submit"><i class="fa fa-close"
                                                                                    aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="col-md-3 col-sm-4">
                    <a href="{{ route('projects.create') }}">
                        <div class="panel-project panel-project-create">
                            Créer un tableau...
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
