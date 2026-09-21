<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('delete');
    }
    function blogs(){
         $blogs = Blog::paginate(10);

    return view("blogs", compact("blogs"));
    }
    function abouts(){
       
        $name = "Kitsanaphong";
        $date = "6 กรกฎาคม 2026";
        return view("abouts",compact('name','date'));
    }

    function create()
    {
        return view("form");
    }
    function insert(Request $request){
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required',
        ],[
            'title.required'=>'กรุณากรอกชื่อบทความ',
            'title.max'=>'กรุณากรอกชื่อบทความไม่เกิน50ตัวอักษร',
            'content.required'=>'กรุณากรอกเนื้อหาบทความ',
        ]);
        $data=[
            'title'=>$request->title,
            'content'=>$request->content,
            
        ];
    
        blog::insert($data);
        return redirect()->route('blogs');
    }

    function delete($id) {
        blog::find($id)->delete();
        return redirect()->back();
}
function change($id){
    $blog = blog::find($id);
$data = [
    'status' => !$blog->status
];
    blog::find($id)->update($data);
return redirect()->back();   
}

function edit($id){
    $blog =  blog::find($id);
    return view('edit', compact('blog'));
}
function update(Request $request,$id)
{
    $request->validate([
        'title' => 'required|max:50',
        'content' => 'required',
    ], [
        'title.required' => 'กรุณาใส่ชื่อบทความ',
        'title.max' => 'ชื่อบทความต้องไม่เกิน 50 ตัวอักษร',
        'content.required' => 'กรุณาใส่เนื้อหา',
    ]);
    $data = [
        'title' => $request->title,
        'content' => $request->content,
    ];
    blog::find($id)->update($data);
    return redirect('/blogs');
}
}