<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard');
    }

    public function products(Request $request): Response
    {
        return Inertia::render('Admin/Products');
    }

    public function add(Request $request): Response
    {
        return Inertia::render('Admin/Product');
    }

    public function no(Request $request): Response
    {
        return Inertia::render('Admin/No');
    }
}
