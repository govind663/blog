<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\PostChildComment;
use App\Models\PostParentComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        // dd($blogs);

        return view('post.index')->with(['blogs' => $blogs]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(BlogRequest $request)
    {
        $data = new Blog();

        if (!empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $new_name = time() . rand(10, 999) . '.' . $extension;
            $image->move(public_path('/blog/post'), $new_name);

            $image_path = "/blog/post" . $image_name;
            $data->image = $new_name;
        }

        $data->user_id = Auth::user()->id;
        $data->title = $request->get('title');
        $data->content = $request->get('content');
        $data->created_at = Carbon::now();
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('post.index')->with('message', 'The Post created has been done Successfully.');
    }

    public function show($id)
    {
        $blogs = Blog::findOrFail($id)->with('user')->whereNull('deleted_at')->orderBy('id', 'desc')->first();
        // return($blogs);

        $parrentPostComments = PostParentComment::with('user', 'blog')->where('blog_id', $id)->where('user_id', Auth::user()->id)->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        // dd($parrentPostComments);

        return view('post.view')->with('blogs', $blogs)->with('parrentPostComments', $parrentPostComments);
    }

    public function ParrentCommentPost(Request $request, $blog_id)
    {
        $data = new PostParentComment();
        $data->blog_id = $request->input('blog_id');
        $data->post_comment = $request->input('post_comment');
        $data->user_id = Auth::user()->id;
        $data->created_at = Carbon::now();
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->back()->with('message','Your comment has been posted successfully..!!');
    }

    public function ChildCommentPost(Request $request, $blog_id)
    {
        $data = new PostChildComment();
        $data->blog_id = $request->input('blog_id');
        $data->post_parent_comment_id = $request->input('comment_id');
        $data->post_reply_comment = $request->input('post_reply_comment');
        $data->user_id = Auth::user()->id;
        $data->created_at = Carbon::now();
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->back()->with('message','Your comment has been posted successfully..!!');
    }
}
