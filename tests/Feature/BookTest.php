<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();//to see real error !!!

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function title_is_required()
    {
        //$this->withoutExceptionHandling();//to see real error !!!

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function author_is_required()
    {
        //$this->withoutExceptionHandling();//to see real error !!!

        $response = $this->post('/books', [
            'title' => 'Cool Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function book_can_be_updated()
    {
        $this->withoutExceptionHandling();//to see real error !!!

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
