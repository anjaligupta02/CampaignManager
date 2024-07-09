<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\UserController;

// Campaign routes
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');

// User routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/search', [UserController::class, 'searchByEmail'])->name('users.searchByEmail');
Route::get('/campaigns/search', [CampaignController::class, 'search']);


