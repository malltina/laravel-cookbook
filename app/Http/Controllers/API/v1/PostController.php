<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
//        return DB::table('posts')->get();
        return Post::all();
    }

    public function store(Request $request)
    {
        $title = $request->get('title');
        $body  = $request->get('body');
//        DB::table('posts')->insert([
//            'title' => $title,
//            'body'  => $body,
//        ]);
//        $post = DB::table('posts')->select('*')->where('title',$title)->first();
//        $post=new Post();
//        $post->title = $title;
//        $post->body = $body;
//        $post->save();

       $post= Post::query()->create([
            'title'=>$title,
            'body'=>$body
        ]);
        return $post;
    }

    public function update(Request $request,int $postId)
    {
        $post=Post::query()->findOrFail($postId);
        $title = $request->get('title');
        $body  = $request->get('body');
        $post->update([
            'title'=>$title,
            'body'=>$body
        ]);
        return 'post updated.';
    }

    public function show(int $postId)
    {
//        $post=DB::table('posts')->select(['title','body'])->find($postId);
        $post=Post::query()->findOrFail($postId,['title','body']);
        return $post;
    }

    public function destroy(int $postId)
    {
        Post::findOrFail($postId)
                  ->delete();
        return 'post deleted';
    }
}
