@extends('layouts.email')

@section('content')
<p>Welcome aboard!</p>

@if( ! empty($password))
    <p>Your login details are:</p>

    <p>Email: {{ $user['email'] }}<br/>
    Password: {{ $password }}</p>
@endif

@endsection