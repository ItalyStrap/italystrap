'use strict';
module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            dist: {
                files: {
                    'js/home.min.js': [
                        'js/src/bootstrapJS/transition.js',
                        // 'js/src/bootstrapJS/alert.js',
                        // 'js/src/bootstrapJS/button.js',
                        'js/src/bootstrapJS/carousel.js',
                        'js/src/bootstrapJS/collapse.js',
                        'js/src/bootstrapJS/dropdown.js',
                        // 'js/src/bootstrapJS/modal.js',
                        // 'js/src/bootstrapJS/tooltip.js',
                        // 'js/src/bootstrapJS/popover.js',
                        // 'js/src/bootstrapJS/scrollspy.js',
                        // 'js/src/bootstrapJS/tab.js',
                        // 'js/src/bootstrapJS/affix.js',
                        'js/src/home.js' // <- Modify this
                    ],

                    'js/singular.min.js': [
                        'js/src/bootstrapJS/transition.js',
                        'js/src/bootstrapJS/alert.js',
                        'js/src/bootstrapJS/button.js',
                        'js/src/bootstrapJS/carousel.js',
                        'js/src/bootstrapJS/collapse.js',
                        'js/src/bootstrapJS/dropdown.js',
                        'js/src/bootstrapJS/modal.js',
                        'js/src/bootstrapJS/tooltip.js',
                        'js/src/bootstrapJS/popover.js',
                        'js/src/bootstrapJS/scrollspy.js',
                        'js/src/bootstrapJS/tab.js',
                        'js/src/bootstrapJS/affix.js',
                        'js/src/singular.js' // <- Modify this
                    ],

                    'js/archive.min.js': [
                        'js/src/bootstrapJS/transition.js',
                        'js/src/bootstrapJS/alert.js',
                        'js/src/bootstrapJS/button.js',
                        'js/src/bootstrapJS/carousel.js',
                        'js/src/bootstrapJS/collapse.js',
                        'js/src/bootstrapJS/dropdown.js',
                        'js/src/bootstrapJS/modal.js',
                        'js/src/bootstrapJS/tooltip.js',
                        'js/src/bootstrapJS/popover.js',
                        'js/src/bootstrapJS/scrollspy.js',
                        'js/src/bootstrapJS/tab.js',
                        'js/src/bootstrapJS/affix.js',
                        'js/src/archive.js' // <- Modify this
                    ],

                    'js/custom.min.js': [
                        'js/src/bootstrapJS/transition.js',
                        'js/src/bootstrapJS/alert.js',
                        'js/src/bootstrapJS/button.js',
                        'js/src/bootstrapJS/carousel.js',
                        'js/src/bootstrapJS/collapse.js',
                        'js/src/bootstrapJS/dropdown.js',
                        'js/src/bootstrapJS/modal.js',
                        'js/src/bootstrapJS/tooltip.js',
                        'js/src/bootstrapJS/popover.js',
                        'js/src/bootstrapJS/scrollspy.js',
                        'js/src/bootstrapJS/tab.js',
                        'js/src/bootstrapJS/affix.js',
                        'js/src/custom.js' // <- Modify this
                    ],                   
                }
            }
        },

        jshint: {
            all: [
                'js/src/*.js',
                '!js/bootstrap.min.js',
                '!js/jquery.min.js'
            ]
        },

        compass:{ // https://github.com/gruntjs/grunt-contrib-compass
            src:{
                options: {
                    sassDir:['css/src/sass'],
                    cssDir:['css'],
                    outputStyle: 'compressed'
                }
            },
        },

        less: { // https://github.com/gruntjs/grunt-contrib-less
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    'css/bootstrap.min.css': [
                        'css/src/less/bootstrap.less'
                        ],
                  }
            }
        },

        csslint: { // http://astainforth.com/blogs/grunt-part-2
            files: ['css/*.css', '!css/bootstrap.min.css',],
            options: {
                "important": false,
                "ids": false,
            }
        },

        /**
         * Workflow for deploy
         */
        version: {  // https://www.npmjs.com/package/grunt-version
                    // http://jayj.dk/using-grunt-automate-theme-releases/
            bower: {
                src: [ 'bower.json' ],
            },
            css: {
                options: {
                    prefix: 'Version\\:\\s'
                },
                src: [ 'style.css' ],
            },
            readme: {
                options: {
                    prefix: 'Stable tag\\:\\s'
                },
                  src: ['readme.txt']
            },
        },

        wp_readme_to_markdown: { // https://www.npmjs.com/package/grunt-wp-readme-to-markdown
            readme: {
                files: {
                  'README.md': 'readme.txt'
                },
            },
        },

        gitcommit: { // https://www.npmjs.com/package/grunt-git
            version: {
                options: {
                    message: 'New version: <%= pkg.version %>'
                },
                files: {
                    // Specify the files you want to commit
                    src: [
                        'bower.json',
                        'style.css',
                        'readme.txt',
                        'package.json',
                        // 'functions.php'
                        ]
                }
            }
        },

        gitpush: { // https://www.npmjs.com/package/grunt-git
            version: {},
        },

        prompt: { // https://github.com/dylang/grunt-prompt
            target: {
                options: {
                    questions: [
                        {
                        config: 'github-release.options.auth.user', // set the user to whatever is typed for this question
                        type: 'input',
                        message: 'GitHub username:'
                        },
                        {
                        config: 'github-release.options.auth.password', // set the password to whatever is typed for this question
                        type: 'password',
                        message: 'GitHub password:'
                        }
                    ]
                }
            }
        },

        compress: { // https://github.com/gruntjs/grunt-contrib-compress
            main: {
                options: {
                    archive: '../<%= pkg.name %> <%= pkg.version %>.zip' // Create zip file in theme directory
                },
                files: [
                    {
                        src: [
                            '**' ,
                            '!.git/**',
                            '!.sass-cache/**',
                            '!bower/**',
                            '!node_modules/**',
                            '!.gitattributes',
                            '!.gitignore',
                            // '!bower.json',
                            // '!Gruntfile.js',
                            // '!package.json',
                            '!*.zip'], // What should be included in the zip
                        dest: '<%= pkg.name %>/',        // Where the zipfile should go
                        filter: 'isFile',
                    },
                ]
            }
        },

        "github-release": { // https://github.com/dolbyzerr/grunt-github-releaser
            options: {
                repository: 'overclokk/test', // Path to repository
                release: {
                    name: '<%= pkg.name %> <%= pkg.version %>',
                    body: '## New release of <%= pkg.name %> <%= pkg.version %> \nSee the **[changelog](https://github.com/overclokk/ItalyStrap#changelog)**',
                }
            },
            files: {
                src: ['../<%= pkg.name %> <%= pkg.version %>.zip'] // Files that you want to attach to Release
            }

        },

        watch: { // https://github.com/gruntjs/grunt-contrib-watch
            css: {
                files: ['**/*.{scss,sass}'],
                tasks: ['testcssbuild'],
            },
            js: {
                files: ['src/js/*.js'],
                tasks: ['testjsbuild'],
            },
            options: {
                livereload: 9000,
            },
        },

    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-version');
    grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
    grunt.loadNpmTasks('grunt-git');
    grunt.loadNpmTasks('grunt-prompt');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-github-releaser');

    /**
     * Check grunt plugin update
     * @link https://www.npmjs.com/package/npm-check-updates
     *
     * Show any new dependencies for the project in the current directory:
     * $ npm-check-updates
     *
     * Upgrade a project's package.json:
     * $ npm-check-updates -u
     */

    /**
     * My workflow when the all files are committed and the new version has to be created
     * Update description only in readme.txt
     * Change only version in package.json
     */
    grunt.registerTask('deploy', [
                                'version',
                                'wp_readme_to_markdown',
                                'gitcommit',
                                'gitpush',
                                'prompt',
                                'compress',
                                'github-release',
                                ]);


    grunt.registerTask('testcssbuild', ['less', 'compass', 'csslint']);
    grunt.registerTask('testjsbuild', ['jshint', 'uglify']);

    // After botstrap update execute "grunt bootstrap"
    grunt.registerTask('bootstrap', ['uglify:bootstrapJS', 'less']);


    grunt.registerTask('test', ['jshint', 'csslint']);
    grunt.registerTask('build', ['uglify', 'less', 'compass']);

    grunt.event.on('watch', function(action, filepath) {
      grunt.log.writeln(filepath + ' has ' + action);
    });

}