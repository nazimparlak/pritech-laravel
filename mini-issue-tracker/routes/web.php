<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

// Ana Sayfa - Direkt Projeler Listesine Yönlendirsin
Route::get('/', function () {
    return redirect()->route('projects.index');
});

// Proje ve Issue CRUD İşlemleri (Resource Controllers)
Route::resource('projects', ProjectController::class);
Route::resource('issues', IssueController::class);

// AJAX Odaklı Rotalar (Tag ve Comment İşlemleri)
Route::prefix('api')->name('api.')->group(function () {
    // Etiket Listeleme ve Yeni Etiket Oluşturma
    Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('tags', [TagController::class, 'store'])->name('tags.store');

    // Issue'ya Etiket Ekleme / Çıkarma (Attach/Detach AJAX)
    Route::post('issues/{issue}/tags', [TagController::class, 'toggleTag'])->name('issues.tags.toggle');

    // Issue Detayında Yorumları AJAX ile Çekme ve Ekleme
    Route::get('issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments.index');
    Route::post('issues/{issue}/comments', [CommentController::class, 'store'])->name('issues.comments.store');
});
