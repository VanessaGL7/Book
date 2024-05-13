<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Store a new favorite book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_book' => 'required|integer|exists:books,id',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($data['id_book']);

        // Verificar si el libro ya está en favoritos
        if ($user->favorites()->where('id_book', $book->id)->exists()) {
            return response()->json('Book already in favorites', 400);
        }

        // Agregar libro a favoritos
        $favorite = new Favorite;
        $favorite->id_user = $user->id;
        $favorite->id_book = $book->id;
        $favorite->save();

        return response()->json('Book added to favorites');
    }

    /**
     * Remove a favorite book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return response()->json('Book removed from favorites');
    }

    /**
     * Get all favorite books for the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $books = $user->favorites()->with('author', 'gender')->get();

        return response()->json($books);
    }

    public function getUserFavorites($userId)
    {
        $user = User::findOrFail($userId);
        $books = $user->favorites()->with('author', 'gender')->get();

        return response()->json($books);
    }
}
