<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy = request('order_by','created_at');
        $sortBy = request('sort_by','desc');
        if (Auth::user() && Auth::user()->is_admin) {
            $items = Blog::orderBy($orderBy, $sortBy)->get();
        } else {
            $user_id = Auth::user() ? Auth::user()->id : 0;
            $items = Blog::where('status',  '1')->where('publish_up', '<=', date("Y-m-d"))->orWhere('user_id', $user_id)->orderBy($orderBy, $sortBy)->get();
        }
        return view('blog.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()) {
            return redirect('/')->with('error', 'Please login first');
        }
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()) {
            return redirect('/')->with('error', 'Please login first');
        }
        $blog = new Blog;
        $request->validate([
            'title'=>'required',
            'description'=> 'required',
        ]);
        $blog->status = -1;
        if (Auth::user()->is_admin == 1) {
            $blog->status = 1;
            $blog->publish_up = date("Y-m-d");
        }
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->user_id = Auth::user()->id;
        $blog->save();
        return redirect('/')->with('success', 'Blog has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blog.detail', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        if (Auth::user()->id != $blog->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'You cannot edit this blog');
        }
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        if (Auth::user()->id != $blog->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'You cannot edit this blog');
        }
        $blog->title = $request->title;
        $blog->description = $request->description;
        if ($request->status) {
            $blog->status = $request->status;
            if (!$request->publish_up) {
                $request->publish_up = date("Y-m-d");
            }
        }
        if ($request->publish_up) {
            $blog->status = 1;
            $blog->publish_up = $request->publish_up;
        }
        $blog->save();
        return redirect('/')->with('success', 'Blog has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if (Auth::user()->id != $blog->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'You cannot delete this blog');
        }
        $blog->delete();
        return redirect('/')->with('success', 'Blog has been deleted Successfully');
    }
}
