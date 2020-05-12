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
        //ログインしていればその人のタスク一覧を表示する
        
       /* $tasks = Task::all();
        
         if (\Auth::check()) {
             $user = \Auth::user();
            return view('tasks.index', [
            'tasks' => $tasks,]);*/
            
           $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        
        
        return view('tasks.index', $data);
    } 
            
        
        
        return redirect('/login');//ログインしていなければログインページにリダイレクトする
    }  
        
    



    public function create()
    {
        $task= new Task;
        if (\Auth::check()) {
             $user = \Auth::user();
       
        return view('tasks.create', [
            'task' => $task,
        ]);
       return redirect('/login');
}

}
   
public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
            
            
        ]);
        
        
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = $request->user()->id;
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
        $tasks = Task::find($id);
        if (\Auth::id() === $tasks->user_id) {
        return view('tasks.show', [
            'tasks' => $tasks,
        ]);
        return redirect('/login');
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
         $task = Task::find($id);
          if (\Auth::id() === $task->user_id) {  
             
        
        return view('tasks.edit', [
            'task' => $task,
        ]);
       
            $task->edit();
        }

        return redirect('/login');
        
    }

   public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
          ]); 
        $task = Task::find($id);
        $task->status = $request->status; 
        $task->content = $request->content;
        $task->save();

        if (\Auth::id() === $task->user_id) {
            $task->update();
        }

        return redirect('/');


       
    }
   
   public function destroy($id)
    {
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        return redirect('/login');
    }
   
   
   
   
   
   
   
   
    

    
}
