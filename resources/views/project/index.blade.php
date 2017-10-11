@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Projets</div>

                    <div class="panel-body">

                        @foreach($projects as $project)
                            <ul>
                                <li>
                                    <a href="{{ route('projects.show', $project->id) }}">
                                        {{ $project->title }}
                                    </a>
                                    <a href="{{ route('projects.destroy', $project->id) }}" style="float: right; color: red;">
                                        X
                                    </a>
                                </li>
                            </ul>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
