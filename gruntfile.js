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
        pot: {
            options: {
                // Specify options 
                text_domain: "enginethemes",
                keywords: ['__', '_e', '_x', '_n', '_ex', '_nx', 'esc_attr__', 'esc_attr_e', 'esc_attr_x', 'esc_html__', 'esc_html_e', 'esc_html_x', '_nx_noop'],
                dest: 'languages/',
            },
            files: {
                // Specify files to scan 
                expand: true,
                src: ['./*.php', './admin/**', './includes/**', './languages/**', './sample-data/**', './templates/**'],
            },
        },
        compress: {
            main: {
                options: {
                    archive: 'marketengine.zip'
                },
                files: [{
                    expand: true,
                    src: ['./*.php', './admin/**', './assets/**', './includes/**', './languages/**', './sample-data/**', './templates/**'],
                    dest: './'
                }]
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
    grunt.loadNpmTasks('grunt-pot');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // Default task(s).
    grunt.registerTask('default', ['phpunit']);
};