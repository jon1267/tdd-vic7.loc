<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function book_can_be_added_to_the_library()
    {
        // $this->withoutExceptionHandling();//to see real error !!!

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        //$response->assertOk(); // return status code 200; but redirect: 302
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
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
        //$this->withoutExceptionHandling();//to see real error !!!

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function book_can_be_deleted()
    {
        $this->withoutExceptionHandling();//to see real error !!!

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
