const gulp = require('gulp');
const zip = require('gulp-zip');
const del = require('del');


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
			src: 'E:/xampp/htdocs/sites/wp-content/plugins/zeroengine/',
			version: '2.0',
			struct: [
				'**',
				'!.git/**',
				'!tests/**',
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
			src: 'C:/xampp/htdocs/sites/wp-content/themes/zeroengine/',
			version: '1.0',
			struct: [
				'**',
				'!.git/**',
				'!README.md',
			],
		},
	},
}
const dist = 'backups/';

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

var get_task_dist = function(folder = '') {
	var task_dist = dist + folder + '/' + curr_project.settings.slug + '/';
	return task_dist;
}

gulp.task('clean:dist', () => {
	var task_dist = get_task_dist();

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

var sys = require('sys');
// var gutil = require('gulp-util');
var exec = require('gulp-exec');

gulp.task('phpunit', function() {
    gulp.src('tests').pipe(
        exec('phpunit --bootstrap ' + curr_project.settings.src + ' bootstrap.php -c phpunit.xml tests/', function(error, stdout){
            console.log(stdout);
            return false;
        })
    );
});

gulp.task('watch', function () {
    gulp.watch('**/*.php', ['phpunit']);
});

gulp.task('default', ['watch']);