
@extends('layout.master')
@section('content')
<h1>Welcome to first upload page</h1>

    {{  Form::open(array('url' =>'/uploadazure','files'=>true,'method'=>'post')) }}
    {{  Form::file('images[]',['multiple'=>true])  }}
    {{  Form::token()  }}
    {{  Form::submit('Upload')  }}
    {{  Form::close() }}
@endsection
