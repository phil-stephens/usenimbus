@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">


                @include('flash::message')

                <a href="{{ route('oauth_redirect_path', 'facebook') }}" class="btn btn-primary btn-lg btn-block social-btn"><i class="fa fa-facebook-official"></i> Sign Up with Facebook</a>


                <p class="text-muted text-center">Or Sign Up by Email</p>



                        @include('layouts.partials.errors')

                        {!! Form::open() !!}
                        <!-- Name Form Input -->
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

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

                        <!-- Password_confirmation Form Input -->
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm Password:') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Sign Up', ['class' => 'btn btn-default btn-lg']) !!}
                            {!! link_to_route('login_path', 'Already have an account?', null, ['class' => 'pull-right']) !!}
                        </div>
                        {!! Form::close() !!}

                <hr/>
            </div>
        </div>
    </div>
@endsection