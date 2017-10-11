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
                                    <a href="#">
                                        {{ $project->title }}
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
