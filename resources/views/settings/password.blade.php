@extends('layouts.app')
@section('page-title')
    {{__('Password Settings')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Password Settings')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 cdx-xxl-100 cdx-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="info-group">
                        {{Form::model($loginUser, array('route' => array('setting.password'), 'method' => 'post')) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('current_password',__('Current Password'),array('class'=>'form-label'))}}
                                    {{Form::password('current_password',array('class'=>'form-control','placeholder'=>__('Enter your current password'),'required'=>'required'))}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('new_password',__('New Password'),array('class'=>'form-label'))}}
                                    {{Form::password('new_password',array('class'=>'form-control','placeholder'=>__('Enter your new password'),'required'=>'required'))}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('confirm_password',__('Confirm New Password'),array('class'=>'form-label'))}}
                                    {{Form::password('confirm_password',array('class'=>'form-control','placeholder'=>__('Enter your confirm new password'),'required'=>'required'))}}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            {{Form::submit(__('Save'),array('class'=>'btn btn-primary btn-rounded'))}}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

