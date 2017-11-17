@extends('layouts.app')

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">You are 1 click away from creating you first shop!</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! Form::open(['url' => 'customer/site']) !!} 
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('site_domain', 'Site Domain') }}
                {{ Form::text('site_domain', old('site_domain'), 
                    [ 'placeholder' => 'https://example.com' ,
                        'class' => 'form-control'] ) }}
                @if ($errors->has('site_domain'))
                    <span class="help-block">
                        <strong>{{ $errors->first('site_domain') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                {{ Form::label('site_title', 'Site Title') }}
                {{ Form::text('site_title', old('site_title'), 
                    [ 'placeholder' => 'Nehaya Jewerly' ,
                        'class' => 'form-control'] ) }}
                @if ($errors->has('site_title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('site_title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn pull-right btn-primary">I'm ready, lets go!</button>
        </div>
    {!! Form::close() !!}
</div>
@endsection
