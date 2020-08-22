<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\image;
use App\Models\post;
use App\Models\ImagePost;



class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $data = $request->only('title', 'body');
        $post = post::create($data);

//        if ($request->hasFile('image')){
//            foreach($request->image as $image){
//                $fileName = $image->getClientOriginalName();
//                $image->store('public');
//                ImagePost::query()->create(
//                  [
//                      'post_id' => $post->id,
//                      'image' => $fileName
//                  ]
//                );
//            }
//        }
        //by morphTo

        if ($request->hasFile('image')){
            foreach($request->image as $image) {
                $fileName = $image->getClientOriginalName();
                image::query()->create([
                    'imageable_id' => $post->id,
                    'imageable_type' => post::class,
                    'display_name' => $fileName,
                ]);
            }

        }

       return redirect()->route('posts.index')
           ->with('success','Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('posts.edit',compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($request->all());

//        if ($request->hasFile('image')){
//            foreach($request->image as $image){
//                $fileName = $image->getClientOriginalName();
//                $image->store('public');
//                ImagePost::query()->create(
//                  [
//                      'post_id' => $post->id,
//                      'image' => $fileName
//                  ]
//                );
//            }
//        }

//        if ($request->file('image') ){
//            $image = new image();
//            $image->display_name = $request->display_name;
//            $post->images()->save($image);
//        }
//        $path = $request->image->store('public');
//
//        $post->images()->create([
//            'display_name' => $path, // ? is the name is path?
//        ]);

//       if ($request->file('image') ){
//           image::query()->create([
//               'image_id' =>$post->id ,
//               'image_type'  => post::class,
//               'display_name' =>    $request->file('image')->getClientOriginalExtension()
//               ]);
//        }

        return redirect()->route('posts.index')
            ->with('success','Post updated successfully');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success','Post deleted successfully');
    }
}
