@extends('layouts.app')
@section('title')
    {{ trans('polls.title') }}
@endsection
@section('content')
    <!-- Search poll -->
    <div class="row row-create-poll">
        <div class="loader"></div>
        <div class="hide"
             data-poll=""
             data-route-email="{{ url('/check-email') }}"
             data-route-link="{{ route('link-poll.store') }}"
             data-token="{{ csrf_token() }}"
             data-link-check-date="{{ url('/check-date-close-poll') }}"
             data-location-route="{{ route('location.store') }}">
        </div>
        {{
           Form::open([
               'route' => 'user-poll.store',
               'method' => 'POST',
               'id' => 'form_create_poll',
               'enctype' => 'multipart/form-data',
               'role' => 'form',
           ])
        }}
            <div id="create_poll_wizard" class="col-lg-8 col-lg-offset-2
                                                col-md-8 col-md-offset-2
                                                col-sm-8 col-sm-offset-2
                                                col-xs-10 col-xs-offset-1 col-xs-create-poll
                                                wrap-poll animated fadeInLeft">
                <ul class="nav listing-sppoll">
                    <li class="poll-row">
                        <a href="#">
                            <span class="poll-info">
                                <span class="poll-title">
                                    Hello
                                </span>
                                <span class="poll-detail">
                                    <i class="fa fa-user"></i> Thanh - 
                                    <i class="fa fa-envelope" aria-hidden="true"></i> thanh123@gmail.com
                                </span>
                                <span class="poll-detail">
                                    <i class="fa fa-clock-o"></i> 12:00:AN 
                                </span>
                                <span class="poll-detail">
                                    <i class="fa fa-check-square-o"></i> das 
                                </span>
                                <span class="poll-detail">
                                    <i class="fa fa-unlock-alt"></i> public result 
                                </span>                                    
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        {{ Form::close() }}
    </div>
@endsection
