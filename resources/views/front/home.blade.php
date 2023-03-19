@extends('layouts.blog-home')
@section('content')
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- First Blog Post -->
            @if($posts)
                @foreach($posts as $post)
                    <h2><a href="/post/{{$post->slug}}">{{$post->title}}</a></h2>
            <p class="lead">by {{$post->user->name}}</p>
            <img height="300" src="{{$post->photo ? $post->photo->file : 'http:/placehold.it/400x400'}}" alt="">
            <p><span class="glyphicon glyphicon-time"></span> {{$post->created_at->diffForHumans()}}</p>
            <p>{{Str::limit($post->body, 100)}}</p>
            <a class="btn btn-primary" href="/post/{{$post->slug}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                @endforeach
            @endif
            <!-- Pagination -->
            <div class="row"></div>
            <div class="col-sm-6 col-sm-offset-5">{{$posts->render()}}</div>
        </div>
        <!-- Blog Sidebar -->
        @include('includes.front_sidebar')
    </div>
    <!-- /.row -->
</div>
@endsection
