<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy("created_at","DESC")->get();

        return response()->json(['tasks'=>$tasks],200);
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
        $request->validate([
            "title"=>['required'],
            "description"=>['required']
        ]);

        $task = Task::create($request->only("title","description"));

        $tasks = Task::orderBy("created_at","DESC")->get();

        return response()->json(['tasks'=>$tasks],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task)
    {
      
        $task = Task::find($task);

        $task->update($request->only("title","description"));

        $tasks = Task::orderBy("created_at","DESC")->get();

        return response()->json(['tasks'=>$tasks],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($task)
    {
       $task = Task::find($task);

        $task->delete();

        $tasks = Task::orderBy("created_at","DESC")->get();

         return response()->json(['tasks'=>$tasks],200);
    }
}
