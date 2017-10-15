<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $allProjects = Project::all();

        $projects = [];
        foreach ($allProjects as $project) {
            if (in_array($userId, json_decode($project->admin)) || in_array($userId, json_decode($project->viewer))) {
                array_push($projects, $project);
            }
        }

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'admin' => json_encode([Auth::user()->id]),
            'viewer' => json_encode([]),
            'user' => '',
        ]);

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $categories = $project->categories();
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin)) && !in_array($userId, json_decode($project->viewer))) {
            return "Vous n'avez pas les droits pour voir ce projet";
        }

        return view('project.show', compact('project', 'categories', 'userId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour mettre à jour ce projet";
        }

        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour mettre à jour ce projet";
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->save();

        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour supprimer ce projet";
        }

        $project->delete();

        return redirect()->route('projects.index');
    }

    /**
     * Get users for a specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProjectUsers($id)
    {
        $project = Project::find($id);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour voir les utilisateurs de ce projet";
        }

        $admins = json_decode($project->admin);
        $adminUsers = [];
        foreach ($admins as $admin) {
            $user = User::find($admin);
            array_push($adminUsers, $user);
        }

        $viewers = json_decode($project->viewer);
        $viewerUsers = [];
        if ($project->viewer) {
            foreach ($viewers as $viewer) {
                $user = User::find($viewer);
                array_push($viewerUsers, $user);
            }
        }

        $data = [
            'project' => $project,
            'admins' => $adminUsers,
            'viewers' => $viewerUsers
        ];

        return view('project.users.index', $data);
    }

    /**
     * Add a new project admin.
     *
     * @param  Request $request, int  $id
     * @return \Illuminate\Http\Response
     */
    public function addProjectAdmin(Request $request, $id)
    {
        $project = Project::find($id);
        $projectAdmin = json_decode($project->admin);
        $projectViewer = json_decode($project->viewer);

        if ($user = User::where('email', $request->email)->first()) {
            if (!in_array($user->id, json_decode($project->admin))) {
                array_push($projectAdmin, $user->id);
                $project->admin = json_encode($projectAdmin);
                if (in_array($user->id, json_decode($project->viewer))) {
                    $key = array_search($user->id, $projectViewer);
                    unset($projectViewer[$key]);
                    $project->viewer = json_encode($projectViewer);
                }
                if ($project->save()) {
                    return response()->json(['success' => 'true', 'user' => $user]);
                } else {
                    return response()->json(['success' => 'false']);
                }
            } else {
                return "Cet utilisateur est déjà administrateur du projet";
            }

        } else {
            return "Un mail d'invitation sur notre plateforme a été envoyé à l'utilisateur";
        }
    }

    /**
     * Add a new project viewer.
     *
     * @param  Request $request, int  $id
     * @return \Illuminate\Http\Response
     */
    public function addProjectViewer(Request $request, $id)
    {
        $project = Project::find($id);
        $projectViewer = json_decode($project->viewer);

        if ($user = User::where('email', $request->email)->first()) {
            if (!in_array($user->id, json_decode($project->admin))) {
                if (!in_array($user->id, json_decode($project->viewer))) {
                    array_push($projectViewer, $user->id);
                    $project->viewer = json_encode($projectViewer);
                    if ($project->save()) {
                        return response()->json(['success' => 'true', 'user' => $user]);
                    } else {
                        return response()->json(['success' => 'false']);
                    }
                } else {
                    return "Cet utilisateur est déjà spectateur du projet";
                }
            } else {
                return "Cet utilisateur est déjà administrateur du projet";
            }
        } else {
            return "Un mail d'invitation sur notre plateforme a été envoyé à l'utilisateur";
        }
    }
}
