@extends('layouts.blog-home')

@section('content')

    <div class="row">
        <div class="col-md-8">



    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{ $post->title }}</h1>

    <!-- Author -->
    <p class="lead">
        by {{ $post->user->name }}
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{ $post->created_at->diffForhumans() }}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" style="width: 100%" src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/900x300' }}" alt="">

    <hr>
    <div style="background-color: rgb(245, 242, 238); padding: 3%; border-radius:2%">
        <!-- Post Content -->
        <p class="lead">{!! $post->body !!}</p>
    </div>
    <hr>


    <!-- Blog Comments -->

    @if (Auth::check())

        <!-- Comments Form -->
        <div class="well">
            {{-- <h4>Leave a Comment:</h4>
            <form role="form">
                <div class="form-group">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> --}}

            {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\PostCommentsController@store']) !!}

            <input type="hidden" name="post_id" id="" value="{{ $post->id }}">

            <div class="form-group">
                {!! Form::label('body', 'Body:') !!}
                {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'required' => true]) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Comment', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        </div>

        <hr>

    @endif

    <!-- Posted Comments -->

    @if (count($comments) > 0)

        @foreach ($comments as $comment)

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" width="64px" height="64px" src="{{ $comment->photo ? $comment->photo :  "http://placehold.it/64x64" }}"  alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{ $comment->author }}
                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </h4>
                    <p>{{ $comment->body }}</p>

                    @if (count($comment->replies) > 0)

                        @foreach ($comment->replies as $reply )

                            @if ($reply->is_active == 0)

                                <!-- Nested Comment -->
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img class="media-object" width="44px" height="44px" src="{{ $reply->photo ? $reply->photo :  "http://placehold.it/64x64" }}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ $reply->author }}
                                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                                        </h4>
                                        <p>{{ $reply->body }}</p>
                                    </div>

                                    @if (Auth::check())

                                        <div class="comment-reply-container">

                                            <button class="toggle-reply btn btn-primary pull-right">Reply</button>

                                            <div class="comment-reply col-sm-12" style="display: none; padding-top:1%">

                                                {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\CommentRepliesController@createReply']) !!}

                                                <input type="hidden" name='comment_id' value="{{ $comment->id }}">

                                                <div class="form-group">
                                                    {!! Form::label('body', "Body:") !!}
                                                    {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::submit('Reply', ['class' => 'btn btn-primary']) !!}
                                                </div>
                                                {!! Form::close() !!}

                                            </div>
                                        </div>
                                        <!-- End Nested Comment -->
                                    @endif
                                </div>

                            @endif

                        @endforeach

                    @else
                        @if (Auth::check())
                            <div class="comment-reply-container">

                                <button class="toggle-reply btn btn-primary pull-right">Reply</button>

                                <div class="comment-reply col-sm-12" style="display: none; padding-top:1%">

                                    {!! Form::open(['method' => 'POST', 'action' => 'App\Http\Controllers\CommentRepliesController@createReply']) !!}

                                    <input type="hidden" name='comment_id' value="{{ $comment->id }}">

                                    <div class="form-group">
                                        {!! Form::label('body', "Body:") !!}
                                        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::submit('Reply', ['class' => 'btn btn-primary']) !!}
                                    </div>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        @endif

                    @endif
                </div>
            </div>
        @endforeach

    @endif

    </div> <!--COL-MD-8-->

        @include('includes.front_sidebar')

    </div> <!--ROW-->


    <!-- end blog comments-->

@endsection



@section('scripts')

    <script>
        $(".comment-reply-container .toggle-reply").click(function(){
            $(this).next().slideToggle('slow');
        })
    </script>

@endsection
