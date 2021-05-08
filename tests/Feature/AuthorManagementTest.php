<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $this->post('/author', [
            'name' => 'author name',
            'dob' => '02/21/1961',
        ]);
        $author = Author::all();
        // dd($author);
        $this->assertCount(1, $author);
        // check of er wel echt een datum terugkomt
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        // check of een andere format ook gebruikt kan worden (parse)
        $this->assertEquals('1961/02/21', $author->first()->dob->format('Y/m/d'));
    }
}
