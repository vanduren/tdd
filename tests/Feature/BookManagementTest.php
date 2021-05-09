<?php

namespace Tests\Feature;

use App\Models\Author;
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
        $this->withoutExceptionHandling();
        $response = $this->post('/books', $this->data());

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
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        // $this->withoutExceptionHandling();
        // current
        $this->post('/books', $this->data());

        // get that book
        $book = Book::first();
        // then update
        $response = $this->patch('/books/' . $book->id, [
            'title' => 'new title',
            'author_id' => 'new author',
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect(('/books/' . $book->id));
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();
        // current
        $this->post('/books', $this->data());

        // get that book
        $book = Book::first();
        // check that there is a 1
        $this->assertCount(1, Book::all());
        // then delete
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();
        // dd($book->author_id);

        $this->assertEquals($author->id, $book->author_id);

        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'cool book title',
            'author_id' => 'joan',
        ];
    }
}
