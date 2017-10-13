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

        if (in_array($userId, json_decode($project->admin)) || in_array($userId, json_decode($project->viewer))) {
            return view('project.show', compact('project', 'categories', 'userId'));
        } else {
            return "Vous n'avez pas les droits pour voir ce projet";
        }
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
}
