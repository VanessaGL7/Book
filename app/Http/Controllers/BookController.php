<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Gender;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('author', 'gender')->get();

        return response()->json($books);
    }

    /**
     * Store a new book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'id_author' => 'nullable|integer|exists:authors,id',
            'id_gender' => 'nullable|integer|exists:genders,id',
            'chapter' => 'required|array',
            'chapter.*.title' => 'required|string',
            'chapter.*.content' => 'required|string',
        ]);

        $book = Book::create($data);

        // Guardar autor si es necesario
        if ($data['id_author']) {
            $book->author()->sync($data['id_author']);
        }

        // Guardar género si es necesario
        if ($data['id_gender']) {
            $book->gender()->sync($data['id_gender']);
        }

        // Guardar capítulos
        foreach ($data['chapter'] as $chapterData) {
            $chapter = new Chapter($chapterData);
            $book->chapter()->save($chapter);
        }

        return response()->json($book, 201);
    }

    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with('author', 'gender', 'chapter')->findOrFail($id);

        return response()->json($book);
    }

    /**
     * Update the specified book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'id_author' => 'nullable|integer|exists:authors,id',
            'id_gender' => 'nullable|integer|exists:genders,id',
            'chapter' => 'required|array',
            'chapter.*.id' => 'nullable|integer|exists:chapter,id',
            'chapter.*.title' => 'required|string',
            'chapter.*.content' => 'required|string',
        ]);

        // Actualizar libro
        $book->update($data);

        // Sincronizar autor si es necesario
        if ($data['id_author']) {
            $book->author()->sync($data['id_author']);
        }

        // Sincronizar género si es necesario
        if ($data['id_gender']) {
            $book->gender()->sync($data['id_gender']);
        }

        // Actualizar o crear capítulos
        foreach ($data['chapter'] as $chapterData) {
            if ($chapterData['id_chapter']) {
                $chapter = Chapter::findOrFail($chapterData['id_chapter']);
            } else {
                $chapter = new Chapter;
            }

            $chapter->update($chapterData);
            $book->chapter()->save($chapter);
        }

        return response()->json($book);
    }

    /**
     * Remove the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return response()->json('Book deleted');
    }
}
