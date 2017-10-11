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
                                    <form action="{{ route('projects.destroy', $project->id ) }}" method="post" style="float: right; color: red;">
                                        {{ csrf_field() }}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit">X</button>
                                    </form>
                                    <a href="{{ route('projects.edit', $project->id) }}" style="float: right; color: blue;margin-right: 10px">
                                        <button type="submit">Editer</button>
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
