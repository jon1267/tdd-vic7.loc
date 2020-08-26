<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $guarded = [];

    public function path()
    {
        //если оставить код стр. ниже, будет ссылка, типа:  /books/1-harry-potter
        //return '/books/' . $this->id . '-' . Str::slug($this->title);
        //тогда в роутах patch&delete (BooksController@) появляется добавка -{slug}
        //для простоты убираем ...

        return '/books/' . $this->id;
    }

    public function checkout($user)
    {
        // вместо модели Reservation::create()
        // берем связь $book->reservation()
        $this->reservations()->create([
            // book_id ???
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin($user)
    {
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (is_null($reservation)) {
            throw new \Exception();
        }

        $reservation->update([
            'checked_in_at' => now(),
        ]);
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author,
        ]))->id;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
