@extends("layout")
@section("content")
<div>
    <ol class="breadcrumb">
      <li><a href="{!! route('user.home') !!}">{!!trans('messages.home')!!}</a></li>
      <li>
        <a href="{!! route('role.index') !!}">{!! Lang::choice('messages.role',1) !!}</a>
      </li>
      <li class="active">{!!trans('messages.edit-role')!!}</li>
    </ol>
</div>
<div class="panel panel-primary">
    <div class="panel-heading ">
        <span class="glyphicon glyphicon-edit"></span>
            {!!trans('messages.edit-role')!!}
    </div>
    <div class="panel-body">
        @if($errors->all())
            <div class="alert alert-danger">
                {!! HTML::ul($errors->all()) !!}
            </div>
        @endif
        {!! Form::model($role, array(
                'route' => array('role.update', $role->id), 'method' => 'PUT',
                'id' => 'form-edit-role')) !!}
            <div class="form-group">
                {!! Form::label('name',  Lang::choice('messages.name',1)) !!}
                {!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', trans('messages.description')) !!}
                {!! Form::textarea('description', old('description'), 
                    array('class' => 'form-control', 'rows' => '2')) !!}
            </div>
            <div class="form-group actions-row">
                    {!! Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.save'), 
                        array('class' => 'btn btn-primary', 'onclick' => 'submit()')) !!}
            </div>

        {!! Form::close() !!}
    </div>
</div>
@stop