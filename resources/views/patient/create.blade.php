@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{!! route('user.home') !!}">{!! trans('messages.home') !!}</a></li>
		  <li><a href="{!! route('patient.index') !!}">{!! Lang::choice('messages.patient',2) !!}</a></li>
		  <li class="active">{!!trans('messages.create-patient')!!}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-user"></span>
			{!!trans('messages.create-patient')!!}
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			
			@if($errors->all())
				<div class="alert alert-danger">
					{!! HTML::ul($errors->all()) !!}
				</div>
			@endif

			{!! Form::open(array('url' => 'patient', 'id' => 'form-create-patient')) !!}
				<div class="form-group">
					{!! Form::label('patient_number', trans('messages.patient-number')) !!}
					{!! Form::text('patient_number', $lastInsertId,
						array('class' => 'form-control')) !!}
				</div>
				<div class="form-group">
					{!! Form::label('name', trans('messages.names')) !!}
					{!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
				</div>
				<div class="form-group">
					{!! Form::label('dob', trans('messages.date-of-birth')) !!}
					{!! Form::text('dob', old('dob'), 
						array('class' => 'form-control standard-datepicker')) !!}
				</div>
				<div class="form-group">
					{!! Form::label('gender', trans('messages.gender')) !!}
					<div>{!! Form::radio('gender', '0', true) !!}
					<span class="input-tag">{!!trans('messages.male')!!}</span></div>
					<div>{!! Form::radio("gender", '1', false) !!}
					<span class="input-tag">{!!trans('messages.female')!!}</span></div>
				</div>
				<div class="form-group">
					{!! Form::label('address', trans('messages.physical-address')) !!}
					{!! Form::text('address', old('address'), array('class' => 'form-control')) !!}
				</div>
				<div class="form-group">
					{!! Form::label('phone_number', trans('messages.phone-number')) !!}
					{!! Form::text('phone_number', old('phone_number'), array('class' => 'form-control')) !!}
				</div>
				<div class="form-group">
					{!! Form::label('email', trans('messages.email-address')) !!}
					{!! Form::email('email', old('email'), array('class' => 'form-control')) !!}
				</div>
				<div class="form-group actions-row">
					{!! Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'), 
						['class' => 'btn btn-primary', 'onclick' => 'submit()']) !!}
				</div>

			{!! Form::close() !!}
		</div>
	</div>
@stop	