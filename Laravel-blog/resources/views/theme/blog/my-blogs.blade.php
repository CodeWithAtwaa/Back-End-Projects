@extends('theme.master')
@section('title' , 'My Blogs')

@section('content')

@include('theme.partials.hero' , ['title'=>Auth::user()->name ])
<!-- ================ contact section start ================= -->
<section class="section-margin--small section-margin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible text-center fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($blogs) > 0 )
                        @foreach ($blogs as $blog)
                        <tr>
                            <td><a href="{{ route('blogs.show' , ['blog'=>$blog]) }}" target="_blank">{{ $blog->name }}</a></td>
                            <td class=" d-flex justify-content-center align-items-center">
                                <a href="{{ route( 'blogs.edit' , ['blog' => $blog]) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                <form action="{{ route('blogs.destroy', ['blog' => $blog]) }}" method="post" id="delete-form-{{ $blog->id }}">
                                    @csrf
                                  @method('DELETE')
                                    <a href="javascript:document.getElementById('delete-form-{{ $blog->id }}').submit();" class="btn btn-sm btn-danger mr-2">
                                        Delete
                                    </a>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
                @if(count($blogs) > 0 )
                <div class="row ">
                    <div class="col-lg-12  d-flex justify-content-center">
                        {{ $blogs->render("pagination::bootstrap-4") }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</section>
<!-- ================ contact section end ================= -->


@endsection
