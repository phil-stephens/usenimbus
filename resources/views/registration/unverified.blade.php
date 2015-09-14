@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h1 class="page-header text-center">Account Verification Required</h1>

                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-body">

                        <p>Your email address is unverified. Please click the verification link in the email that has been sent to you.</p>

                        {!! Form::open(['route' => 'send_verification_path']) !!}
                        {!! Form::hidden('id', Auth::id()) !!}

                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Send verification email again', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection