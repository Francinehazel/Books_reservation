<?php

namespace App\Http\Controllers;
use App\Models\Book;    

use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        // Fetch books from the inventory system's API
        $response = Http::get('http://127.0.0.1:8001/api/books');

        if ($response->successful()) {
            $books = $response->json(); // Get the books as an array
            return view('student.library', compact('books'));
        }

        return abort(500, 'Failed to fetch books from inventory system.');
    }
}

