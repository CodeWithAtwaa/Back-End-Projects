@extends('theme.master')
@section('title' , 'Add New Blog')

@section('content')

@include('theme.partials.hero' , ['title'=>'Add New Blog'])
<!-- ================ contact section start ================= -->
<section class="section-margin--small section-margin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible  text-center fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="{{ route('blogs.store') }}" class="form-contact contact_form" method="post" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <input class="form-control border" value="{{old('name')}}" name="name" id="name" type="text" placeholder="Enter your blog title">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <input class="form-control border" name="image" id="image" type="file">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <select class="form-control border" name="category_id" id="category_id" value="{{old('category_id')}}">
                            @if (count($categories) > 0)
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <textarea class="form-control border" name="description" value="{{old('description')}}" placeholder="Enter your description"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- <textarea   rows="8" name="description" id="description" value="{{old('description')}}"> -->

                    </textarea>
                    <div class="form-group text-center text-md-right mt-3">
                        <button type="submit" class="button button--active button-contactForm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->


@endsection
