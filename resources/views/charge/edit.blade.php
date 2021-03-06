@extends("layout")

@section("content")
<div class="row">
    <div class="col-sm-12">
        <ul class="breadcrumb">
            <li><a href="{!! url('home') !!}"><i class="fa fa-home"></i> {!! trans('messages.home') !!}</a></li>
            <li class="active"><i class="fa fa-database"></i> {!! trans('messages.test-catalog') !!}</li>
            <li><a href="{!! route('charge.index') !!}"><i class="fa fa-cube"></i> {!! trans_choice('messages.charge', 2) !!}</a></li>
            <li class="active">{!! trans('messages.edit').' '.trans_choice('messages.charge', 1) !!}</li>
        </ul>
    </div>
</div>
<div class="conter-wrapper">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> {!! trans('messages.edit').' '.trans_choice('messages.charge', 1) !!} 
            <span>
                <a class="btn btn-sm btn-carrot" href="#" onclick="window.history.back();return false;" alt="{!! trans('messages.back') !!}" title="{!! trans('messages.back') !!}">
                    <i class="fa fa-step-backward"></i>
                    {!! trans('messages.back') !!}
                </a>                
            </span>
        </div>
        <div class="card-block">            
            <!-- if there are creation errors, they will show here -->
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{!! trans('messages.close') !!}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif

            {!! Form::model($charge, array('route' => array('charge.update', $charge->id), 
                'method' => 'PUT', 'id' => 'form-edit-charge')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                <!-- ./ csrf token -->
                <div class="form-group row">
                    {!! Form::label('name', trans_choice('messages.test_id',1), array('class' => 'col-sm-2 form-control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('current_amount', trans("terms.current_amount"), array('class' => 'col-sm-2 form-control-label')) !!}</label>
                    <div class="col-sm-6">
                        {!! Form::textarea('current_amount', old('current_amount'), array('class' => 'form-control', 'rows' => '2')) !!}
                    </div>
                </div>
                <div class="form-group row col-sm-offset-2">
                    {!! Form::button("<i class='fa fa-check-circle'></i> ".trans('messages.update'), 
                        array('class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()')) !!}
                    <a href="#" class="btn btn-sm btn-silver"><i class="fa fa-times-circle"></i> {!! trans('messages.cancel') !!}</a>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
