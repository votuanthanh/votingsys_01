@extends('layouts.app')
@push('detail-style')
<!-- ---------------------------------
        Style of detail poll
---------------------------------------->
    <!-- DATETIME PICKER: time close of poll -->
    {!! Html::style('bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}

    <!-- SOCKET IO -->
    {!! Html::script('bower/socket.io-client/dist/socket.io.min.js') !!}

@endpush
@section('meta')
    <meta property="fb:app_id" content="708640145978561"/>
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $poll->getUserLink() }}" />
    <meta property="og:title" content="{{ $poll->title }}" />
    <meta property="og:description" content="{{ $poll->description }}" />
    <meta property="og:image" content="{{ asset('/uploads/images/vote.png') }}" />
    <style type="text/css">
         #chartjs-tooltip {
             opacity: 0;
             position: absolute;
             background: rgba(0, 0, 0, .7);
             color: white;
             padding: 3px;
             border-radius: 3px;
             -webkit-transition: all .1s ease;
             transition: all .1s ease;
             pointer-events: none;
             -webkit-transform: translate(-50%, 0);
             transform: translate(-50%, 0);
         }
         #chartjs-tooltip > img {
             height: 100px;
         }
    </style>
@endsection
@section('content')

    <!-- START: Frame Upload Image By Link Or Upload File-->
    <div class="modal fade" tabindex="-1" role="dialog" id="frame-upload-image">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="sub-tab">
                        <div class="sel">{{ trans('polls.label_for.add_picture_option') }}</div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="win-img">
                        <div class="photo-tb">
                            <div class="row">
                                <div class="col col-md-9 photo-tb-url">
                                    <div class="add-link-image-group">
                                        {!! Form::text('urlImageTemp', null, [
                                            'class' => 'photo-tb-url-txt form-control',
                                            'placeholder' => trans('polls.message_client.empty_link_image'),
                                        ]) !!}
                                        <span class="add-image-by-link label-info">
                                            {{ trans('polls.button.add') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col col-md-3 photo-tb-ui">
                                    <div class="photo-tb-btn photo-tb-upload">
                                        <span class="fa fa-camera"></span>
                                        <p>{{ trans('polls.button.upload') }}</p>

                                    </div>
                                    <div class="photo-tb-btn photo-tb-del">
                                        <span class="fa fa-times"></span>
                                        <p>{{ trans('polls.button.delete') }}</p>
                                    </div>
                                </div>
                            </div>
                            {!! Form::file('fileImageTemp', ['class' => 'fileImgTemp file']) !!}
                        </div>
                        <div class="has-error">
                            <div class="help-block error-win-img" id="title-error"></div>
                        </div>
                        <div class="photo-preivew">
                            <img src="" class="img-pre-option">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-yes">
                        {{ trans('polls.button.okay') }}
                    </button>
                    <button type="button" class="btn btn-no" data-dismiss="modal">
                        {{ trans('polls.button.cancel') }}
                    </button>
                </div>
            </div>
      </div>
    </div>
    <!-- END: Frame Upload Image By Link Or Upload File-->

    @if($isEditVoted && !$isLimit && !$poll->isClosed() && !$isTimeOut)
        <!-- START: Frame Upload Image By Link Or Upload File [Edit Voting]-->
        <div class="modal fade" tabindex="-1" role="dialog" id="frame-edit-poll">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="sub-tab">
                            <div class="sel">{{ $poll->title }}</div>
                        </div>
                    </div>

                    <div class="modal-body">
                        {!! Form::open([
                            'action' => ['User\VoteController@update', $poll->id],
                            'id' => 'edit-voted-content',
                            'method' => 'PATCH',
                            'files' => true,
                        ]) !!}
                            <div class="poll-option">

                            </div>
                            <div class="error_option"></div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-edit-submit">
                            {{ trans('polls.button.okay') }}
                        </button>
                        <button type="button" class="btn btn-no" data-dismiss="modal">
                            {{ trans('polls.button.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Frame Upload Image By Link Or Upload File [Edit Voting]-->

        <!-- START: Model form edit voting-->
        <div class="modal" tabindex="-1" role="dialog" id="frame-upload-image-edit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="sub-tab">
                            <div class="sel">{{ trans('polls.label_for.add_picture_option') }}</div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="win-img">
                            <div class="photo-tb">
                                <div class="row">
                                    <div class="col col-md-9 photo-tb-url">
                                        <div class="add-link-image-group">
                                            {!! Form::text('urlImageTemp', null, [
                                                'class' => 'photo-tb-url-txt-edit form-control',
                                                'placeholder' => trans('polls.message_client.empty_link_image'),
                                            ]) !!}
                                            <span class="add-image-by-link-edit label-info">
                                                {{ trans('polls.button.add') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col col-md-3 photo-tb-ui">
                                        <div class="photo-tb-btn photo-tb-upload-edit">
                                            <span class="fa fa-camera"></span>
                                            <p>{{ trans('polls.button.upload') }}</p>

                                        </div>
                                        <div class="photo-tb-btn photo-tb-del-edit">
                                            <span class="fa fa-times"></span>
                                            <p>{{ trans('polls.button.delete') }}</p>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::file('fileImageTemp', ['class' => 'fileImgTempEdit file']) !!}
                            </div>
                            <div class="has-error">
                                <div class="help-block error-win-img-edit" id="title-error"></div>
                            </div>
                            <div class="photo-preivew">
                                <img src="" class="img-pre-option-edit">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-yes-edit">
                            {{ trans('polls.button.okay') }}
                        </button>
                        <button type="button" class="btn btn-no" data-dismiss="modal">
                            {{ trans('polls.button.cancel') }}
                        </button>
                    </div>
                </div>
          </div>
        </div>
        <!-- END: Model form edit voting-->
    @endif

    <!-- START: List voters-->
    <div class="modal fade" tabindex="-1" role="dialog" id="voters-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" id="result-voters">

                </div>
            </div>
        </div>
    </div>
    <!-- END: List voters-->

    <div class="hide_vote_socket"
         data-host="{{ config('app.key_program.socket_host') }}"
         data-port="{{ config('app.key_program.socket_port') }}">
    </div>
    <div class="hide_chart" data-chart="{{ $optionRateBarChart }}"
                            data-name-chart="{{ $nameOptions }}"
                            data-pie-chart="{{ $dataToDrawPieChart }}"
                            data-title-chart="{{ $poll->title }}"
                            data-font-size="{{ $fontSize }}"
                            data-has-image="{{ $isHaveImages }}"></div>
    <div class="container">
        <div class="row">
            <div class="loader"></div>
            @include('noty.message')
            @include('errors.errors')
            <div id="voting_wizard" class="col-lg-10 col-lg-offset-1
                                            col-md-10 col-md-offset-1
                                            col-sm-10 col-sm-offset-1
                                            wrap-poll">
                <div class="navbar panel panel-default panel-detail-poll">
                    <div class="panel-body navbar-inner col-lg-12 panel-body-detail-poll">
                        <div class="col-lg-6 col-lg-offset-3
                                    col-md-6 col-md-offset-3
                                    col-sm-8 col-sm-offset-2
                                    col-xs-8 col-xs-offset-2
                                    panel-heading panel-test">
                            <ul>
                                <li><a href="#vote" data-toggle="tab">{{ trans('polls.nav_tab_edit.voting') }}</a></li>
                                <li><a href="#info" data-toggle="tab">{{ trans('polls.nav_tab_edit.info') }}</a></li>
                                @if (Session::has('isVotedSuccess') && Session::get('isVotedSuccess'))
                                    <li class="active"><a href="#result" data-toggle="tab">{{ trans('polls.nav_tab_edit.result') }}</a></li>
                                @else
                                    <li><a href="#result" data-toggle="tab">{{ trans('polls.nav_tab_edit.result') }}</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-lg-3 col-auth-detail">
                            @if (auth()->user() && auth()->user()->id == $poll->user_id)
                                <a href="{{ $poll->getAdminLink() }}" class="btn btn-darkcyan btn-primary btn-xs btn-auth-detail">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="hide-vote-details" data-poll-id="{{ $poll->id }}"></div>
                <div class="hide-vote" data-poll-id="{{ $poll->id }}" data-is-owner-poll="{{ $isOwnerPoll }}"></div>
                @if (session('message'))
                    <div class="alert alert-info message-infor-detail alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="icon fa fa-info"></i> {!! session('message') !!}
                    </div>
                @endif
                @if (isset($message))
                    <div class="alert alert-info message-infor-detail alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <i class="icon fa fa-info"></i> {!! session('message') !!}
                    </div>
                @endif
                <div class="tab-content">
                    <div class="tab-pane" id="vote">
                        @if ($isLimit)
                            <div class="alert alert-warning alert-poll-set-ip">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class='glyphicon glyphicon-warning-sign'></span>
                                {{ trans('polls.reach_limit') }}
                            </div>
                        @endif
                        @if ($isTimeOut)
                            <div class="alert alert-warning alert-poll-set-ip">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class='glyphicon glyphicon-warning-sign'></span>
                                {{ trans('polls.message_poll_time_out') }}
                            </div>
                        @endif
                        {!! Form::open(['route' => 'vote.store','id' => 'form-vote', 'files' => true]) !!}
                            <!-- VOTE OPTION -->
                            <div class="panel panel-default panel-vote-option">
                                <div class="panel-body panel-body-vote-option">
                                    <div class="col-lg-12">
                                        <h4>{{ $poll->title }}</h4>
                                        <p class="description-poll">{!! cleanText($poll->description) !!}</p>
                                        <label class="poll-count">
                                            <span class="label label-primary glyphicon glyphicon-user poll-details">
                                                <span class="count-participant">{{ $countParticipantsVoted }}</span>
                                            </span>
                                            <span class="label label-info glyphicon glyphicon-comment poll-details">
                                                <span class="comment-count">{{ $poll->countComments() }}</span>
                                            </span>
                                            <span class="label label-success glyphicon glyphicon-time poll-details">
                                                {{ $poll->created_at }}
                                            </span>
                                            @if ($poll->date_close)
                                                <span class="span-date-close" data-placement="top" data-toggle="tooltip" title="{{ trans('polls.label.time_close') }}">
                                                    {{ trans('polls.label.time_close') }}: <i>{{ $poll->date_close }}</i>
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="tab-content tab-content-detail">
                                        <div class="col-lg-12">
                                            <div class="col-lg-3 col-lg-offset-9 vote-style" data-option="{{ $viewOption }}">
                                                <ul class="nav nav-pills">
                                                    @if($isEditVoted && !$isLimit && !$poll->isClosed() && !$isTimeOut)
                                                        <li>
                                                            <a href="javascript:void(0)" class="btn-vote-style edit-each-option">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (!$isHideResult || Gate::allows('administer', $poll))
                                                        <li>
                                                            <a id="hide" class="btn-show-result-poll btn-vote-style" onclick="showResultPoll()">
                                                                <i class="fa fa-eye-slash li-show-result-poll" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a data-toggle="tab" href="#vertical" class="btn-vote-style">
                                                            <i class="fa fa-th" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                    <li class="active">
                                                        <a data-toggle="tab" href="#horizontal" class="btn-vote-style">
                                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- VOTE OPTION HORIZONTAL-->
                                        <div id="horizontal" class="tab-pane fade in active vote-style-detail">
                                            <div class="col-lg-12 horizontal-overflow">
                                                @foreach ($poll->options as $option)
                                                    <li class="list-group-item parent-vote li-parent-vote" onclick="voted('{{ $option->id }}', 'horizontal')">
                                                        @if (!$isHideResult || Gate::allows('administer', $poll))
                                                            <span id="id1{{ $option->id }}" class="badge float-xs-right result-poll">{{ $option->countVotes() }}</span>
                                                        @endif

                                                        <!-- show checkbox(multiple selection) or radio button(single selection) to vote if
                                                                1. Not enough number maximum of poll
                                                                2. Poll have not closed
                                                                3. Not set vote by IP of computer
                                                                4. Set vote IP. if :
                                                                    a. user have been login but have not vote
                                                                    b. user have not login and have not vote
                                                        -->
                                                        @if (!$isLimit && !$poll->isClosed() && !$isTimeOut)
                                                            @if ($poll->multiple == trans('polls.label.multiple_choice'))
                                                                {!!
                                                                    Form::checkbox('option[]', $option->id, false, [
                                                                        'onClick' => 'voted("' . $option->id  .'", "horizontal")',
                                                                        'class' => ($isHaveImages) ? 'poll-option-detail' : 'poll-option-detail-not-image',
                                                                        'id' => 'horizontal-' . $option->id
                                                                    ])
                                                                !!}
                                                            @else
                                                                {!!
                                                                    Form::radio('option[]', $option->id, false, [
                                                                        'onClick' => 'voted("' . $option->id  .'", "horizontal")',
                                                                        'class' => ($isHaveImages) ? 'poll-option-detail' : 'poll-option-detail-not-image',
                                                                        'id' => 'horizontal-' . $option->id
                                                                    ])
                                                                !!}
                                                            @endif
                                                        @endif
                                                        <div class="option-name">
                                                            <p>
                                                                @if($isHaveImages)
                                                                    <img src="{{ $option->showImage() }}" class="image-option-vote" onclick="showModelImage('{{ $option->showImage() }}')">
                                                                @endif
                                                                <span class="{{ ($isHaveImages) ? 'content-option-vote' :  'content-option-not-image'}}">{{ $option->name ? $option->name : " " }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="voters clearfix">
                                                            @foreach(array_slice($option->listVoter(), 0, config('settings.limit_voters_option')) as $voter)
                                                                <div class="voter-avatar" data-toggle="tooltip" title="{{ $voter['name'] }}">
                                                                    <img src="{{ $voter['avatar'] }}">
                                                                </div>
                                                            @endforeach
                                                            @if($option->countVotes() > config('settings.limit_voters_option'))
                                                                <div class="voter-avatar">
                                                                    <div class="hidden-counter"
                                                                        data-url-modal-voter="{{ action('User\VoteController@getModalOptionVoters', $option->id) }}">
                                                                        <span>{{ $option->countVotes() - config('settings.limit_voters_option') }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                                @if ($isAllowAddOption && !$isLimit && !$poll->isClosed() && !$isTimeOut)
                                                    @php
                                                        $idNewOption = rand();
                                                    @endphp
                                                    <li class="list-group-item parent-vote-new-option li-parent-vote" id="{{ $idNewOption }}">
                                                        @if ($poll->multiple == trans('polls.label.multiple_choice'))
                                                            {!! Form::checkbox('newOption[' . $idNewOption . ']', null, false, [
                                                                    'class' => 'poll-new-option poll-option-detail-not-image new-option checkbox',
                                                                ])
                                                            !!}
                                                        @else
                                                            {!! Form::radio('newOption[' . $idNewOption . ']', null, false, [
                                                                    'class' => 'poll-new-option poll-option-detail-not-image new-option',
                                                                ])
                                                            !!}
                                                        @endif
                                                        <div class="input-group date date-time-picker">
                                                            {!! Form::text('optionText[' . $idNewOption . ']', null, [
                                                                'class' => 'text-new-option form-control',
                                                                'autocomplete' => 'off',
                                                                'placeholder' => trans('polls.placeholder.option'),
                                                            ]) !!}
                                                            <span class="input-group-addon pick-date">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                            <span class="input-group-btn btn-file-img upload-photo">
                                                                <button class="btn btn-darkcyan-not-shadow" type="button">
                                                                    <span class="glyphicon glyphicon-picture"></span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <input type="file" id="input-file-image" name="optionImage[]">
                                                        <!--START: Win-Frame Add Image -->
                                                        <div class="box-media-image box-frame">
                                                            <a class="media-image upload-photo" href="javascript:void(0)">
                                                                <div class="image-frame">
                                                                    <div class="image-ratio">
                                                                        <img src="" id="preview-idOption" class="render-img thumbOption"/>
                                                                    </div>
                                                                    <span class="cz-label label-new">
                                                                        {{ trans('polls.label_for.option_image') }}
                                                                    </span>
                                                                </div>
                                                            </a>
                                                            <div class="fa fa-times deleteImg"></div>
                                                        </div>
                                                        <!--END: Win-Frame Add Image -->
                                                        <div class="has-error" id="error_option" data-message="{{ json_encode($messageImage) }}">
                                                            <span id="title-error" class="help-block"></span>
                                                        </div>
                                                    </li>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- VOTE OPTION VERTICAL-->
                                        <div id="vertical" class="tab-pane fade in vote-style-detail">
                                            <div class="col-lg-12 vertical-overflow">
                                                @foreach ($poll->options as $option)
                                                    <div class="col-lg-4 vertical-option">
                                                        <div class="panel panel-default" id="{{ $option->id }}">
                                                            <div class="panel-heading parent-vote panel-heading-vertical"  onclick="voted('{{ $option->id }}', 'horizontal')">
                                                                @if (!$isLimit && !$poll->isClosed() && !$isTimeOut)
                                                                    @if ($poll->multiple == trans('polls.label.multiple_choice'))
                                                                        {!!
                                                                            Form::checkbox('option_vertical[]', $option->id, false, [
                                                                                'onClick' => 'voted("' . $option->id  .'","vertical")',
                                                                                'id' => 'vertical-' . $option->id
                                                                            ])
                                                                        !!}
                                                                    @else
                                                                        {!!
                                                                            Form::radio('option_vertical[]', $option->id, false, [
                                                                                'onClick' => 'voted("' . $option->id  .'","vertical")',
                                                                                'id' => 'vertical-' . $option->id
                                                                            ])
                                                                        !!}
                                                                    @endif
                                                                @endif
                                                                @if (!$isHideResult || Gate::allows('administer', $poll))
                                                                    <span id="id2{{ $option->id }}" class="badge result-poll result-poll-vertical">{{ $option->countVotes() }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="panel-body panel-body-vertical-option">
                                                                <p>
                                                                    @if($isHaveImages)
                                                                        <img src="{{ $option->showImage() }}" onclick="showModelImage('{{ $option->showImage() }}')">
                                                                    @endif
                                                                    {{ $option->name ? $option->name : " " }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-validation"></div>
                                <div class="panel-footer">
                                    @if (!$isLimit && !$poll->isClosed() && !$isTimeOut)
                                        {!! Form::hidden('pollId', $poll->id) !!}
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-xs-name-vote">
                                                <div class="input-group  {{ ($isRequiredName || $isRequiredNameAndEmail) ? "required" : "" }}">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                    </span>
                                                    {!!
                                                        Form::text('nameVote', auth()->check() ? auth()->user()->name : null, [
                                                            'class' => 'form-control nameVote',
                                                            'placeholder' => trans('polls.placeholder.enter_name')
                                                        ])
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-xs-email-vote">
                                                <div class="input-group {{ ($isRequiredEmail || $isRequiredNameAndEmail) ? "required" : "" }}">
                                                    <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
                                                    </span>
                                                    {!!
                                                        Form::email('emailVote', auth()->check() ? auth()->user()->email : null, [
                                                            'class' => 'form-control emailVote',
                                                            'placeholder' => trans('polls.placeholder.email')
                                                        ])
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-btn-xs-vote">
                                                <span class="input-group-btn"
                                                    data-message-email="{{ trans('polls.message_email') }}"
                                                    data-id-poll="{{ $poll->id }}"
                                                    data-url="{{ url('/check-email') }}"
                                                    data-url-check-exist-email={{ action('User\VoteController@ajaxCheckIfExistEmailVote') }}
                                                    data-message-email-exists= "{{ trans('polls.message_client.email_exists') }}"
                                                    data-message-error-occurs= "{{ trans('polls.message_client.error_occurs') }}"
                                                    data-message-validate-email="{{ trans('polls.message_validate_email') }}"
                                                    data-message-required-email="{{ trans('polls.message_required_email') }}"
                                                    data-message-required-name="{{ trans('polls.message_validate_name') }}"
                                                    data-message-required-name-and-email="{{ trans('polls.message_validate_name_and_email') }}"
                                                    data-message-required-type-email="{{ trans('polls.required_type_email', ['type' => $typeEmail]) }}"
                                                    data-is-required-email="{{ $isRequiredEmail ? 1 : 0 }}"
                                                    data-is-required-name="{{ $isRequiredName ? 1 : 0 }}"
                                                    data-is-not-same-email="{{ $isNoTheSameEmail ? 1 : 0 }}"
                                                    data-is-accecpt-type-mail="{{ $isAccecptTypeMail ? 1 : 0 }}"
                                                    data-type-email="{{ $typeEmail }} "
                                                    data-is-required-name-and-email="{{ $isRequiredNameAndEmail ? 1 : 0 }}"
                                                    data-vote-limit-name="{{ trans('polls.validation.name.max') }}">
                                                    {{ Form::button(trans('polls.vote'), ['class' => 'btn btn-success btn-vote', ! $isUserVoted ? 'disabled' : '']) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- MODAL VIEW IMAGE-->
                            <div id="modalImageOption" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('polls.image_preview') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="#" id="imageOfOptionPreview">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('polls.close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane" id="info">
                        <div class="message-validation"></div>
                        <div class="panel panel-default panel-vote-option">
                            <div class="panel-body panel-body-vote-option">
                            <!-- POLL INFO -->
                                <div class="col-lg-12 poll-info">
                                    <h4>{{ $poll->title }}</h4>
                                    <p class="description-poll">{!! cleanText($poll->description) !!}</p>
                                    <p class="poll-info-not-xs">
                                        <span class="span-info">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $poll->created_at }}
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            @if ($poll->user_id)
                                                <label class="label-poll-info">{{ $poll->user->name }}</label>
                                            @else
                                                <label class="label-poll-info">{{ $poll->name }}</label>
                                            @endif
                                        </span>
                                        @if ($poll->location)
                                            <span class="span-location-poll" data-placement="top" data-toggle="tooltip" title="{{ $poll->location }}">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{ str_limit($poll->location, config('settings.str_limit.location')) }}
                                            </span>
                                        @endif
                                    </p>
                                    <div class="form-group col-lg-12 div-like-share">
                                        <div class="fb-like"
                                             data-href="{{ $poll->getUserLink() }}"
                                             data-layout="standard" data-action="like"
                                             data-size="small" data-show-faces="true"
                                             data-share="true">
                                        </div>
                                    </div>

                                    <div class="poll-info-xs">
                                        <p>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $poll->created_at }}
                                        </p>
                                        <p>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            @if ($poll->user_id)
                                                <label class="label-poll-info">{{ $poll->user->name }}</label>
                                            @else
                                                <label class="label-poll-info">{{ $poll->name }}</label>
                                            @endif
                                        </p>
                                        @if ($poll->location)
                                            <p data-placement="top" data-toggle="tooltip" title="{{ $poll->location }}">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{ str_limit($poll->location, config('settings.str_limit.location')) }}
                                            </p>
                                        @endif
                                        <p class="count-participant">
                                            <span class="fa fa-users"></span> {{ $countParticipantsVoted }}
                                        </p>
                                        <p class="comment-count">
                                            <span class="glyphicon glyphicon-comment"></span> {{ $poll->countComments() }}
                                        </p>
                                        @if ($poll->date_close)
                                            <p>
                                                <span class="fa fa-times-circle"></span> <i>{{ $poll->date_close }}</i>
                                            </p>
                                        @endif
                                    </div>

                                </div>
                            <!-- COMMENT -->
                                <div class="col-md-12" id="panel-comment">
                                    <div class="panel panel-default panel-darkcyan">
                                        <div class="panel-heading panel-heading-darkcyan">
                                            <h4>
                                                <span class="comment-count">{{ $poll->countComments() }} </span>
                                                {{ trans('polls.comments') }}
                                                <span data-label-show-comment = "<i class='fa fa-eye' aria-hidden='true'></i>"
                                                      data-label-hide="<i class='fa fa-eye-slash' aria-hidden='true'></i>">
                                                <button class="btn btn-warning show btn-xs" id="show-hide-list-comment">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                            </h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="hide" data-route="{{ url('user/comment') }}" data-confirm-remove="{{ trans('polls.confirmRemove') }}">
                                            </div>
                                            <div class="comments">
                                                @foreach ($poll->comments as $comment)
                                                    <div class="col-md-12" id="{{ $comment->id }}">
                                                        <br>
                                                        <div class="col-md-1 col-lg-1">
                                                            @if (isset($comment->user) && ($comment->name == $comment->user->name))
                                                                <img class="img-comment img-circle" src="{{ $comment->user->getAvatarPath() }}">
                                                            @else
                                                                <img class="img-comment img-circle" src="{{ $comment->showDefaultAvatar() }}">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-11 col-lg-11">
                                                            <label data-comment-id="{{ $comment->id }}" data-poll-id="{{ $poll->id }}">
                                                                <label class="user-comment">{{ $comment->name }}</label>
                                                                {{ $comment->created_at->diffForHumans() }}
                                                                @if (Gate::allows('ownerPoll', $poll))
                                                                    <span class="glyphicon glyphicon-trash delete-comment"></span>
                                                                @endif
                                                            </label>
                                                            <br>
                                                            <span class="comment-text">{{ $comment->content }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if (count($poll->comments))
                                                <div class="col-lg-12 hr-comment">
                                                    <hr class="hr-darkcyan">
                                                </div>
                                            @endif
                                            <div class="col-lg-12 comment comment-poll"
                                                 data-label-add-comment = "{{ trans('polls.add_comment') }}"
                                                 data-label-hide="{{ trans('polls.hide') }}">
                                                {!! Form::open(['route' => 'comment.store', 'class' => 'form-horizontal', 'id' => 'form-comment']) !!}
                                                    <div>
                                                        <label class="message-validate comment-name-validate"> </label>
                                                        <label class="message-validate comment-content-validate"></label>
                                                    </div>
                                                    <div class="col-md-6 comment">
                                                        {!!
                                                            Form::text('name', auth()->check() ? auth()->user()->name : null, [
                                                                'class' => 'form-control comment-info-name',
                                                                'id' => 'name' . $poll->id,
                                                                'placeholder' => trans('polls.placeholder.full_name'),
                                                            ])
                                                        !!}
                                                    </div>
                                                    <div class="col-md-10 comment"
                                                        data-poll-id="{{ $poll->id }}"
                                                        data-user="{{ auth()->check() ? auth()->user()->name : '' }}"
                                                        data-comment-name="{{ trans('polls.comment_name') }}"
                                                        data-comment-content="{{ trans('polls.comment_content') }}"
                                                        data-comment-limit-name="{{ trans('polls.validation.name.max') }}"
                                                        data-comment-limit-content="{{ trans('polls.validation.content.max') }}">
                                                        {!!
                                                            Form::textarea('content', null, [
                                                                'class' => 'form-control comment-info-content',
                                                                'rows' => config('settings.poll.comment_row'),
                                                                'placeholder' => trans('polls.placeholder.comment'),
                                                                'id' => 'content' . $poll->id,
                                                            ])
                                                        !!}
                                                        {{ Form::button(trans('polls.save_comment'), ['type' => 'submit', 'class' => 'btn addComment']) }}
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- POLL RESULT -->
                    <!-- if voted -> tab result(active) -->
                    @if (Session::has('isVotedSuccess') && Session::get('isVotedSuccess'))
                        @php
                            Session::forget('isVotedSuccess');
                        @endphp
                        <div class="tab-pane active" id="result">
                    @else
                        <div class="tab-pane" id="result">
                    @endif
                            <div class="panel panel-default panel-vote-option">
                                @if (!$isHideResult || Gate::allows('administer', $poll))
                                    <div class="bar-pie-chart">
                                        @if ($optionRateBarChart != "null")
                                            <div class="panel-heading panel-result-detail">
                                                <ul class="nav nav-pills">
                                                    <li class="active">
                                                        <a data-toggle="tab" href="#table">
                                                            <i class="fa fa-table" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="tab-bar-chart" data-toggle="tab" href="#barChart">
                                                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="tab-pie-chart" data-toggle="tab" href="#pieChart">
                                                            <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="panel-body panel-body-vote-option">
                                    @if (!$isHideResult || Gate::allows('administer', $poll))
                                    <!-- if have not vote -> hide tab style result -->
                                        <div class="tab-content">
                                            <!-- TABLE RESULT -->
                                            <div id="table" class="tab-pane fade show-details_default in active">
                                                <div class="col-lg-12 div-show-detail-vote">
                                                    <!-- SHOW DETAIL VOTE -->
                                                    <button type="button" class="btn btn-primary btn-show-detail-vote" data-toggle="modal" data-target="#myModal">
                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                        {{ trans('polls.show_vote_details') }}
                                                    </button>
                                                </div>

                                                <div class="modal fade model-show-details" id="myModal" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body scroll-result">
                                                                <!--START: Show option details-->
                                                                <table class="table option-date" cellspacing="0" cellpadding="0">
                                                                    <tbody>
                                                                        @if($optionDates['hours'])
                                                                            <!--START: Show month + year of option -->
                                                                            <tr class="header date month">
                                                                                @if($optionDates['notHour'])
                                                                                    <td colspan="2">
                                                                                        <h4>
                                                                                            <strong>
                                                                                                {{ $optionDates['participants']->count() . ' ' . trans('polls.participants')}}
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </td>
                                                                                @else
                                                                                    <td colspan="2"></td>
                                                                                @endif
                                                                                @foreach($optionDates['months'] as $data)
                                                                                    <td class="msep" colspan="{{ $data['count'] }}">
                                                                                        {{ $data['month'] }}
                                                                                    </td>
                                                                                @endforeach
                                                                                @if($optionDates['text'])
                                                                                    <td class="hsep" colspan="{{ count($optionDates['text']) }}"></td>
                                                                                @endif
                                                                            </tr>
                                                                            <!--END: Show month + year of option -->
                                                                            <!--START: Show week + day or only of option -->
                                                                            <tr class="header date day">
                                                                                @if($optionDates['notHour'])
                                                                                    <td class="hname">
                                                                                        {{ trans('polls.name')}}
                                                                                    </td>
                                                                                    <td class="hemail">
                                                                                        {{ trans('polls.email')}}
                                                                                    </td>
                                                                                @else
                                                                                    <td colspan="2">
                                                                                        <h4>
                                                                                            <strong>
                                                                                                {{ $optionDates['participants']->count() . ' ' . trans('polls.participants')}}
                                                                                            </strong>
                                                                                        </h4>
                                                                                    </td>
                                                                                @endif
                                                                                @foreach($optionDates['days'] as $data)
                                                                                    @foreach($data as $days)
                                                                                        <td class="dsep" colspan="{{ $days['count'] }}">
                                                                                            {{ $days['day'] }}
                                                                                        </td>
                                                                                    @endforeach
                                                                                @endforeach
                                                                                @if(!$optionDates['notHour'])
                                                                                    @if($optionDates['text'])
                                                                                        <td class="hsep" colspan="{{ count($optionDates['text']) }}"></td>
                                                                                    @endif
                                                                                @else
                                                                                    @foreach($optionDates['text'] as $data)
                                                                                        <td class="hsep" colspan="1">
                                                                                            {{ $data['text'] }}
                                                                                        </td>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tr>
                                                                            <!--END: Show week + day or only of option -->
                                                                        @endif
                                                                        @if(!$optionDates['notHour'])
                                                                            <!--START: Show hour or text of option -->
                                                                            <tr class="header date time">
                                                                                <td class="hname">
                                                                                    {{ trans('polls.name')}}
                                                                                </td>
                                                                                <td class="hemail">
                                                                                    {{ trans('polls.email')}}
                                                                                </td>
                                                                                @foreach($optionDates['hours'] as $data)
                                                                                    @if($data['hour'] == config('settings.hour_default'))
                                                                                        <td class="hsep" colspan="1">
                                                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                                                        </td>
                                                                                    @else
                                                                                        <td class="hsep" colspan="1">
                                                                                            {{ $data['hour'] }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                                @foreach($optionDates['text'] as $data)
                                                                                    <td class="hsep" colspan="1">
                                                                                        {{ $data['text'] }}
                                                                                    </td>
                                                                                @endforeach
                                                                            </tr>
                                                                            <!--END: Show hour or text of option -->
                                                                        @endif
                                                                        @foreach($optionDates['participants'] as $voter)
                                                                            <tr>
                                                                                <td class="nsep">{{ $voter['name'] }}</td>
                                                                                <td class="esep">{{ $voter['email'] }}</td>
                                                                                @if($optionDates['hours'])
                                                                                    @foreach($optionDates['hours'] as $hour)
                                                                                        @if($voter['id']->contains($hour['id']))
                                                                                            <td class="opsep pop">
                                                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                                                            </td>
                                                                                            @continue
                                                                                        @endif
                                                                                        <td class="opsep pn"></td>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if($optionDates['text'])
                                                                                    @foreach($optionDates['text'] as $text)
                                                                                        @if($voter['id']->contains($text['id']))
                                                                                            <td class="opsep pop">
                                                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                                                            </td>
                                                                                            @continue
                                                                                        @endif
                                                                                        <td class="opsep pn"></td>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <!--END: Show option details-->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-yes" data-dismiss="modal">{{ trans('polls.close') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 table-poll-result result-vote-poll">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('polls.no') }}</th>
                                                                <th>{{ trans('polls.label.option') }}</th>
                                                                <th>{{ trans('polls.number_vote') }}</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $maxVote = max(array_column($dataTableResult, 'numberOfVote'));
                                                                $voted = true;
                                                            @endphp
                                                            @foreach ($dataTableResult as $key => $data)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td class="{{ ($isHaveImages) ? 'td-poll-result' : '' }}">
                                                                        @if ($isHaveImages)
                                                                            <img src="{{ asset($data['image']) }}">
                                                                        @endif
                                                                        <p>{{ $data['name'] }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <div class="voters voters-td clearfix">
                                                                            @foreach (array_slice($data['listVoter'], 0, config('settings.limit_voters_option')) as $voter)
                                                                                <div class="voter-avatar" data-toggle="tooltip" title="{{ $voter['name'] }}">
                                                                                    <img src="{{ $voter['avatar'] }}">
                                                                                </div>
                                                                            @endforeach
                                                                            @if ($data['numberOfVote'] > config('settings.limit_voters_option'))
                                                                                <div class="voter-avatar">
                                                                                    <div class="hidden-counter"
                                                                                        data-url-modal-voter="{{ action('User\VoteController@getModalOptionVoters', $data['option_id']) }}">
                                                                                        <span>{{ $data['numberOfVote'] - config('settings.limit_voters_option') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($maxVote == $data['numberOfVote'] && $voted)
                                                                            @php
                                                                                $voted = false;
                                                                            @endphp
                                                                            <img src="{{ asset(config('settings.option.path_trophy')) }}" class="trophy">
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- MODEL VOTE CHART-->
                                            @if ($optionRateBarChart)
                                                <div class="show-piechart tab-pane fade" id="pieChart" role="dialog">
                                                    <div class="col-lg-12">
                                                        <!-- pie chart -->
                                                        <div id="chart_div"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($optionRateBarChart)
                                                <div class="show-barchart tab-pane fade" id="barChart" role="dialog">
                                                    <div class="col-lg-12">
                                                        <!-- bar chart -->
                                                        <canvas id="chart" width="900" height="550"></canvas>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning alert-hide-result">
                                            <span class='glyphicon glyphicon-warning-sign'></span>
                                            {{ trans('polls.hide_result_message') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="chartjs-tooltip"></div>
    <!-- Modal detail chart-->
    <div id="myModalChart" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title chart-detail-name"></h4>
                </div>
                <div class="modal-body">
                    <img src="#" class="chart-detail-image">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('detail-scripts')

<!-- ---------------------------------
    Javascript of detail poll
---------------------------------------->
    <!-- FORM WINZARD: form step -->
    {!! Html::script('bower/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js') !!}

    <!-- DATETIME PICKER: time close of poll -->
    {!! Html::script('/bower/moment/min/moment.min.js') !!}
    {!! Html::script('/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}

    <!-- COMMENT -->
    {!! Html::script('js/comment.js') !!}

    <!-- PLUGIN ADD IMAGE FOR OPTIONS -->
    {!! Html::script('js/jqAddImageOption.js') !!}

    <!-- POLL -->
    {!! Html::script('js/poll.js') !!}

    <!-- VOTE -->
    {!! Html::script('js/vote.js') !!}

    <!-- VOTE SOCKET-->
    {!! Html::script('js/voteSocket.js') !!}

    <!-- SOCIAL: like, share -->
    {!! Html::script('js/shareSocial.js') !!}


    <!-- HIGHCHART-->
    {!! Html::script('bower/chart.js/dist/Chart.bundle.min.js') !!}
    {!! Html::script('bower/chart.js/dist/Chart.min.js') !!}

    <!-- CHART -->
    {!! Html::script('js/chart.js') !!}

@endpush

