<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('zeus-sky.path'))
    ->middleware(config('zeus-sky.middleware'))
    ->group(function () {
        Route::get('/', \LaraZeus\Sky\Http\Livewire\Posts::class)->name('blogs');
        Route::get('/{post:slug}', \LaraZeus\Sky\Http\Livewire\Post::class)->name('post');
        Route::get('page/{slug}', \LaraZeus\Sky\Http\Livewire\Page::class)->name('page');
        Route::get('{type}/{slug}', \LaraZeus\Sky\Http\Livewire\Tags::class)->name('tags');

        Route::get('passConf', function () {
            session()->put(request('postID') . '-' . request('password'), request('password'));

            return redirect()->back()->with('status', 'sorry, password incorrect!');
        });
    });
