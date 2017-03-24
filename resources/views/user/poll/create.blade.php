@push('create-style')
    <!-- TAG INPUT: participant -->
    {!! Html::style('bower/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}

    <!-- BOOTSTRAP SWITCH: setting of poll -->
    {!! Html::style('bower/bootstrap-switch/dist/css/bootstrap2/bootstrap-switch.min.css') !!}

    <!-- DATETIME PICKER: time close of poll -->
    {!! Html::style('bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}
@endpush
@extends('layouts.app')
@section('title')
    {{ trans('polls.title') }}
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
    <!-- Create poll -->
    <div class="row row-create-poll">
        <div class="loader"></div>
        <div class="hide"
             data-poll="{{ $data['jsonData'] }}"
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
                @include('layouts.error')
                @include('layouts.message')
                <div class="progress cz-progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped bar" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <div class="navbar panel cz-panel">
                    <div class="navbar-inner board">
                        <div class="col-lg-10 col-lg-offset-1 panel-heading board-inner panel-heading-create-poll">
                            <ul class="nav nav-tabs voting">
                                <div class="liner"></div>
                                <li>
                                    <a href="#info" data-toggle="tab" data-toggle="tooltip"  title="{{ trans('polls.label.step_1') }}" class="step">
                                        <span class="round-tabs one fa fa-info">
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#option" data-toggle="tab" data-toggle="tooltip" title="{{ trans('polls.label.step_2') }}" class="step">
                                        <span class="round-tabs two fa fa-question">
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#setting" data-toggle="tab" data-toggle="tooltip" title="{{ trans('polls.label.step_3') }}" class="step">
                                        <span class="round-tabs three fa fa-cog">
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#participant" data-toggle="tab" data-toggle="tooltip" class="step" title="{{ trans('polls.label.step_4') }}">
                                        <span class="round-tabs four fa fa-users">
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane" id="info">
                        <div class="panel panel-darkcyan">
                            <div class="panel-heading panel-heading-darkcyan">
                                {{ trans('polls.label.step_1') }}
                            </div>
                            <div class="panel-body">
                                @include('layouts.poll_info')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="option">
                        <div class="panel panel-darkcyan">
                            <div class="panel-heading panel-heading-darkcyan">
                                {{ trans('polls.label.step_2') }}
                            </div>
                            <div class="panel-body">
                                @foreach ($data['viewData']['configOptions'] as $key => $text)
                                    <label class="config-option">
                                        {!!
                                            Form::checkbox('setting[' . $key . ']', $key,
                                            (isset($page)
                                            && ($page == 'edit' || $page == 'duplicate')
                                            && array_key_exists($key, $setting)) ? true : null, [
                                                'onchange' => 'settingAdvance(' . $key . ')',
                                                'class' => 'switch-checkbox-setting config-option',
                                            ])
                                        !!}
                                        <span class='span-text-setting'>{{ $text }}</span>
                                    </label>
                                    @if ($loop->first)
                                        <br>
                                    @endif
                                @endforeach
                                @include('layouts.poll_options')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="setting">
                        <div class="panel panel-darkcyan">
                            <div class="panel-heading panel-heading-darkcyan">
                                {{ trans('polls.label.step_3') }}
                            </div>
                            <div class="panel-body">
                                @include('layouts.poll_setting')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="participant">
                        <div class="panel panel-darkcyan">
                            <div class="panel-heading panel-heading-darkcyan">
                                {{ trans('polls.label.step_4') }}
                            </div>
                            <div class="panel-body">
                                @include('layouts.poll_participant')
                            </div>
                        </div>
                    </div>
                    <ul class="pager wizard">
                        <li class="finish"><a href="javascript:void(0);" class="btn btn-change-step btn-darkcyan btn-finish">{{ trans('polls.button.finish') }}</a></li>
                        <li class="previous"><a href="javascript:void(0);" class="btn-change-step btn btn-darkcyan">{{ trans('polls.button.previous') }}</a></li>
                        <li class="next"><a href="javascript:void(0);" class="btn-change-step btn btn-darkcyan">{{ trans('polls.button.continue') }}</a></li>
                    </ul>
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <!-- Feature -->
    @include('user.poll.feature')
@endsection
@push('create-scripts')

    <!-- ---------------------------------
        Javascript of create poll
    ---------------------------------------->

    <!-- FORM WINZARD: form step -->
    {!! Html::script('bower/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js') !!}

    <!-- TAG INPUT: participant -->
    {!! Html::script('/bower/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') !!}

    <!-- DATETIME PICKER: time close of poll -->
    {!! Html::script('/bower/moment/min/moment.min.js') !!}
    {!! Html::script('/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}

    <!-- BOOTSTRAP SWITCH: setting of poll -->
    {!! Html::script('bower/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}

    <!-- JQUERY VALIDATE: validate info of poll -->
    {!! Html::script('bower/jquery-validation/dist/jquery.validate.min.js') !!}

    <!-- PLUGIN ADD IMAGE FOR OPTIONS -->
    {!! Html::script('js/jqAddImageOption.js') !!}

    <!-- POLL -->
    {!! Html::script('js/poll.js') !!}

    {!! Html::script('bower/tinymce/tinymce.min.js') !!}

    <script type="text/javascript">
        /**
         * Init add images for options
        */
        var jqCreateImageOption = new jqAddImageOption();

        tinymce.init({
            selector: '#description',
            menubar: false,
            forced_root_block : false,
            force_br_newlines : true,
            force_p_newlines : false,
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            content_css: '//www.tinymce.com/css/codepen.min.css'
        });
    </script>
@endpush
