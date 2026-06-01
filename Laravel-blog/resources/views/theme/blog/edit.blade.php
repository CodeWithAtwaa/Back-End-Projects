@extends('theme.master')
@section('title', 'Edit')

@section('content')
@include('theme.partials.hero', ['title' => $blog->name])

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

                <form action="{{ route('blogs.update', ['blog' => $blog]) }}"
                      class="form-contact contact_form"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Blog Title --}}
                    <div class="form-group">
                        <input class="form-control border"
                               value="{{ old('name', $blog->name) }}"
                               name="name"
                               id="name"
                               type="text"
                               placeholder="Enter your blog title">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Image --}}
                    <div class="form-group">
                        <input class="form-control border"
                               name="image"
                               id="image"
                               type="file">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        @if ($blog->image)
                            <img src="{{ asset('storage/blogs/' . $blog->image) }}"
                                 alt="Current Image"
                                 width="150"
                                 class="mt-2 rounded">
                        @endif
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <select class="form-control border" name="category_id" id="category_id">
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    @selected(old('category_id', $blog->category_id) == $item->id)>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <textarea class="form-control border"
                                  name="description"
                                  id="description"
                                  rows="6"
                                  placeholder="Enter your description">{{ old('description', $blog->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Submit --}}
                    <div class="form-group text-center text-md-right mt-3">
                        <button type="submit" class="button button--active button-contactForm">
                            Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection
