@extends('layouts.blog-home')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $post->title }}
            </h1>
            <p class="lead">
                by {{ $post->user->name }}
            </p>
            <hr>
            <p>
      <span class="glyphicon glyphicon-time">
      </span> Posted {{ $post->created_at->diffForhumans() }}
            </p>
            <hr>
            <!-- Preview Image -->
            <img class="img-responsive" style="width: 100%" src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/900x300' }}" alt="">
            <hr>
            <div style="background-color: rgb(245, 242, 238); padding: 3%; border-radius:2%">
                <!-- Post Content -->
                <p class="lead">{!! $post->body !!}
                </p>
            </div>
            <hr>
            <!-- Blog Comments -->
            @if(Auth::check())
                <!-- Comments Form -->
                <div class="well">
                    <form action="{{action('App\Http\Controllers\PostCommentsController@store')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <div class="form-group">
                            <label for="body">Comment</label>
                            <textarea name="body" rows="5" class="form-control" required>{{ old('body') }}</textarea>
                            @if($errors->has('body'))
                                <p class="text-danger">{{ $errors->first('body') }}</p>
                            @elseif($errors->has('comment_error'))
                                <p class="text-danger">{{ $errors->first('comment_error') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" name="btn_leave_comment">Comment</button>
                        </div>
                    </form>
                </div>
            @endif
            <hr>
            <!-- Posted Comments -->
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img style="height: 64px;" class="media-object" src="{{$comment->photo ? $comment->photo : '/images/default/default.jpg'}}" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{$comment->author}}
                                <small>{{$comment->created_at->diffForHumans()}}
                                </small>
                            </h4>
                            {{$comment->body}}
                            @if(!empty($comment->replies))
                                @foreach($comment->replies as $reply)
                                    @if($reply->is_active == 1)
                                        <!-- Nested Comment -->
                                        @if($errors->has("replies-{$reply->id}-body"))
                                            <p class="text-danger">{{ $errors->first("replies-{$reply->id}-body") }}</p>
                                        @endif
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object" height="40px" src="{{$reply->photo}}" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$reply->author}}
                                                    <small>{{$reply->created_at->diffForHumans()}}
                                                    </small>
                                                </h4>
                                                <p>{{$reply->body}}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="comment-reply-container">
                            <div class="comment-reply">
                                <br>
                                <form action="{{ route('comment.create-reply', $comment)}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="reply_body">Reply</label>
                                        <textarea name="reply_body" rows="2" class="form-control" required></textarea>
                                    </div>
                                    <button class="btn btn-primary" name="btn_create_reply">Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @endsection
            @section('scripts')
                <script>
                    $(document).ready(function() {
                            $(".comment-reply-container .toggle-reply").click(function() {
                                    $(this).next().slideToggle("slow");
                                }
                            );
                        }
                    );
                </script>
@stop
