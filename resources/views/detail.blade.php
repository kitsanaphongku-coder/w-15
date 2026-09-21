<!-- resources/views/detail.blade.php -->
@extends('layouts.app')

@section('title')
    {{$blog->title}}
@endsection

@section('content')
    <h1>{{$blog->title}}</h1>
    <hr>
    <div>{!! $blog->content !!}</div>
@endsection
