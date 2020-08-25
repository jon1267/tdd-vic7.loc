<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookTest extends TestCase
{
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
}
