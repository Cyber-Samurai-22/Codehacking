@extends('layouts.admin')

@section('content')

    @if(Session::has('deleted_post'))
        <div class="alert alert-danger">{{session('deleted_post')}} </div>

    @elseif(Session::has('updated_post'))
        <div class="alert alert-success">{{session('updated_post')}} </div>

    @elseif(Session::has('created_post'))
        <div class="alert alert-success">{{session('created_post')}} </div>

    @endif

    <h1>Posts</h1>

    <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Owner</th>
            <th>Category</th>
            <th>Title</th>
            <th>Body</th>
            <th>Created</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
          <tr>
            <td>{{$post->id}}</td>
            <td><img height="50" src="{{$post->photo ? $post->photo->file : 'http:/placehold.it/400x400'}}" alt=""></td>
            <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->user->name}}</a></td>
            <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
            <td>{{$post->title}}</td>
            <td>{{Str::limit($post->body, 7)}}</td>
            <td>{{$post->created_at->diffForHumans()}}</td>
            <td>{{$post->updated_at->diffForHumans()}}</td>
          </tr>
            @endforeach
        @endif
        </tbody>
      </table>

@endsection
