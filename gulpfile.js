const gulp = require('gulp');
const zip = require('gulp-zip');
const del = require('del');

// var gulp 				= require('gulp');
// var sass 				= require('gulp-sass');
// var minifyCSS 			= require('gulp-minify-css');
var concat 				= require('gulp-concat');
// var rename 				= require('gulp-rename');
var uglify 				= require('gulp-uglify');
// var autoprefixer        = require('gulp-autoprefixer');
// var connect             = require('gulp-connect');
// var browserSync 		= require('browser-sync').create();
var strip_comments      = require('gulp-strip-json-comments');

/***************************
 *
 * settings of all projects
 *
 ***************************/
var project = {
	me: {
		settings: {
			name: "MarketEngine",
			slug: 'marketengine',
			src: 'D:/xampp/htdocs/wp/wp-content/plugins/marketengine',
			version: '2.0',
			struct: [
				'**',
				'!.git/**',
				'!tests/**',
				'!wordpress-developer/**',
				'!node_modules/**',
				'!vendor/**',
				'!.gitignore',
				'!bootstrap.php',
				'!composer.json',
				'!package.json',
				'!gruntfile.js',
				'!README.md',
				'!sample-phpunit.xml',
			],
		},
	},
	ze: {
		settings: {
			name: "ZeroEngine",
			slug: 'zeroengine',
			src: 'D:/xampp/htdocs/wp/wp-content/themes/zeroengine',
			version: '1.0',
			struct: [
				'**',
				'!.git/**',
				'!README.md',
			],
		},
	},
}
const dist = '../../backups/';

/* Declare current project */

var curr_project = project.me;

/***************************/


var get_struct = function() {
	var struct = curr_project.settings.struct,
		src = dist + curr_project.settings.slug + "/";
	for( var i = 0; i < struct.length; i++ ) {
		if( i === 0 ) {
			struct[i] = src + struct[i];
			continue;
		}

		if( struct[i].indexOf('!') === 0 ) {
			struct[i] = "!" + src + curr_project.settings.slug + '/' + struct[i].replace('!', '') ;
		} else {
			struct[i] = src + curr_project.settings.slug + '/' + struct[i];
		}
	}
	return struct;
}

var get_task_dist = function(folder) {
	var task_dist = dist + folder + '/' + curr_project.settings.slug + '/';
	return task_dist;
}

gulp.task('clean:dist', () => {
	var task_dist = get_task_dist('');

	return del.sync(task_dist);
})

gulp.task('copy', ['clean:dist'], () => {
	var proj_src = curr_project.settings.src + '**',
		task_dist = get_task_dist(curr_project.settings.slug);

	return gulp.src(proj_src)
		.pipe(gulp.dest(task_dist));
});

gulp.task('zip', ['copy'], () => {
	var settings = curr_project.settings,
		task_dist = get_task_dist('zip'),
		struct = get_struct();

    return gulp.src( struct )
        .pipe(zip(settings.slug + '-v' + settings.version + '.zip'))
        .pipe(gulp.dest(task_dist));
});


var gulp_path = 'C:/xampp/htdocs/gulp/';
var shell = require('gulp-shell');
gulp.task('phpdoc', shell.task([gulp_path + 'vendor/bin/phpdoc -d ' + curr_project.settings.src + ' -t ' + gulp_path + 'docs/phpdoc -i ' + curr_project.settings.src + 'vendor/,node_modules/,tests/,bootstrap.php --template="responsive-twig"']));

var gutil = require('gulp-util');
var exec = require('gulp-exec');

gulp.task('phpunit', function() {
    return gulp.src('tests')
    	.pipe(
    		exec('phpunit --bootstrap ' + curr_project.settings.src + ' bootstrap.php -c ' + curr_project.settings.src + ' tests/phpunit/multisite.xml ' + curr_project.settings.src + 'tests/', function(error, stdout){
            console.log(stdout);
        })
    );
});

var me_vendor_src               = 'assets/js';
var me_vendor_dest              = 'assets/js';

var muploader                   = me_vendor_src + '/muploader.js/';
var jquery_magnific_popup       = me_vendor_src + '/jquery.magnific-popup.min.js';
var jquery_owl_carousel         = me_vendor_src + '/owl.carousel.min.js';
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
var dispute           = me_vendor_src + '/dispute.js';

gulp.task('script-vendor', function() {
    gulp.src([
        muploader,
        jquery_magnific_popup,
        jquery_owl_carousel,
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
        me_listing_review,
        dispute 
    ])
    .pipe(uglify())
    .pipe(strip_comments())
    .pipe(concat("me.vendor.js"))
    .pipe(gulp.dest(me_vendor_dest));
});

gulp.task('watch', function () {
    gulp.watch('**/*.php', ['phpunit']);
    gulp.watch(me_vendor_src, ['script-vendor']);
});

gulp.task('watch', function () {
    gulp.watch('**/*.php', ['phpunit']);
    gulp.watch(me_vendor_src, ['script-vendor']);
});

gulp.task('default', ['watch', 'script-vendor']);