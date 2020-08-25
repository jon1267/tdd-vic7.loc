<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $guarded = [];

    public function path()
    {
        //будет ссылка, типа:  /books/1-harry-potter
        //return '/books/' . $this->id . '-' . Str::slug($this->title);
        //тогда в роутах patch&delete (BooksController@) появляется добавка -{slug}
        //для простоты убираем ...

        return '/books/' . $this->id;
    }
}
