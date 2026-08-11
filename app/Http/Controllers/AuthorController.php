<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::latest()->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Author::create($request->only('name'));
        return back()->with('success', 'Author added');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return back()->with('success', 'Author deleted');
    }
}