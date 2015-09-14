@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h1 class="page-header text-center">Reset Password</h1>

                @include('flash::message')

                        @include('layouts.partials.errors')

                        {!! Form::open() !!}

                        {!! Form::hidden('token', $token) !!}

                        <!-- Email Form Input -->
                        <div class="form-group">
                            {!! Form::label('email', 'Current Email Address:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Password Form Input -->
                        <div class="form-group">
                            {!! Form::label('password', 'New Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm New Password:') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Reset Password', ['class' => 'btn btn-default btn-lg']) !!}
                        </div>
                        {!! Form::close() !!}
                <hr/>
            </div>
        </div>
    </div>
@endsection
