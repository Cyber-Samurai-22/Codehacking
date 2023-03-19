<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsCreateRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->all();
        $user = Auth::user();
        if($file = $request->file('photo_id')){
           $name = time() . $file->getClientOriginalName();
           $file->move('images', $name);
           $photo = Photo::create(['file'=>$name]);
           $input['photo_id'] = $photo->id;
        }
    $user->posts()->create($input);

        Session::flash('created_post', 'The post has been created');

        return redirect('/admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        $post = Auth::user()->posts()->find($id);

        if (!$post) {
            return redirect()->back()->withErrors(['Post not found']);
        }

        // Remove the 'photo_id' field from the $input array if it's not set
        if (!isset($input['photo_id'])) {
            unset($input['photo_id']);
        }

        $post->update($input);

        Session::flash('updated_post', 'The post has been updated');

        return redirect('/admin/posts');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    private function getLocalFilePath($url)
    {
        $publicUrl = asset('/', true);
        $relativePath = str_replace($publicUrl, '', $url);
        return str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->photo && $post->photo->file) {
            $filePath = public_path() . $this->getLocalFilePath($post->photo->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            } else {
                error_log("File not found: " . $filePath);
            }
        }
        $post->delete();

        Session::flash('deleted_post', 'The post has been deleted');
        return redirect('/admin/posts');
    }


    public function post($slug)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        $categories = Category::all();
        $comments = $post->comments()->whereIsActive(1)->get();
        return view('post', compact('post', 'comments', 'categories'));
    }
}
