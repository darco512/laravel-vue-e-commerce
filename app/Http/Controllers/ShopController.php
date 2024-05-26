<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Shop/Shop', []);
    }

    public function product(Request $request): Response
    {
        return Inertia::render('Shop/Description', []);
    }
}
