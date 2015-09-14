@extends('layouts.email')

@section('content')
    <p>{{ $user['name'] }} would like to share some files with you.</p>

    <p>Visit {!! route('droplet_path', $droplet['slug']) !!}</p>

    @if( ! empty($droplet['password']))
    <p>The password is <strong><em>{{ Crypt::decrypt($droplet['password']) }}</em></strong></p>
    @endif

    @if( ! empty($msg))
    <p>*****</p>
    {!! nl2br($msg) !!}
    <p>*****</p>
    @endif

@endsection