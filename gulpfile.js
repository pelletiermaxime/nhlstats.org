var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.sass', false, { indentedSyntax: true })
       .styles(['../../../node_modules/selectize/dist/css/selectize.bootstrap3.css'],
             'public/css/vendors.css')
       .copy('node_modules/datatables/media/js/jquery.dataTables.min.js',
             'public/javascript/vendors/jquery.dataTables.min.js')
       .copy('node_modules/jquery/dist/jquery.min.js',
             'public/javascript/vendors/jquery.min.js')
       .copy('node_modules/bootstrap/dist/js/bootstrap.min.js',
             'public/javascript/vendors/bootstrap.min.js')
       .copy('node_modules/selectize/dist/js/standalone/selectize.min.js',
             'public/javascript/vendors/selectize.min.js')
       .copy('node_modules/graphiql/graphiql.min.js',
             'public/javascript/vendors/graphiql.min.js')
       .copy('node_modules/graphiql/graphiql.css',
             'public/css/graphiql.css')
       .browserSync({ proxy: 'nhlstats.local', open: false });
});
