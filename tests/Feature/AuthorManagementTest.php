<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function author_can_be_created()
    {
        //$this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Author name',
            'dob'  => '1988-05-14'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('14.05.1988', $author->first()->dob->format('d.m.Y'));
        //$this->assertEquals('Author name', $author->first()->name);
    }
}
