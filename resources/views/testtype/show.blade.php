@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{!! route('user.home') !!}">{!!trans('messages.home')!!}</a></li>
		  <li><a href="{!! route('testtype.index') !!}">{!! Lang::choice('messages.test-type',1) !!}</a></li>
		  <li class="active">{!!trans('messages.test-type-details')!!}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{!!trans('messages.test-type-details')!!}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{!! url("testtype/". $testType->id ."/edit") !!}">
					<span class="glyphicon glyphicon-edit"></span>
					{!!trans('messages.edit')!!}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<h3 class="view"><strong>{!! Lang::choice('messages.name',1) !!}</strong>{!! $testType->name !!} </h3>
				<p class="view-striped"><strong>{!!trans('messages.description')!!}</strong>
					{!! $testType->description !!}</p>
				<p class="view"><strong>{!! Lang::choice('messages.test-category',1) !!}</strong>
					{!! $testType->testCategory->name !!}</p>
				<p class="view-striped"><strong>{!!trans('messages.compatible-specimen')!!}</strong>
					{!! implode(", ", $testType->specimenTypes->lists('name')->toArray()) !!}</p>
				<p class="view"><strong>{!! Lang::choice('messages.measure',1) !!}</strong>
					{!! implode(", ", $testType->measures->lists('name')->toArray()) !!}</p>
				<p class="view-striped"><strong>{!!trans('messages.turnaround-time')!!}</strong>
					{!! $testType->targetTAT !!}</p>
				<p class="view"><strong>{!!trans('messages.prevalence-threshold')!!}</strong>
					{!! $testType->prevalence_threshold !!}</p>
				<p class="view-striped"><strong>{!!trans('messages.date-created')!!}</strong>
					{!! $testType->created_at !!}</p>
			</div>
		</div>
	</div>
@stop