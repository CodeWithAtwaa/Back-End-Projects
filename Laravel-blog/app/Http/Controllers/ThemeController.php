<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(8);
        $sliderBlog = Blog::latest()->take(5)->get();
        return view('theme.index', ['blogs' => $blogs , 'sliderBlog'=>$sliderBlog]);
    }
    public function category($id)
    {
        $catName = Category::findOrFail($id)->name;
        $blogs = Blog::where('category_id' , $id)->paginate(4);
        return view('theme.category' , ['blogs' => $blogs , 'catName' =>$catName]);
    }
    public function contact()
    {
        return view('theme.contact');
    }
    public function login()
    {
        return view('theme.login');
    }
    public function register()
    {
        return view('theme.register');
    }
}
