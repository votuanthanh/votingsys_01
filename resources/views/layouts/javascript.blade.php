<!-- JQUERY -->
{!! Html::script('bower/jquery/dist/jquery.min.js') !!}

<!-- BOOTSTRAP -->
{!! Html::script('bower/bootstrap/dist/js/bootstrap.min.js') !!}

<!-- DROPDOWN: multiple language -->
{!! Html::script('bower/ms-Dropdown/js/msdropdown/jquery.dd.min.js') !!}
{!! Html::script(elixir('js/multipleLanguage.js')) !!}

{!! Html::script(elixir('js/layout/master.js')) !!}

{!! Html::script(elixir('js/quill.min.js')) !!}

@stack('create-scripts')

@stack('detail-scripts')

@stack('manage-scripts')

@stack('list-poll-scripts')

@stack('show-error-scripts')

@stack('common-script')
