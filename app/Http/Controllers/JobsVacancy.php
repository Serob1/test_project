<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\JobVacancy;

class JobsVacancy extends Controller
{
    public function index()
    {
        return view('jobs');
    }
    
    public function get(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }
    
    public function store(Request $request)
    {
        $post = Post::create($request->all());
    
        return response()->json($post);
    }

    public function save()
    {
        $product = new JobVacancy([
            'title' => "ddd",
            'description' => "sdd",
            'user_id' => "5"
        ]);
        $product->save();
    }

    public function delete($id)
    {
        $delete = JobVacancy::findOrFail($id);

        $delete->delete();
    }
}
