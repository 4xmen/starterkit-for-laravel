<?php
use Illuminate\Support\Facades\Route;

Route::prefix(config('starter-kit.uri'))->name('admin.')->group(
    function () {
//        Route::get('/', 'HomeController@index')->name('home');
//        Route::get('calendar/{y}/{m}', 'HomeController@index')->name('home.nav');
        Route::group(
            ['middleware' => ['auth', 'role:super-admin']],
            function () {
                Route::get('ckeditor', 'Admin\CkeditorController@index');
                Route::get('tagsearch/{query}', 'Admin\CkeditorController@tagsearch')->name('ckeditor.tagsearch');
                Route::get('newssearch/{query}', 'Admin\CkeditorController@newssearch')->name('ckeditor.newssearch');
                Route::post('ckeditor/upload', 'Admin\CkeditorController@upload')->name('ckeditor.upload');

                Route::prefix('users')->name('user.')->group(
                    function () {
                        Route::get('/all', 'Admin\UserController@index')->name('all');
                        Route::get('/delete/{user}', 'Admin\UserController@destroy')->name('delete');
                        Route::get('/create', 'Admin\UserController@create')->name('create');
                        Route::post('/store', 'Admin\UserController@store')->name('store');
                        Route::get('/edit/{user}', 'Admin\UserController@edit')->name('edit');
                        Route::post('/update/{user}', 'Admin\UserController@update')->name('update');
                    });

                Route::prefix('category')->name('category.')->group(
                    function () {
                        Route::get('index', "Admin\CategoryController@index")->name('index');
                        Route::get('create', "Admin\CategoryController@create")->name('create');
                        Route::post('store', "Admin\CategoryController@store")->name('store');
                        Route::get('edit/{cat}', "Admin\CategoryController@edit")->name('edit');
                        Route::get('show/{cat}', "Admin\CategoryController@show")->name('show');
                        Route::post('update/{cat}', "Admin\CategoryController@update")->name('update');
                        Route::get('delete/{cat}', "Admin\CategoryController@destroy")->name('delete');
                        Route::get('sort', "Admin\CategoryController@sort")->name('sort');
                        Route::post('sortStore', "Admin\CategoryController@sortStore")->name('sortStore');
                        Route::post('bulk', "Admin\CategoryController@bulk")->name('bulk');
                    }
                );
                Route::prefix('news')->name('news.')->group(
                    function () {
                        Route::get('index', "Admin\NewsController@index")->name('index');
                        Route::get('create', "Admin\NewsController@create")->name('create');
                        Route::post('store', "Admin\NewsController@store")->name('store');
                        Route::get('edit/{news}', "Admin\NewsController@edit")->name('edit');
                        Route::get('show/{news}', "Admin\NewsController@show")->name('show');
                        Route::post('update/{news}', "Admin\NewsController@update")->name('update');
                        Route::get('delete/{news}', "Admin\NewsController@destroy")->name('delete');
                        Route::post('bulk', "Admin\NewsController@bulk")->name('bulk');
                    }
                );

                Route::prefix('gallery')->name('gallery.')->group(
                    function () {
                        Route::get('index', "Admin\GalleryController@index")->name('all');
                        Route::get('create', "Admin\GalleryController@create")->name('create');
                        Route::post('store', "Admin\GalleryController@store")->name('store');
                        Route::get('edit/{gallery}', "Admin\GalleryController@edit")->name('edit');
                        Route::get('show/{gallery}', "Admin\GalleryController@show")->name('show');
                        Route::post('update/{gallery}', "Admin\GalleryController@update")->name('update');
                        Route::get('delete/{gallery}', "Admin\GalleryController@destroy")->name('delete');
                        Route::post('bulk', "Admin\GalleryController@bulk")->name('bulk');
                    }
                );

                Route::prefix('poll')->name('poll.')->group(
                    function () {
                        Route::get('index', "Admin\PollController@index")->name('index');
                        Route::get('create', "Admin\PollController@create")->name('create');
                        Route::post('store', "Admin\PollController@store")->name('store');
                        Route::get('edit/{poll}', "Admin\PollController@edit")->name('edit');
                        Route::get('show/{poll}', "Admin\PollController@show")->name('show');
                        Route::post('update/{poll}', "Admin\PollController@update")->name('update');
                        Route::get('delete/{poll}', "Admin\PollController@destroy")->name('delete');
                        Route::post('bulk', "Admin\PollController@bulk")->name('bulk');
                    }
                );
                Route::prefix('clip')->name('clip.')->group(
                    function () {
                        Route::get('index', "Admin\ClipController@index")->name('index');
                        Route::get('create', "Admin\ClipController@create")->name('create');
                        Route::post('store', "Admin\ClipController@store")->name('store');
                        Route::get('edit/{clip}', "Admin\ClipController@edit")->name('edit');
                        Route::get('show/{clip}', "Admin\ClipController@show")->name('show');
                        Route::post('update/{clip}', "Admin\ClipController@update")->name('update');
                        Route::get('delete/{clip}', "Admin\ClipController@destroy")->name('delete');
                        Route::post('bulk', "Admin\ClipController@bulk")->name('bulk');
                    }
                );
                Route::prefix('slider')->name('slider.')->group(
                    function () {
                        Route::get('index', "Admin\SliderController@index")->name('index');
                        Route::get('create', "Admin\SliderController@create")->name('create');
                        Route::post('store', "Admin\SliderController@store")->name('store');
                        Route::get('edit/{slider}', "Admin\SliderController@edit")->name('edit');
                        Route::get('show/{slider}', "Admin\SliderController@show")->name('show');
                        Route::post('update/{slider}', "Admin\SliderController@update")->name('update');
                        Route::get('delete/{slider}', "Admin\SliderController@destroy")->name('delete');
                        Route::post('bulk', "Admin\SliderController@bulk")->name('bulk');
                    }
                );
                Route::prefix('adv')->name('adv.')->group(
                    function () {
                        Route::get('index', "Admin\AdvController@index")->name('index');
                        Route::get('create', "Admin\AdvController@create")->name('create');
                        Route::post('store', "Admin\AdvController@store")->name('store');
                        Route::get('edit/{adv}', "Admin\AdvController@edit")->name('edit');
                        Route::get('show/{adv}', "Admin\AdvController@show")->name('show');
                        Route::post('update/{adv}', "Admin\AdvController@update")->name('update');
                        Route::get('delete/{adv}', "Admin\AdvController@destroy")->name('delete');
                        Route::post('bulk', "Admin\AdvController@bulk")->name('bulk');
                    }
                );

                Route::prefix('image')->name('image.')->group(
                    function () {
                        Route::get('index', "Admin\ImageController@index")->name('all');
                        Route::post('store/{gallery}', "Admin\ImageController@store")->name('store');
                        Route::get('delete/{image}', "Admin\ImageController@destroy")->name('delete');
                        Route::post('bulk', "Admin\ImageController@bulk")->name('bulk');
                    }
                );

                Route::prefix('menu')->name('menu.')->group(
                    function () {
                        Route::get('index', "Admin\MenuController@index")->name('index');
                        Route::post('store', "Admin\MenuController@store")->name('store');
                        Route::get('manage/{menu}', "Admin\MenuController@edit")->name('manage');
                        Route::post('update/{menu}', "Admin\MenuController@update")->name('update');
                        Route::get('show/{menu}', "Admin\MenuController@show")->name('show');
                        Route::get('delete/{menu}', "Admin\MenuController@destroy")->name('delete');
                    }
                );


                Route::prefix('comment')->name('comment.')->group(
                    function () {
                        Route::get('/', "Admin\CommentController@index")->name('index');
                        Route::get('edit/{comment}', "Admin\CommentController@edit")->name('edit');
                        Route::post('update/{comment}', "Admin\CommentController@update")->name('update');
                        Route::get('delete/{comment}', "Admin\CommentController@destroy")->name('delete');
                        Route::get('status/{comment}/{status}', "Admin\CommentController@status")->name('status');
                        Route::post('bulk', "Admin\CommentController@bulk")->name('bulk');
                    }
                );

                Route::prefix('logs')->name('logs.')->group(
                    function () {
                        Route::get('/', "Admin\LogController@index")->name('index');
                        Route::get('/user/{user}', "Admin\LogController@user")->name('user');
                    }
                );
            });
    });
