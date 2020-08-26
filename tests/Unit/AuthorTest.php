<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_name_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'John Doe',
        ]);

        //$author = Author::first();

        $this->assertCount(1, Author::all());
        //$this->assertEquals(null, $author->dob);
    }
}
