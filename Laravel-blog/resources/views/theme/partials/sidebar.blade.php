@php
use App\Models\Category;
use App\Models\Blog;
$i = 0;
$categories = Category::get();
$recentBlogs = Blog::latest()->take(3)->get();
@endphp

<!-- Start Blog Post Siddebar -->
<div class="col-lg-4 sidebar-widgets">
    <div class="widget-wrap">
        <div class="single-sidebar-widget newsletter-widget">
            <h4 class="single-sidebar-widget__title">Newsletter</h4>
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{route('subscriber.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-30">
                    <div class="col-autos">
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="inlineFormInputGroup" placeholder="Enter email" onfocus="this.placeholder = ''"
                            onblur="this.placeholder = 'Enter email'">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="bbtns d-block mt-2 w-100">Subcribe</button>
            </form>
        </div>

        @if(count($categories )> 0)
        <div class="single-sidebar-widget post-category-widget">
            <h4 class="single-sidebar-widget__title">Category</h4>
            <ul class="cat-list mt-20">

                @foreach ($categories as $item )
                <li>
                    <a href="{{ route('theme.category' , ['id'=>$item->id]) }}" class="d-flex justify-content-between">
                        <p>{{ $item->name }}</p>
                        <p>({{ count($item->blogs) }}) </p>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(count($recentBlogs) > 0 )
        <div class="single-sidebar-widget popular-post-widget">
            <h4 class="single-sidebar-widget__title">Recent Post</h4>
            <div class="popular-post-list">

                @foreach ($recentBlogs as $blog )
                <div class="single-post-list">
                    <div class="thumb">
                        <img class="card-img rounded-0" src="{{ asset('storage' ) }}/blogs/{{ $blog->image }}" alt="">
                        <ul class="thumb-info">
                            <li><a href="#">{{ $blog->user->name }}</a></li>
                            <li><a href="#">{{ $blog->created_at->format('d M ') }}</a></li>
                        </ul>
                    </div>
                    <div class="details mt-20">
                        <a href="{{ route('blogs.show' , ['blog'=>$blog]) }}">
                            <h6>{{ $blog->name }}</h6>
                        </a>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
        @endif
    </div>
</div>
<!-- End Blog Post Siddebar -->
