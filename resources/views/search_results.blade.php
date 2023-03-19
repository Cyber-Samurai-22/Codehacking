@extends('layouts.app')

@section('content')
    <h1>Search Results: </h1>

    @if($posts->count())
        <ul>
            @foreach($posts as $post)
                <div class="search-result">
                    @if($post->photo)
                        <img src="{{ $post->photo->file }}" alt="{{ $post->title }}" style="width: 100px; height: auto; margin-right: 10px;">
                    @endif
                    <h5 style="display: inline-block;"><a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a></h5>
                    <p>{{ Str::limit($post->content, 150) }}</p>
                </div>
            @endforeach
        </ul>
    @else
        <p>No results found for "{{ request('query') }}"</p>
    @endif
@endsection
