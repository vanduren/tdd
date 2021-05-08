<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'joan',
        ]);

        $book = Book::first();

        // $response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/' . $book->id);
    }

    /** @test */
    public function a_title_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'joan',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        // $this->withoutExceptionHandling();
        // current
        $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'joan',
        ]);

        // get that book
        $book = Book::first();
        // then update
        $response = $this->patch('/books/' . $book->id, [
            'title' => 'new title',
            'author' => 'new author',
        ]);
        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);
        $response->assertRedirect(('/books/' . $book->id));
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();
        // current
        $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'joan',
        ]);

        // get that book
        $book = Book::first();
        // check that there is a 1
        $this->assertCount(1, Book::all());
        // then delete
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
