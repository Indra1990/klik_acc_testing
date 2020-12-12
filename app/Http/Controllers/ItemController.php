<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::all();
        return response()->json([
            'items' => $items
        ]); 
    }

    public function show($id)
    {
        $items = Items::find($id);
        return response()->json([
            'items' => $items
        ]); 
    }
}
