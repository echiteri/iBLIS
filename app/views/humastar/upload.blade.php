@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{Lang::choice('messages.humastar',2)}}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-adjust"></span>
		{{ trans('messages.humastar') }}
	</div>
	<div class="panel-body">
	{{Form::open(array('route' => 'humastar.processASTM', 'files' => true)) }}
		<div class="form-group">
			{{ Form::label('image', trans('messages.upload', array("class" => "btn btn-default"))) }}
			{{ Form::file('astm') }}
			<br/><br/>
			<div class="form-group actions-row">
				{{ Form::button('<span class="glyphicon glyphicon-upload"></span> '.
					trans('messages.upload'), ['class' => 'btn btn-primary', 'onclick' => 'submit()']) }}
			</div>
		</div>
	{{ Form::close() }}
	</div>
</div>
@stop