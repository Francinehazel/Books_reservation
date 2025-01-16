<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LibraryController extends Controller
{
    public function index()
    {
        // Fetch books from the external Laravel project
        $response = Http::get('http://external-project.local/api/books'); // Update with the correct API URL
        
        if ($response->successful()) {
            $books = $response->json(); // Assuming the API returns a JSON array
        } else {
            $books = []; // Fallback if the API call fails
        }

        return view('student.library', compact('books'));
    }
}
