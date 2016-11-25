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
 * Basic gulp
 */
gulp.task('default', ['serve', 'scripts']);

gulp.task('serve', [], function() {
	browserSync.init({
        server: "./plugin"
    });
	gulp.run('watch');
    // gulp.run('strip-css-comments');
});

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
var sassPathPlugin = 'plugin/scss/setup-wizard.scss';
gulp.task('sass', function() {
    return gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin'))
        .pipe(connect.reload());
});

/**
 * Compile markengine admin
 */
var sassPathPlugin = 'plugin/scss/marketengine-admin.scss';
gulp.task('sass', function() {
    return gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin'))
        .pipe(connect.reload());
});

/**
 * Compile markengine layout
 */
var sassPathPlugin = 'plugin/scss/marketengine-layout.scss';
gulp.task('sass', function() {
    return gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/css'))
        .pipe(connect.reload());
});

/**
 * Compile markengine layout basic theme
 */
var sassPathPlugin = 'plugin/scss/marketengine-layout-basic.scss';
gulp.task('sass', function() {
    return gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('C:/xampp/htdocs/me/wp-content/themes/zeroengine/css'))
        .pipe(connect.reload());
});


/*gulp.task('strip-css-comments', function () {
    return gulp.src('plugin/assets/css')
        .pipe(stripCssComments())
        .pipe(gulp.dest('plugin/assets/abc'));
});*/

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
    gulp.watch(jsPathPlugin, ['scripts']).on('change', browserSync.reload);
    gulp.watch("plugin/**/*.html").on('change', browserSync.reload);
});
