<?php

namespace Tests\Feature;

use App\Author;
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

        $response = $this->post('/books', $this->data());

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

        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function book_can_be_updated()
    {
        //$this->withoutExceptionHandling();//to see real error !!!

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function book_can_be_deleted()
    {
        $this->withoutExceptionHandling();//to see real error !!!

        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

     /** @test */
    public function new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Title',
            'author_id' => 'Victor',
        ]);

        $book = Book::first();
        $author = Author::first();

        //dd($book->author_id);

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor',
        ];
    }
}
