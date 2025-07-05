@extends('layouts.app')
@php
    $profile=asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    {{__('Users')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">
                {{__('Users')}}
            </a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('manage user'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('users.create') }}"
           data-title="{{__('Add New User')}}"> <i
                class="ti-plus mr-5"></i>
            {{__('Create User')}}
        </a>
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('User')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Phone Number')}}</th>
                            @if(\Auth::user()->type=='super admin')
                                <th>{{__('Active Package')}}</th>
                                <th>{{__('Package Due Date')}}</th>
                            @else
                                <th>{{__('Assign Role')}}</th>
                            @endif
                            <th>{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="table-user">
                                    <img
                                        src="{{!empty($user->avatar)?asset(Storage::url('upload/profile')).'/'.$user->avatar:asset(Storage::url('upload/profile')).'/avatar.png'}}"
                                        alt="" class="mr-2 avatar-sm rounded-circle user-avatar">
                                    <a href="#" class="text-body font-weight-semibold">{{ $user->name }}</a>
                                </td>
                                <td>{{ $user->email }} </td>
                                <td>{{ !empty($user->phone_number)?$user->phone_number:'-' }} </td>
                                @if(\Auth::user()->type=='super admin')
                                    <td>{{ !empty($user->subscriptions)?$user->subscriptions->title:'-' }} </td>
                                    <td>{{!empty($user->plan_expire_date) ? dateFormat($user->plan_expire_date): __('Unlimited')}} </td>
                                @else
                                    <td>{{ ucfirst($user->type) }} </td>
                                @endif
                                <td>
                                    <div class="cart-action">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                                        @can('edit user')
                                            <a class="text-success customModal" data-bs-toggle="tooltip" data-size="lg"
                                               data-bs-original-title="{{__('Edit')}}" href="#"
                                               data-url="{{ route('users.edit',$user->id) }}"
                                               data-title="{{__('Edit User')}}"> <i data-feather="edit"></i></a>
                                        @endcan
                                        @can('delete user')
                                            <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                               data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                    data-feather="trash-2"></i></a>
                                        @endcan
                                        {!! Form::close() !!}
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
