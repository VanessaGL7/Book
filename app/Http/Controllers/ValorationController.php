<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValorationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_book' => 'required|integer|exists:books,id',
            'valoration' => 'required|integer|min:1|max:5',
            'commentary' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($data['id_book']);

        // Verificar si el usuario ya ha valorado el libro
        if ($user->valorations()->where('id_book', $book->id)->exists()) {
            return response()->json('You have already rated this book', 400);
        }

        // Crear nueva valoración
        $valoration = new Valoration;
        $valoration->id_user = $user->id;
        $valoration->id_book = $book->id;
        $valoration->valoration = $data['valoration'];
        $valoration->commentary = $data['commentary'];
        $valoration->save();

        return response()->json('Book valoration saved');
    }

    /**
     * Update a book valoration.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valoration = Valoration::findOrFail($id);

        // Validar que el usuario sea el dueño de la valoración
        if ($valoration->id_user !== Auth::user()->id) {
            return response()->json('You are not the owner of this valoration', 403);
        }

        $data = $request->validate([
            'valoration' => 'required|integer|min:1|max:5',
            'commentary' => 'required|string|max:255',
        ]);

        $valoration->valoration = $data['valoration'];
        $valoration->commentary = $data['commentary'];
        $valoration->save();

        return response()->json('Book valoration updated');
    }

    /**
     * Get the book valoration for the current user.
     *
     * @param  int  $bookId
     * @return \Illuminate\Http\Response
     */

     public function show($bookId)
    {
        $user = Auth::user();
        $valoration = $user->valorations()->where('id_book', $bookId)->first();

        if (!$valoration) {
            return response()->json('You have not rated this book yet', 404);
        }

        return response()->json($valoration);
    }
    public function destroy($id)
    {
        $valoration = Valoration::findOrFail($id);

        // Validar que el usuario sea el dueño de la valoración
        if ($valoration->id_user !== Auth::user()->id) {
            return response()->json('You are not the owner of this valoration', 403);
        }

        valoration->delete();
        
        return response()->json('Book valoration deleted');
    }
}
