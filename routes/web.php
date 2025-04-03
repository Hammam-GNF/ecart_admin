<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'home')->name('home');
Volt::route('/register', 'register')->name('register');
Volt::route('/login', 'login')->name('login');