<?php

use Illuminate\Support\Facades\Route;

Route::post('/books', 'BooksController@store');
Route::patch('/books/{book}', 'BooksController@update');
Route::delete('/books/{book}', 'BooksController@destroy');

Route::post('/author', 'AuthorsController@store');

//BookCheckoutTest (Feature)
Route::post('/checkout/{book}', 'CheckoutBookController@store');
Route::post('/checkin/{book}', 'CheckinBookController@store');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
