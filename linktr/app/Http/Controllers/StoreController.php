<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($slug)
    {
        $store = Store::with(['links' => fn($q) => $q->orderBy('orden'), 'products' => fn($q) => $q->where('activo', true)])
                      ->where('slug', $slug)
                      ->firstOrFail();

        return view('stores.show', compact('store'));
    }
}

