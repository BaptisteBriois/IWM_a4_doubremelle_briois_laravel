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
            <div id="adminList" class="panel-body">
                <ul>
                    @foreach($admins as $admin)
                        <li>
                            {{ $admin->name }}
                            <form class="removeUser" data-project-id="{{ $project->id }}">
                                <input type="hidden" name="user_id" class="user_id" value="{{ $admin->id }}">
                                <input type="hidden" name="user_role" class="user_role" value="admin">
                                <button type="submit"><i class="fa fa-close" aria-hidden="true"></i></button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-footer">
                <form id="adminForm" data-project-id="{{ $project->id }}">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Administarteur" name="admin">
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Spectateurs
            </div>
            <div id="viewerList" class="panel-body">
                <ul>
                    @foreach($viewers as $viewer)
                        <li>
                            {{ $viewer->name }}
                            <form class="removeUser" data-project-id="{{ $project->id }}">
                                <input type="hidden" name="user_id" class="user_id" value="{{ $viewer->id }}">
                                <input type="hidden" name="user_role" class="user_role" value="viewer">
                                <button type="submit"><i class="fa fa-close" aria-hidden="true"></i></button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-footer">
                <form id="viewerForm" data-project-id="{{ $project->id }}">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Spectateur" name="viewer">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        Routes = {
            add_admin: "{{ route('projects.users.addAdmin', $project->id) }}",
            add_viewer: "{{ route('projects.users.addViewer', $project->id) }}",
            remove_user: "{{ route('projects.users.removeUser', $project->id) }}"
        }
    </script>
    <script src="{{ asset('js/projects/users/index.js') }}"></script>
@endsection