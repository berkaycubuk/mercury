<?php

use Illuminate\Support\Facades\Route;

/**
 * Frontpage routes
 */

Route::get("blog", "Blog@index")
    ->name("store.blog.index");
Route::get("blog/{slug}", "Blog@post")
    ->name("store.blog.post");

/**
 * Panel routes
 */
Route::group(["prefix" => "panel"], function () {
    Route::get("blog", "Posts@index")
        ->middleware("user.panel")
        ->name("panel.blog.posts.index");
    Route::get("blog/yeni", "Posts@create")
        ->middleware("user.panel")
        ->name("panel.blog.posts.create");
    Route::post("blog/store", "Posts@store")
        ->middleware("user.panel")
        ->name("panel.blog.posts.store");
    Route::post("blog/update", "Posts@update")
        ->middleware("user.panel")
        ->name("panel.blog.posts.update");
    Route::post("blog/delete", "Posts@delete")
        ->middleware("user.panel")
        ->name("panel.blog.posts.delete");
    Route::get("blog/kategoriler", "PostCategories@index")
        ->middleware("user.panel")
        ->name("panel.blog.categories.index");
    Route::get("blog/kategoriler/yeni", "PostCategories@create")
        ->middleware("user.panel")
        ->name("panel.blog.categories.create");
    Route::post("blog/kategoriler/store", "PostCategories@store")
        ->middleware("user.panel")
        ->name("panel.blog.categories.store");
    Route::post("blog/kategoriler/update", "PostCategories@update")
        ->middleware("user.panel")
        ->name("panel.blog.categories.update");
    Route::get("blog/kategoriler/{id}", "PostCategories@edit")
        ->middleware("user.panel")
        ->name("panel.blog.categories.edit");
    Route::get("blog/kategoriler/delete/{id}", "PostCategories@delete")
        ->middleware("user.panel")
        ->name("panel.blog.categories.delete");
    Route::get("blog/etiketler", "PostTags@index")
        ->middleware("user.panel")
        ->name("panel.blog.tags.index");
    Route::get("blog/etiketler/yeni", "PostTags@create")
        ->middleware("user.panel")
        ->name("panel.blog.tags.create");
    Route::post("blog/etiketler/store", "PostTags@store")
        ->middleware("user.panel")
        ->name("panel.blog.tags.store");
    Route::post("blog/etiketler/update", "PostTags@update")
        ->middleware("user.panel")
        ->name("panel.blog.tags.update");
    Route::get("blog/etiketler/{id}", "PostTags@edit")
        ->middleware("user.panel")
        ->name("panel.blog.tags.edit");
    Route::get("blog/etiketler/delete/{id}", "PostTags@delete")
        ->middleware("user.panel")
        ->name("panel.blog.tags.delete");
    Route::get("blog/{id}", "Posts@edit")
        ->middleware("user.panel")
        ->name("panel.blog.posts.edit");
});
