@extends('layouts.email')

@section('content')

<p>Click here to reset your password: {{ url('password/reset/'.$token) }}</p>

@endsection