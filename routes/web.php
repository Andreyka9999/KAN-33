<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubdomainDiscoveryController;

// On a GET request to /subdomains, the showForm method of the SubdomainDiscoveryController is called, which should return 
// a view with a form to enter the URL.
// When a POST request is sent to /subdomains, the discover method of the SubdomainDiscoveryController is called, which processes the entered URL, 
// searches for subdomains and returns the results.
Route::get('/subdomains', [SubdomainDiscoveryController::class, 'showForm'])->name('subdomains.form');
Route::post('/subdomains', [SubdomainDiscoveryController::class, 'discover'])->name('subdomains.discover');
