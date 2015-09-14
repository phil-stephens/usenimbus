@extends('layouts.default')

@section('meta')
    @parent
    <link rel="stylesheet" href="/css/pickadate/default.css"/>
    <link rel="stylesheet" href="/css/pickadate/default.date.css"/>
@endsection

@section('sidenav')
    @include('droplets.partials.sidenav')
@show

@section('content')
    @include('droplets.partials.share')

    @include('droplets.partials.free')

    {!! Form::model($droplet, ['route' => ['droplet_security_path', $droplet->id]]) !!}

    @include('layouts.partials.errors')

    <!-- Title Form Input -->
    <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control input-lg', 'placeholder' => 'Optional title']) !!}
    </div>

    <fieldset>
        <legend>Password Protection</legend>

        <div class="checkbox">
            <label>
                {!! Form::checkbox('use_password', '1', (bool) ! empty($droplet->password)); !!}
                Enable Password Protection
            </label>
        </div>

        <!-- Password Form Input -->
        <div class="form-group">
            {!! Form::label('password', 'New Password:') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>

        <!-- Password_confirmation Form Input -->
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Confirm New Password:') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>

        @if( ! empty($droplet->password))
        {!! Form::hidden('password_set', true) !!}
        @endif
    </fieldset>

    <fieldset>
        <legend>Download Limits</legend>

        <div class="checkbox">
            <label>
                {!! Form::checkbox('use_limit', '1', (bool) ! empty($droplet->limit) ) !!}
                Enable Download Limits
            </label>
        </div>

        <!-- Limit Form Input -->
        <div class="form-group">
            {!! Form::label('limit', 'Limit:') !!}
            {!! Form::text('limit', null, ['class' => 'form-control']) !!}
        </div>
    </fieldset>

    <fieldset>
        <legend>Start/Finish</legend>

        <div class="checkbox">
            <label>
                {!! Form::checkbox('use_expiry', '1', (bool) ( ! empty($droplet->start_at) || ! empty($droplet->finish_at) ) ); !!}
                Enable Publish Dates
            </label>
        </div>

        <!-- Start Form Input -->
        <div class="form-group">
            {!! Form::label('start_at', 'Start:') !!}
            {!! Form::text('start_at', null, ['class' => 'form-control start_datepicker', 'data-value' => $droplet->start_at]) !!}
        </div>

        <!-- Finish Form Input -->
        <div class="form-group">
            {!! Form::label('finish_at', 'Finish:') !!}
            {!! Form::text('finish_at', null, ['class' => 'form-control finish_datepicker', 'data-value' => $droplet->finish_at]) !!}
        </div>
    </fieldset>

    <!-- Submit field -->
    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary btn-lg']) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    @if($droplet->canBeUploadedTo())
        @include('droplets.partials.upload-overlay', ['currentDroplet' => $droplet])
    @endif
@endsection

@section('scripts')
    @parent
    <script src="/js/pickadate/picker.js"></script>
    <script src="/js/pickadate/picker.date.js"></script>

    <script>
        var finish = $('.finish_datepicker').pickadate({
            formatSubmit: 'yyyy-mm-dd',
            hiddenName: true
        });

        $('.start_datepicker').pickadate({
            formatSubmit: 'yyyy-mm-dd',
            hiddenName: true,
            onSet: function(context) {
                var finishPicker = finish.pickadate('picker');
                var minDate = context.select + 86400000;
                var finishSelected = finishPicker.get('select');

                if(finishSelected != null && finishSelected.pick < minDate)
                {
                    finishPicker.set('select', minDate);
                }

                finishPicker.set('min', new Date(minDate));
            }
        });
    </script>


@endsection