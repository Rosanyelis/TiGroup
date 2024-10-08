<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Models\TodoListUsers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTaskRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('todo_lists')
                ->select('todo_lists.id', 'todo_lists.task', 'todo_lists.fecha_inicio', 'todo_lists.fecha_fin', 'todo_lists.status',
                    DB::raw("GROUP_CONCAT(users.name SEPARATOR ', ') AS asignados"))
                ->leftjoin('todo_list_users', 'todo_lists.id', '=', 'todo_list_users.todo_list_id')
                ->join('users', 'todo_list_users.user_id', '=', 'users.id')
                ->groupBy('todo_lists.id', 'todo_lists.task', 'todo_lists.status');

            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('todolist.partials.actions', ['id' => $data->id]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('todolist.index');
    }

    /**
     * Show the form for creating a new resource.
     *     */
    public function create()
    {
        $users = User::all();
        return view('todolist.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $task = TodoList::create([
            'user_id' => auth()->user()->id,
            'task' => $request->task,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        foreach ($request->members as $member) {
            TodoListUsers::create([
                'todo_list_id' => $task->id,
                'user_id' => $member
            ]);
        }

        return redirect()->route('task.index')->with('success', 'Tarea creada con exito');

    }

    /**
     * Display the specified resource.
     */
    public function changeStatus(Request $request)
    {
        if ($request->status == 1) {
            $status = '0';
        }

        if ($request->status == 0) {
            $status = '1';
        }
        $todo = TodoList::find($request->id);
        $todo->update(['status' => $status]);

        return response()->json(['message' => 'Tarea actualizada correctamente', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $todo = TodoList::find($request->id);
        TodoListUsers::where('todo_list_id', $todo->id)->delete();
        $todo->delete();
        return response()->json(['message' => 'Tarea eliminada correctamente', 'status' => 'success']);
    }
}
