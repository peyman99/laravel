<?php

namespace App\Http\Controllers;

use App\Events\PostViewEvent;
use App\Http\Requests\CreatePostsRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Postcontroller extends Controller
{

//    public function insert()
//    {
//        DB::insert('insert into posts(title,content,user_id)values(?,?,?)',['Inset پست','این پست با استفاده از متد پست ارسال شده است','1']);
//   }
//
//    public function select()
//    {
//        return DB::select('select * from posts');
//   }
//
//    public function update()
//    {
//        return DB::update('update posts set title="این پست آپدیت شده است" where id=?',[1]);
//
//   }
//
//    public function showMyView($id,$name,$password)
//    {
////        return view('pages.index')->with('id',$id);
////        return view('pages.index',compact('id'));
//        return view('pages.index',compact(['id','name','password']));
//
//   }
//
//    public function contact()
//    {
//        $people=['امیر','میلاد','سعید','پیمان','بهمن'];
//        return view('pages.contact',compact('people'));
//   }
//
//    public function allpost()
//    {
////      return DB::select('select * from posts');
////        return  Post::all();
////         $post = Post::where('title','Inset پست')->orderBy('id','desc')->get();
////         $post = Post::where('title','Inset پست')->orderBy('id','asc')->get();
//        return Post::where('title','Inset پست')->orderBy('id','asc')->take(1)->get();
//    }
//
//    public function savepost()
//    {
////        $post = new Post();
////            $post->title='پست شماره 10';
////            $post->content='این پست از طریق الوکوئنت ذخیره شده است';
////        $post->save();
//        $post =Post::create(['title'=>'پست شماره 20','content'=>'این پست از طریق الوکوئنت ذخیره شده است']);
//
//    }
//
//    public function updatepost()
//    {
////        $post = Post::where('id','6')->update(['title'=>'Update Title']);
////        return $post;
////        or
//        $post =  Post::findORFail(5);
//        $post->title='updatepost';
//        $post->content='update Post';
//        $post->save();
//    }
//
//
//    public function deletepost()
//    {
//        $post= Post::where('id','6')->Delete();
//
////        or
////        $post = Post::destroy(4);
////        or
////        $post = Post::destroy([4,5]);
//    }
//
//    public function trashed()
//
//    {
////        return $post=Post::onlyTrashed()->get();
//        return $post=Post::withTrashed()->get();
//    }
//
//    public function restore_post()
//    {
//        return $post=Post::onlyTrashed()->where('id',6)->restore();
//
//    }
//    public function force_delete_post()
//    {
//        return $post=Post::onlyTrashed()->where('id',6)->forceDelete();
//
//    }


    public function index()
    {
       $posts=Post::with('user')->get();
       return view('posts.index',compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }
    public function store(CreatePostsRequest $request)
    {


//        $this->validate($request,[
//            'title'=>'bail|required|max:2',
//            'description'=>'required'
//        ],[
//           'title.required'=>'لطفا عنوان مورد نظر خود را وارد کنید',
//            'title.max'=>'عنوان مورد نظر باید دو کارکتر باشد!',
//            'description.required'=>'توضیحات مطلب را وارد کنید'
//
//        ]);
//        return $request->input('title');



        $post=new Post();
        if($file=$request->file('file')){
            $name=$file->getClientOriginalName();
            $file->store('public/images');
            $file->move('images',$name);

              $post->patch=$name;
        }



        //            $input['patch']=$name;



        $post->title=$request->title;
        $post->content=$request->description;
        $post->user_id=1;


        $post->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts=Post::findOrFail($id);
        event(new PostViewEvent($posts));
        return view('posts.show',compact(['posts']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $posts = Post::findOrFail($id);
        $user=Auth::user();
        return view('posts.edit', compact(['posts']));

//        ----------------Policy in the Postcontroller--------------------
//        if($user->can('update',$posts)){
//            return view('posts.edit', compact(['posts']));
//
//        }else{
//            return "شما دسترسی ویرایش این مطلب را ندارید";
//        }


//        ----------------Gate in the Postcontroller--------------------
//        if (Gate::allows('edit-post', $posts)) {
//            return view('posts.edit', compact(['posts']));
//        } else{
//            return "شما دسترسی ویرایش این مطلب را ندارید";
//    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::findOrFail($id);
        $post->title=$request->title;
        $post->content=$request->description;
        $post->save();
        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post=Post::findOrFail($id);
        if (Gate::allows('delete-post', $post)) {
            $post->delete();
            return redirect('posts');
        }else{return "کاربر گرامی شما دسترسی حذف را ندارید";}
    }
}

