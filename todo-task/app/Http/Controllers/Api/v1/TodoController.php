<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return Todo::all();
    }

    public function store(Request $request)
    {
        $title = $request->get('title');
        $desc = $request->get('desc');
        $status = $request->get('status');
        $parentId = $request->get('parent_id');

        $todo = Todo::query()->create([
            'title' => $title,
            'desc'  => $desc,
            'status' => $status,
            'parent_id' => $parentId
        ]);

        return $todo;
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update([
            'title' => $request->get('title'),
            'desc' => $request->get('desc'),
            'status' => $request->get('status'),
            'parent_id' => $request->get('parent_id'),
        ]);

        return $todo;
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return $todo;
    }

}
