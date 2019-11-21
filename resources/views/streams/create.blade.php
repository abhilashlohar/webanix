@extends('layouts.dashboard')
 
@section('content')

@foreach ($courses as $course)
	{{ $course->name }}
@endforeach

@endsection