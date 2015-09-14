<div class="top-pane container-fluid">
    <div class="row">
        <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
            <h3 class="pull-left">
                Share URL: {!! link_to_route('droplet_path', null, $droplet->slug, ['target' => '_blank']) !!}
            </h3>

            <button class="btn btn-naked pull-right" data-toggle="modal" data-target="#sharing-modal"><i class="fa fa-share-square-o"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="sharing-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Share this Droplet by Email</h4>
            </div>
            {!! Form::open(['route' => ['droplet_share_path', $droplet->id]]) !!}
            <div class="modal-body">
                <!-- Emails Form Input -->
                <div class="form-group">
                    {!! Form::label('emails', 'Emails:') !!}
                    {!! Form::text('emails', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!-- Msg Form Input -->
                <div class="form-group">
                    {!! Form::label('message', 'Optional Message:') !!}
                    {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Send Emails</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

