var gulp 				= require('gulp');
var sass 				= require('gulp-sass');
var minifyCSS 			= require('gulp-minify-css');
var concat 				= require('gulp-concat');
var rename 				= require('gulp-rename');
var uglify 				= require('gulp-uglify');
var autoprefixer        = require('gulp-autoprefixer');
var connect             = require('gulp-connect');
var browserSync 		= require('browser-sync').create();
var strip_comments      = require('gulp-strip-json-comments');


/**
 * Basic gulp
 */
gulp.task('default', ['serve', 'scripts', 'script-vendor']);


gulp.task('serve', ['sass'], function() {
    browserSync.init({
        server: "./plugin"
    });
    gulp.run('watch');
});


/**
 * Compile sass
 */
var sassPathPlugin = 'plugin/scss/**/*.scss';

var sassPathPluginSetup = 'plugin/scss/setup-wizard.scss';
var dest_setup = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin';

var sassPathPluginAdmin = 'plugin/scss/marketengine-admin.scss';
var dest_admin = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/admin';

var sassPathPluginLayout = 'plugin/scss/marketengine-layout.scss';
var dest_layout = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/css';

var sassPathPluginLayoutBasic = 'plugin/scss/marketengine-layout-basic.scss';
var dest_layout_basic = 'C:/xampp/htdocs/me/wp-content/themes/zeroengine/css';

gulp.task('sass', function() {
    gulp.src(sassPathPlugin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('plugin/assets/css'));
        // .pipe(connect.reload());


    /**
     * Compile Setup Wizard
     */
    gulp.src(sassPathPluginSetup)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_setup));


    /**
     * Compile markengine admin
     */
    gulp.src(sassPathPluginAdmin)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_admin));


    /**
     * Compile markengine layout
     */
    gulp.src(sassPathPluginLayout)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_layout));


    /**
     * Compile markengine layout basic theme
     */
    gulp.src(sassPathPluginLayoutBasic)
        .pipe(sass({ includePaths: ['plugin/scss/custom'], errLogToConsole: true }))
        .pipe(strip_comments())
        .pipe(autoprefixer({cascade: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest(dest_layout_basic));
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

var me_vendor_src               = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/js';
var me_vendor_dest              = 'C:/xampp/htdocs/me/wp-content/plugins/zeroengine/assets/js';

var jquery_ui                   = me_vendor_src + '/jquery-ui.js';
var muploader                   = me_vendor_src + '/muploader.js/';
var jquery_magnific_popup       = me_vendor_src + '/jquery.magnific-popup.min.js';
var jquery_flexslider           = me_vendor_src + '/jquery.flexslider-min.js';
var jquery_raty                 = me_vendor_src + '/jquery.raty.js';

var me_user_profile             = me_vendor_src + '/user-profile.js';
var me_tag_box                  = me_vendor_src + '/tag-box.js';
var me_post_listing             = me_vendor_src + '/post-listing.js';
var me_me_sliderthumbs          = me_vendor_src + '/me.sliderthumbs.js';
var me_script                   = me_vendor_src + '/script.js';
var me_message                  = me_vendor_src + '/message.js';
var me_index                    = me_vendor_src + '/index.js';
var me_my_listings              = me_vendor_src + '/my-listings.js';
var me_listing_review           = me_vendor_src + '/listing-review.js';

gulp.task('script-vendor', function() {
    gulp.src([
        jquery_ui,
        muploader,
        jquery_magnific_popup,
        jquery_flexslider,
        jquery_raty,
        me_user_profile,
        me_tag_box,
        me_post_listing,
        me_me_sliderthumbs,
        me_script,
        me_message,
        me_index,
        me_my_listings,
        me_my_listings,
        me_listing_review
    ])
    .pipe(uglify())
    .pipe(strip_comments())
    .pipe(concat("me.vendor.js"))
    .pipe(gulp.dest(me_vendor_dest));
});

/**
 * Watcher
 */
gulp.task('watch', function() {
    gulp.watch(sassPathPlugin, ['sass']).on('change', browserSync.reload);
    gulp.watch(jsPathPlugin, ['scripts']).on('change', browserSync.reload);
    gulp.watch("plugin/**/*.html").on('change', browserSync.reload);
});