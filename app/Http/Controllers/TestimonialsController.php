<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonialsController extends Controller
{

public function index()
{
    $testimonios = Testimonio::orderBy('created_at', 'desc')->get();

    return view('testimonials.index', compact('testimonios'));
}

}