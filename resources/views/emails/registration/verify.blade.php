@extends('layouts.email')

@section('content')
<p>Visit this link to verify your account: {!! link_to_route('verification_path', null, $user['verification_code']) !!}</p>
@endsection