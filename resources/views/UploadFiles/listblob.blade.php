@extends('layout.master')
@section('content')
    <h1>Welcome to first upload page</h1>
    <ul>


         {{ json_encode($return) }}
    </ul>

@endsection
