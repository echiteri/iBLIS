@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li><a href="{{{URL::route('reports.patient.index')}}}">{{ Lang::choice('messages.report',2) }}</a></li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.moh-706') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
		<table width="100%">
			<thead>
	            <tr>
	            	<td colspan="3" style="text-align:center;">
	                    <strong><p>{{ strtoupper(Lang::choice('messages.moh', 1)) }}<br>
	                    {{ strtoupper(Lang::choice('messages.lab-tests-data-report', 1)) }}<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class='container-fluid'>
			<div class='row'>
				{{ $data }}
			</div>
		</div>
	</div>
</div>
@stop
