var gulp 				= require('gulp');
var sass 				= require('gulp-sass');
var minifyCSS 			= require('gulp-minify-css');
var concat 				= require('gulp-concat');
var rename 				= require('gulp-rename');
var uglify 				= require('gulp-uglify');
var autoprefixer        = require('gulp-autoprefixer');
var connect             = require('gulp-connect');
var browserSync 		= require('browser-sync').create();
// var stripCssComments    = require('gulp-strip-css-comments');
var strip_comments = require('gulp-strip-json-comments');


/**
 * More complex gulp
 */
gulp.task('task-name', function() {
    return gulp.src('source-files')
        .pipe(gulpPlugin())
        .pipe(gulp.dest('destination'));
});

/**
 * Compile sass
 */
var sassPathPlugin = 'plugin/scss/**/*.scss';
gulp.task('sass', function() {
    return gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('plugin/assets/css'))
        .pipe(connect.reload());
});

/**
 * Compile Setup Wizard
 */
var sassPathPluginSetup = 'plugin/scss/setup-wizard.scss';
var dest_setup = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin';
// var dest_setup = 'plugin/assets/css';
gulp.task('sass-setup', function() {
    return gulp.src(sassPathPluginSetup)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_setup))
        .pipe(connect.reload());
});

/**
 * Compile markengine admin
 */
var sassPathPluginAdmin = 'plugin/scss/marketengine-admin.scss';
var dest_admin = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin';
gulp.task('sass-admin', function() {
    return gulp.src(sassPathPluginAdmin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_admin))
        // .pipe(connect.reload());
});

/**
 * Compile markengine layout
 */
var sassPathPluginLayout = 'plugin/scss/marketengine-layout.scss';
gulp.task('sass-layout', function() {
    return gulp.src(sassPathPluginLayout)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/css'))
        // .pipe(connect.reload());
});

/**
 * Compile markengine layout basic theme
 */
var sassPathPluginLayoutBasic = 'plugin/scss/marketengine-layout-basic.scss';
var dest_layout_basic = 'C:/xampp/htdocs/me/wp-content/themes/zeroengine/css';
gulp.task('sass-layout-basic', function() {
    return gulp.src(sassPathPluginLayoutBasic)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_layout_basic))
        // .pipe(connect.reload());
});

// uglify task
// 
var jsPathPlugin = 'plugin/assets/script/**/*.js';
gulp.task('scripts', function() {
    // main app js file
    gulp.src('plugin/assets/js/me.sliderthumbs.js')
    .pipe(uglify())
    .pipe(concat("me.sliderthumbs.min.js"))
    .pipe(gulp.dest('plugin/assets/js/'))
    .pipe(connect.reload());

    // main app js file
    gulp.src('plugin/assets/js/script.js')
    .pipe(uglify())
    .pipe(concat("script.min.js"))
    .pipe(gulp.dest('plugin/assets/js/'))
    .pipe(connect.reload());

});


/**
 * Concat js
 */
// var jsPathPlugin = 'plugin/assets/script/**/*.js';
// gulp.task('scripts', function() {
//     return gulp.src(jsPathPlugin)
//         .pipe(gulp.dest('plugin/assets/js'))
//         .pipe(uglify())
//         .pipe(gulp.dest('plugin/assets/js'));
// });

/**
 * Watcher
 */
gulp.task('watch', function() {
    gulp.watch(sassPathPlugin, ['sass']).on('change', browserSync.reload);
    gulp.watch(sassPathPluginSetup, ['sass-setup']).on('change', browserSync.reload);
    gulp.watch(sassPathPluginAdmin, ['sass-admin']).on('change', browserSync.reload);
    gulp.watch(sassPathPluginLayout, ['sass-layout']).on('change', browserSync.reload);
    gulp.watch(sassPathPluginLayoutBasic, ['sass-layout-basic']).on('change', browserSync.reload);
    gulp.watch(jsPathPlugin, ['scripts']).on('change', browserSync.reload);
    gulp.watch("plugin/**/*.html").on('change', browserSync.reload);
});

/**
 * Basic gulp
 */
gulp.task('default', ['serve', 'scripts']);

gulp.task('serve', ['sass', 'sass-setup', 'sass-admin', 'sass-layout', 'sass-layout-basic'], function() {
    browserSync.init({
        server: "./plugin"
    });
    gulp.run('watch');
});