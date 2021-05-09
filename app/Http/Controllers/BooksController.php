<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        $book = Book::create($this->validateRequest());
        return redirect($book->path());
    }


    public function update(Book $book)
    {
        $book->update($this->validateRequest());

        return redirect($book->path());
        // stel je gebruikt een slug in je path
        // return redirect($book->fresh()->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    private function validateRequest()
    {
        $data = request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);

        return $data;
    }
}
