<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Category;

use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('task.index', ['tasks'=>$tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::categories();
        return view('task.create', compact('categories'));
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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'completed'   => 'nullable|boolean',
            'due_date'    => 'nullable|date',
            'category_id' => 'required|exists:categories,id'
        ],
        [],
        ['category_id' => 'Category']); //si une erreur se produit sur le champ 'category_id', le message d'erreur doit le référencer comme 'Category'.

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'completed'   => $request->input('completed', false),
            'due_date'    => $request->due_date,
            'user_id'     => Auth::user()->id,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('task.show', $task->id)->with('success', 'Task created successfully.');
    }

    //////////////////////////////////////////////////
    public function storeClient(Request $request)
    {
        // Complétez le code
        $request->validate([
            'name'     => 'required|string|min:2|max:25',
            'address'  => 'required|string|max:100',
            'city_id'  => 'required|numeric|exists:App\Models\Ville,id',
            'email'    => 'required|email',
            'phone'    => 'required|regex:/^\(\d{3}\)\s\d{3}-\d{4}$/',
            'birthday' => 'required|date:d-m-Y',
        ]);

        $client = Client::create([
            'name'     => $request->name,
            'address'  => $request->address,
            'city_id'  => $request->city_id,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'birthday' => $request->birthday,
        ]);

        return redirect()->route('client', $client->id)->with('success', 'Client créé avec succès.');
    }


    /////////////////////////////////////////////////

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', ['task'=>$task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'completed'   => 'nullable|boolean',
            'due_date'    => 'nullable|date'
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'completed'   => $request->input('completed', false),
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('task.show', $task->id)->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete-task');
        
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }

    /******************************** */
    public function completed($completed){
        $tasks = Task::where('completed', $completed)->get();
        return view('task.index', ["tasks" => $tasks]);
    }

    /******************************** */
    public function query(){
        //select * from tasks;
        //return l'obj tableau bidimens
        //$task = Task::all();

        $task = Task::select()->get();

        //$task[0];

        //select * from tasks limit 1;
        //return l'obj tableau unidimens
        $task = Task::select()->first();

        //select 'title', 'description' from tasks
        $task = Task::select('title', 'description')->get();

        //select * from tasks where id = ?;
        $task = Task::select()
                    ->where('id', 1)
                    ->get();

        $task[0]->title;   
        
        $task = Task::select()
        ->where('id', 1)
        ->first();
        $task->title;

         //select * from tasks where id = ?;
        $task = Task::find(1);

        $task = Task::select()
        ->where('completed', 1)
        ->get();

        $task = Task::select()
        ->where('user_id', '!=', 1)
        ->get();

        
         //select * from tasks where title like 'task%';
        $task = Task::select()
        ->where('title', 'like', 'task%')
        ->orderby('description', 'DESC')
        ->get();

        //AND
         //select * from tasks where title = 'task 1' and user_id = 1;

         $task = Task::select()
         ->where('title', '=', 'task 1')
         ->where('user_id', 1)
         ->get();
       

        //OR
        //select * from tasks where title = 'task 1' and user_id = 2;

        $task = Task::select()
        ->where('title', '=', 'task 1')
        ->orwhere('user_id', 2)
        ->get();
       

       //insert into tasks (title, description) values ('task abc', 'task description abc');
       //return select * from where lastinsertedid
       //Ex.:1
       //$task = Task::create(['title' => 'task abc', 
       //                       'description' => 'task description abc']);

       //Ex.:2
    //    $task = new Task;
    //    $task->title = 'New task 8';
    //    $task->description = 'New description 8';
    //    $task->user_id = 1;
    //    $task->save();
        
        // update tasks set title = 'task abcd' where id = 1;
        //return select * from where id = 1;
        //ex 1.:
        // $task = Task::find(1);
       //$task->update(['title' => 'task abcde']);

       //ex 2.:
    //    $task->title = 'New task';
    //    $task->description = 'New description';
    //    $task->save();

        // delete from tasks  where id = 1;
        // return true /false
        // $task = Task::find(1);
        // $task->delete();



        // $user = User::create([]);

        // $task = Task::create(['user_id' = $user->id]);

        //count
        //select count(*) from tasks;
        $task = Task::count();
        //select count(*) from  tasks where completed = 1;

        $task = Task::where('completed', 1)->count();

        $task = Task::max('user_id');
        $task = Task::min('user_id');
        $task = Task::avg('user_id');
        $task = Task::sum('user_id');


        // JOIN

        // SELECT * FROM tasks INNER JOIN users on users.id = tasks.user_id


        $task = Task::select()
                ->join('users', 'users.id','=', 'user_id')
                ->where('user_id', 1)
                ->orderBy('title')
                ->get();

       //OUTER JOIN
       //SELECT * FROM tasks RIGHT OUTER JOIN users on users.id = tasks.user_id
        $task = Task::select()
            ->rightjoin('users', 'users.id','=', 'user_id')
            ->orderBy('user_id')
            ->get();


       // Raw Query / requete brute

        //SELECT count(*) as count_tasks, user_id FROM tasks GROUP BY user_id;



        $task = Task::select(DB::raw('count(*) as count_tasks'), 'user_id')
        ->groupBy('user_id')
        ->get();

        return $task;



    }

    // public function pdf(Task $task){
    //     $pdf = new Dompdf();
    //     $pdf->setPaper('letter', 'portrait');
    //     $pdf->loadHtml(view('task.show-pdf', ["task" => $task]));
    //     $pdf->render();
    //     return $pdf->stream('task.pdf');
    // }

    public function pdf(Task $task){
        $qrCode = QrCode::size(200)->generate(route('task.show', $task->id));
        $pdf = new Dompdf();
        $pdf->setPaper('letter', 'portrait');
        $pdf->loadHtml(view('task.show-pdf', ["task" => $task, "qrCode"=> $qrCode]));
        $pdf->render();
        return $pdf->stream('task.pdf');
    }
}
