@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container py-5">
    <h1>{{ $news->title }}</h1>
    <p>{!! $news->description !!}</p>
    <small>Published on: {{ $news->created_at->format('M d, Y') }}</small>
</div>
@endsection
