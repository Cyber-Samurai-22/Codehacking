<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        if (!$searchTerm) {
            return redirect()->back();
        }

        $posts = Post::query()
            ->with('photo')
            ->where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('body', 'LIKE', "%{$searchTerm}%")
            ->get();

        return view('search_results', compact('posts'));
    }
}
