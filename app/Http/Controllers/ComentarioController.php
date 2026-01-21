<?php

namespace App\Http\Controllers;

use App\Models\Clima;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, Clima $clima)
    {
        $request->validate([
            'contenido' => 'required|min:3|max:500',
        ]);

        $clima->comentarios()->create([
            'contenido' => $request->contenido,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Comentario agregado correctamente');
    }

    public function update(Request $request, Comentario $comentario)
    {
        $request->validate([
            'contenido' => 'required|string|max:500',
        ]);

        $comentario->update([
            'contenido' => $request->contenido,
        ]);

        return back()->with('success', 'Comentario actualizado correctamente.');
    }

    public function destroy(Comentario $comentario)
    {
        $comentario->delete();

        return back()->with('success', 'Comentario eliminado correctamente.');
    }
}