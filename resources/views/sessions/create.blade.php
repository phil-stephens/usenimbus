@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">

            @include('flash::message')

            <a href="{{ route('oauth_redirect_path', 'facebook') }}" class="btn btn-primary btn-lg btn-block social-btn"><i class="fa fa-facebook-official"></i> Login with Facebook</a>

            <p class="text-muted text-center">Or Login by Email</p>

                    @include('layouts.partials.errors')

                    {!! Form::open() !!}
                    <!-- Email Form Input -->
                    <div class="form-group">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Password Form Input -->
                    <div class="form-group">
                        {!! Form::label('password', 'Password:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <!-- Submit field -->
                    <div class="form-group">
                        {!! Form::submit('Login', ['class' => 'btn btn-default btn-lg']) !!}

                        <ul class="list-unstyled pull-right text-right">
                            <li><a href="{{ url('password/email') }}">Forgotten Your Password?</a></li>
                            <li>{!! link_to_route('register_path', 'Need an account?') !!}</li>
                        </ul>

                    </div>
                    {!! Form::close() !!}

            <hr/>
        </div>
    </div>
</div>
@endsection