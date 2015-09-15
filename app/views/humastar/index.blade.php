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
		<div class="panel-btn">
			<a class="btn btn-sm btn-info" href="{{ URL::to("humastar/upload") }}" >
				<span class="glyphicon glyphicon-plus-sign"></span>
				{{ trans('messages.upload-humastar') }}
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover table-condensed search-table">
			<thead>
				<tr>
					<th>{{ Lang::choice('messages.name', 1) }}</th>
					<th>{{ Lang::choice('messages.add', 1) }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach($humastarTests as $humastarTest)
				<tr>
					<td>{{ $humastarTest->testType->name }}</td>
					<td>
						<input type="checkbox" name="check" value="1">
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
			<button class="btn btn-sn btn-info delete-item-link">
				<span class="glyphicon "></span>
				{{ trans('messages.generate-astm') }}
			</button>
	</div>
</div>
@stop