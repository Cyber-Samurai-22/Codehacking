<div class="col-md-4">
    <!-- Blog Search Well -->
    <form action="{{ route('search') }}" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Search posts...">
        <button type="submit">Search</button>
    </form>

    <!-- /.input-group -->
    </div>
    <!-- Blog Categories Well -->
{{--    <div class="well">--}}
{{--        <h4>Blog Categories</h4>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-6">--}}
{{--                <ul class="list-unstyled">--}}
{{--                    @if($categories)--}}
{{--                        @foreach($categories as $category )--}}
{{--                            <li><a href="#">{{$category->name}}</a>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- /.row -->
    </div>
</div>

