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
                        <div class="panel-heading">{{ $category->title }}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
