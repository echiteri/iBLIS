@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{!! route('user.home') !!}">{!!trans('messages.home')!!}</a></li>
      <li><a href="{!! route('metric.index') !!}">{!!trans('messages.metricList')!!}</a></li>
	 	  <li class="active">{!! Lang::choice('messages.editmetric',2) !!}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{!! trans(Session::get('message')) !!}</div>
@endif
@if($errors->all())
    <div class="alert alert-danger">
        {!! HTML::ul($errors->all()) !!}
    </div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{!! Lang::choice('messages.metric',2) !!}
	</div>
	<div class="panel-body">
		   {!! Form::model($metric, array('route' => array('metric.update', $metric->id),'method'=>'PUT', 'id' => 'form-edit-metric')) !!}

            <div class="form-group">
                {!! Form::label('name', trans('messages.unit-of-issue')) !!}
                {!! Form::text('name', old('name'), array('class' => 'form-control', 'rows' => '2')) !!}
            </div>
             <div class="form-group">
                {!! Form::label('description', trans('messages.description')) !!}
                {!! Form::textarea('description', old('description'), array('class' => 'form-control', 'rows' => '2')) !!}
            </div>

            <div class="form-group actions-row">
                    {!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) !!}
            </div>
        {!! Form::close() !!}
	</div>
	
</div>
@stop