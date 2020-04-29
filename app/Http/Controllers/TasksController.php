<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        
        
    }
    
    
    public function create()
    {
        $task= new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
   
}
   
public function store(Request $request)
    {
        $task = new Task;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }
    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        return view('tasks.show', [
            'task' => $task,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $task = Task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

   public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }
   
   public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect('/');
    }
   
   
   
   
   
   
   
   
    

    
}
