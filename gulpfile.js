const elixir = require('laravel-elixir');
require('es6-promise').polyfill();

elixir(function (mix) {
    mix.copy('node_modules/quill/dist/quill.bubble.css', 'resources/assets/sass/quill.bubble.scss')
    mix.copy('node_modules/quill/dist/quill.core.css', 'resources/assets/sass/quill.core.scss')
    mix.sass('layout/master.scss', 'public/css/layout/master.css');
    mix.sass('user.scss');
    mix.copy('node_modules/quill/dist/quill.min.js', 'public/js')
    mix.scripts('layout/master.js', 'public/js/layout/master.js');
    mix.scripts('poll.js');
    mix.scripts('multipleLanguage.js');
    mix.scripts('managePoll.js');
    mix.scripts('listPolls.js');
    mix.scripts('voteSocket.js');
    mix.scripts('editLink.js');
    mix.scripts('shareSocial.js');
    mix.scripts('vote.js');
    mix.scripts('comment.js');
    mix.scripts('common.js');
    mix.scripts('requiredPassword.js');
    mix.scripts('chart.js');
    mix.scripts('jqAddImageOption.js');
    mix.copy('public/bower/bootstrap/fonts', 'public/build/fonts/bootstrap');
    mix.version(['public/css/**/*.css', 'public/js/**/*.js']);
});
