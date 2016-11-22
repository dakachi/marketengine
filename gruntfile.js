module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        phpunit: {
            marketenginetest: {
                configuration: './phpunit.xml'
            },
            options: {
                bin: './vendor/bin/phpunit',
                bootstrap: './bootstrap.php',
                colors: true,
                // coverageClover : true,
                // coverage : true
            }
        },
        compress: {
            main: {
                options: {
                    archive: 'marketengine.zip'
                },
                files: [
                    {expand: true, src: ['./*.php', './admin/**', './assets/**', './includes/**','./languages/**', './sample-data/**', './templates/**'], dest: './'}
                ]
            }
        },
        watch: {
            phpunit: {
                files: ['tests/*/*.php', 'tests/*.php', 'includes/*.php', 'includes/*/*.php'],
                tasks: ['phpunit']
            }
        }
    });
    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // Default task(s).
    grunt.registerTask('default', ['phpunit']);
};