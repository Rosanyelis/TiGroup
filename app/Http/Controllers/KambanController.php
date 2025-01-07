<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Kamban;
use App\Models\BoardItem;
use App\Models\WorkSpace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BoardItemFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreKambanRequest;
use App\Http\Requests\UpdateKambanRequest;

class KambanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WorkSpace::find(1);
        return view('kamban.index', compact('data'));
    }

    public function kambanJson()
    {
        $data = WorkSpace::with('boards', 'boards.items', 'boards.items.user')->find(1);

        $boards = [];

        foreach ($data->boards as $board) {
            // Crear la estructura del board
            $boardData = [
                'id' => $board->title_slug,
                'title' => $board->title,
                'item' => []
            ];

            // Agregar los ítems relacionados
            foreach ($board->items as $item) {
                $boardData['item'][] = [
                    'id'            => $item->id,
                    'title'         => $item->title,
                    'project_title' => $item->project_title,
                    'phone'         => $item->phone,
                    'email'         => $item->email,
                    'notes'         => $item->notes,
                    'priority'      => $item->priority,
                    'badge-text'    => $item->badge_text,
                    'badge'         => $item->badge,
                    'created_at'    => $item->created_at,
                    'user'          => $item->user->name,
                    'photo_user'    => $item->user->photo,
                    'attachments'   => $item->files->count(),
                    'comments'      => $item->comments->count()
                ];
            }

            $boards[] = $boardData;
        }
        return response()->json($boards);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('kamban.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkSpaceRequest $request)
    {
        $workspace = WorkSpace::create([
            'client_id' => $request->client_id,
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('gestiones.index')->with('success', 'Espacio de Trabajo creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($workSpace)
    {
        $data = WorkSpace::with('boards', 'user', 'client')->find($workSpace);
        return view('kamban.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($workSpace)
    {
        $clients = Clientes::all();
        $data = WorkSpace::find($workSpace);
        return view('kamban.edit', compact('clients', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkSpaceRequest $request, $workSpace)
    {
        $workspace = WorkSpace::find($workSpace);
        $workspace->update($request->all());
        return redirect()->route('gestiones.index')->with('success', 'Espacio de Trabajo actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($workSpace)
    {
        $workspace = WorkSpace::find($workSpace);
        $workspace->boards()->delete();
        $workspace->delete();
        return redirect()->route('gestiones.index')->with('success', 'Espacio de Trabajo eliminado exitosamente');
    }

    public function storeboard(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required'
            ], [
                'title.required' => 'El título de tablero es requerido',
            ]);
            $board = Board::create([
                'workspace_id' => '1',
                'title' => $validated['title'],
                'title_slug' => Str::slug($validated['title'], '-'),
            ]);
            return redirect()->back()->with('success', 'Tablero creado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function renameboard(Request $request)
    {
        try {
            $board = Board::where('title_slug', $request->titleboardid)->first();
            $board->title = $request->title;
            $board->title_slug = Str::slug($request->title, '-');
            $board->save();
            return redirect()->back()->with('success', 'Tablero renombrado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeitem(Request $request)
    {
        try {
            $validated = $request->validate([
                'board_id' => 'required',
                'title' => 'required',
                'project_title' => 'required',
                'phone' => 'required',
                'email' => 'required',
            ], [
                'board_id.required' => 'El board es requerido',
                'title.required' => 'El Cliente es requerido',
                'project_title.required' => 'El Proyecto es requerido',
                'phone.required' => 'El Teléfono es requerido',
                'email.required' => 'El Correo es requerido',
            ]);

            $board = Board::where('title_slug', $validated['board_id'])->first();

            $task = BoardItem::create([
                'board_id' => $board->id,
                'user_id' => Auth::user()->id,
                'title' => $validated['title'],
                'project_title' => $request->project_title,
                'phone' => $request->phone,
                'email' => $request->email,
                'notes' => $request->notes,
                'priority' => $request->priority,
                'badge_text' => $request->priority,
                'badge' => $this->verifyPriority($request->priority),
            ]);

            # validar que la variable de archivos tenga valor
            $archivos = isset($request->attachments) ? $request->attachments : null;
            $url = null;
            if ($archivos != null) {
                foreach ($archivos as $file) {
                    $uploadPath = public_path('/storage/');
                    $extension = $file->getClientOriginalExtension();
                    $uuid = Str::uuid(4);
                    $fileName = $uuid . '.' . $extension;
                    $file->move($uploadPath, $fileName);
                    $url = '/storage/'.$fileName;

                    BoardItemFile::create([
                        'board_item_id' => $task->id,
                        'file' => $url,
                        'filename' => $file->getClientOriginalName()
                    ]);
                }
            }


            return redirect()->back()->with('success', 'Tarea creada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showitem($id)
    {
        try {
            $task = BoardItem::find($id);
            $files = BoardItemFile::where('board_item_id', $task->id)->get();

            return response()->json(['task' => $task, 'files' => $files]);
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()]);
        }
    }
    public function updateitem(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required'
            ]);

            $task = BoardItem::find($request->board_id);
            $task->title = $validated['title'];
            $task->project_title = $request->project_title;
            $task->phone = $request->phone;
            $task->email = $request->email;
            $task->notes = $request->notes;
            $task->priority = $request->priority;
            $task->badge_text = $request->priority;
            $task->badge = $this->verifyPriority($request->priority);
            $task->save();

            # validar que la variable de archivos tenga valor
            $archivos = isset($request->attachments) ? $request->attachments : null;
            $url = null;
            if ($archivos != null) {
                foreach ($archivos as $file) {
                    $uploadPath = public_path('/storage/');
                    $extension = $file->getClientOriginalExtension();
                    $uuid = Str::uuid(4);
                    $fileName = $uuid . '.' . $extension;
                    $file->move($uploadPath, $fileName);
                    $url = '/storage/'.$fileName;

                    BoardItemFile::create([
                        'board_item_id' => $task->id,
                        'file' => $url,
                        'filename' => $file->getClientOriginalName()
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Tarea actualizada correctamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function verifyPriority($priority)
    {
        if ($priority == 'Alta') {
            return 'danger';
        } elseif ($priority == 'Media') {
            return 'warning';
        } elseif ($priority == 'Baja') {
            return 'primary';
        } else {
            return 'info';
        }
    }
    public function deleteitem($id)
    {
        try
        {
            $task = BoardItem::find($id);
            $task->delete();

            return redirect()->back()->with('success', 'Tarea eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function moveitem(Request $request)
    {
        try {
            $board = Board::where('title_slug', $request->new_board_id)->first();
            $task = BoardItem::find($request->task_id);
            $task->board_id = $board->id;
            $task->save();

            return response()->json(['success' => 'Tarea movida correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error', $e->getMessage()]);
        }
    }

    public function deleteboard(Request $request)
    {
        try
        {
            $board = Board::where('title_slug', $request->board)->first();
            $board->items()->delete();
            $board->delete();

            return redirect()->back()->with('success', 'Board eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
