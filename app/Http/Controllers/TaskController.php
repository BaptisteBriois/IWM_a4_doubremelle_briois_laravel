<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projectId = Category::find($request->category_id)->project_id;
        $project = Project::find($projectId);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour créer une tâche sur ce projet";
        }

        $lastOrder = Task::all()->where('category_id', $request->category_id)->sortByDesc('order')->first();

        $task = Task::create([
            'project_id' => $projectId,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => "",
            'order' => ($lastOrder) ? $lastOrder->order + 1 : 1
        ]);

        if ($task) {
            return response()->json(['success' => 'true', 'task' => $task]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $categoryId = $task->category->id;

        $category_tasks = Task::where('category_id', $categoryId)->where('order', '>', $task->order)->get();
        foreach ($category_tasks as $category_task) {
            $category_task->order -= 1;
            $category_task->save();
        }

        if ($task->delete()) {
            return response()->json(['success' => 'true', 'task_id' => $id]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    /**
     * Update task order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        $projectId = Category::find($request->category_id)->project_id;
        $project = Project::find($projectId);
        $userId = Auth::id();

        if (!in_array($userId, json_decode($project->admin))) {
            return "Vous n'avez pas les droits pour gérer les tâches de ce projet";
        }

        $task = Task::find($request->task_id);
        $category_id = $request->category_id;
        $new_order = $request->new_order;

        if ($task->category_id != $category_id) {
            $new_category_tasks = Task::where('category_id', $category_id)->where('order', '>=', $new_order)->get();
            foreach ($new_category_tasks as $new_category_task) {
                $new_category_task->order += 1;
                $new_category_task->save();
            }
            $old_category_tasks = Task::where('category_id', $task->category_id)->where('order', '>', $task->order)->get();
            foreach ($old_category_tasks as $old_category_task) {
                $old_category_task->order -= 1;
                $old_category_task->save();
            }
        } else {
            if ($task->order < $new_order) {
                $category_tasks = Task::where('category_id', $task->category_id)->where('order', '<=', $new_order)->get();
                foreach ($category_tasks as $category_task) {
                    $category_task->order -= 1;
                    $category_task->save();
                }
            } elseif ($task->order > $new_order) {
                $category_tasks = Task::where('category_id', $task->category_id)->where('order', '<', $new_order)->get();
                foreach ($category_tasks as $category_task) {
                    $category_task->order += 1;
                    $category_task->save();
                }
            }
        }

        $task->order = $new_order;
        if ($task->category_id != $category_id) {
            $task->category_id = $category_id;
        }
        $task->save();
    }
}
