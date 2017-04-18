var bower_path = 'bower/';
var bootstrap_path = bower_path + 'bootstrap-sass/assets/';
var bootstrap_js_path = bootstrap_path + 'javascripts/bootstrap/';
var bootstrap_fonts_path = bootstrap_path + 'fonts/bootstrap/';

module.exports = function(grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        /**
         * Update all bower dependency
         * $ grunt bower
         */
        // bower: { // https://www.npmjs.com/package/grunt-bower-installer
        //     install: {
        //         options: {
        //             copy: false,
        //         bowerOptions: {
        //             forceLatest: true,
        //             //production: true
        //             }      
        //         } 
        //     }
        // },

        /**
         * Copy updated dependency
         * $ grunt copy
         */
        copy: { // https://github.com/gruntjs/grunt-contrib-copy
            bootstrapfonts: {
                expand: true, // https://github.com/gruntjs/grunt-contrib-copy/issues/90
                cwd: bootstrap_fonts_path,
                src: ['**'],
                dest: 'fonts/',
                filter: 'isFile',
            },
            jquery: {
                expand: true, // https://github.com/gruntjs/grunt-contrib-copy/issues/90
                cwd: bower_path + 'jquery/dist/',
                src: ['jquery.min.js'],
                dest: 'js/',
                filter: 'isFile',
            },
        },

        uglify: { // https://github.com/gruntjs/grunt-contrib-uglify
            admin: {
              files: [{
                  expand: true,
                  cwd: 'admin/js/src',
                  src: '*.js',
                  dest: 'admin/js'
              }]
            },
            dist: {
                options: {
                    sourceMap: true
                    // ,beautify: true
                },
                files: {
                    'js/home.min.js': [
                        bootstrap_js_path + 'transition.js',
                        bootstrap_js_path + 'alert.js',
                        bootstrap_js_path + 'button.js',
                        bootstrap_js_path + 'carousel.js',
                        bootstrap_js_path + 'collapse.js',
                        bootstrap_js_path + 'dropdown.js',
                        bootstrap_js_path + 'modal.js',
                        bootstrap_js_path + 'tooltip.js',
                        bootstrap_js_path + 'popover.js',
                        bootstrap_js_path + 'scrollspy.js',
                        bootstrap_js_path + 'tab.js',
                        bootstrap_js_path + 'affix.js',
                        'js/src/home.js' // <- Modify this
                    ],

                    'js/singular.min.js': [
                        bootstrap_js_path + 'transition.js',
                        bootstrap_js_path + 'alert.js',
                        bootstrap_js_path + 'button.js',
                        bootstrap_js_path + 'carousel.js',
                        bootstrap_js_path + 'collapse.js',
                        bootstrap_js_path + 'dropdown.js',
                        bootstrap_js_path + 'modal.js',
                        bootstrap_js_path + 'tooltip.js',
                        bootstrap_js_path + 'popover.js',
                        bootstrap_js_path + 'scrollspy.js',
                        bootstrap_js_path + 'tab.js',
                        bootstrap_js_path + 'affix.js',
                        'js/src/singular.js' // <- Modify this
                    ],

                    'js/archive.min.js': [
                        bootstrap_js_path + 'transition.js',
                        bootstrap_js_path + 'alert.js',
                        bootstrap_js_path + 'button.js',
                        bootstrap_js_path + 'carousel.js',
                        bootstrap_js_path + 'collapse.js',
                        bootstrap_js_path + 'dropdown.js',
                        bootstrap_js_path + 'modal.js',
                        bootstrap_js_path + 'tooltip.js',
                        bootstrap_js_path + 'popover.js',
                        bootstrap_js_path + 'scrollspy.js',
                        bootstrap_js_path + 'tab.js',
                        bootstrap_js_path + 'affix.js',
                        'js/src/archive.js' // <- Modify this
                    ],

                    'js/custom.min.js': [
                        bootstrap_js_path + 'transition.js',
                        bootstrap_js_path + 'alert.js',
                        bootstrap_js_path + 'button.js',
                        bootstrap_js_path + 'carousel.js',
                        bootstrap_js_path + 'collapse.js',
                        bootstrap_js_path + 'dropdown.js',
                        bootstrap_js_path + 'modal.js',
                        bootstrap_js_path + 'tooltip.js',
                        bootstrap_js_path + 'popover.js',
                        bootstrap_js_path + 'scrollspy.js',
                        bootstrap_js_path + 'tab.js',
                        bootstrap_js_path + 'affix.js',
                        'js/src/custom.js' // <- Modify this
                    ],                   
                }
            }
        },

        jshint: {
            all: [
                'Gruntfile.js',
                'js/src/*.js',
                'js/bootstrap.min.js',
                '!js/jquery.min.js'
            ],
            options: true,
        },

        compass:{ // https://github.com/gruntjs/grunt-contrib-compass
            dev:{
                options: {
                    sassDir:['sass'],
                    cssDir:['css/src'],
                    environment: 'development',
                    // sourcemap: true,
                    importPath: 'bower/bootstrap-sass/assets/stylesheets'
                }
            },
            dist:{
                options: {
                    sassDir:['sass'],
                    cssDir:['css'],
                    outputStyle: 'compressed',
                    importPath: 'bower/bootstrap-sass/assets/stylesheets'
                }
            }
        },

        /**
         * LESS IS DEPRECATED, USE COMPASS
         *
         * @type {Object}
         */
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
            files: ['css/src/*.css', '!css/bootstrap.min.css',],
            options: {
                csslintrc: '.csslintrc'
            }
        },

        /**
         * Workflow for deploy
         */
        
        gitcheckout: {
            devtomaster: { // Mi sposto da Dev a master
                options: {
                    branch: 'master'
                }
            },
            mastertodev: { // Mi sposto da master a Dev
                options: {
                    branch: 'Dev'
                }
            }
        },

        gitmerge: {
            fromdev: { // Prima devo essere in master e poi fare il merge da Dev
                options: {
                    branch: 'Dev'
                }
            },
            frommaster: { // Prima devo essere in dev e poi fare il merge sa master
                options: {
                    branch: 'master'
                }
            }
        },

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
                        '*.json', //For now bower it is not uploaded
                        '*.txt',
                        '*.md',
                        '*.php',
                        '*.js',
                        '*.css'
                    ]
                }
            },
            first:{
                options: {
                    message: 'Commit before deploy of new version'
                },
                files: {
                    src: [
                        '*.json', //For now bower it is not uploaded
                        '*.txt',
                        '*.md',
                        '*.php',
                        '*.js',
                        '*.css'
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
                            '!tests/**',
                            '!.gitattributes',
                            '!.gitignore',
                            // '!bower.json',
                            // '!Gruntfile.js',
                            // '!package.json',
                            '!*.zip'], // What should be included in the zip
                        dest: 'italystrap/',        // Where the zipfile should go
                        filter: 'isFile',
                    },
                ]
            },
            backup: {
                options: {
                    archive: '../<%= pkg.name %> <%= pkg.version %> backup.zip' // Create zip file in theme directory
                },
                files: [
                    {
                        src: [
                            '**' ,
                            '!.git/**',
                            '!.sass-cache/**',
                            '!bower_components/**',
                            '!node_modules/**',
                            '!.gitattributes',
                            '!.gitignore',
                            // '!bower.json',
                            // '!Gruntfile.js',
                            // '!package.json',
                            '!*.zip'], // What should be included in the zip
                        dest: 'italystrap/',        // Where the zipfile should go
                        // dest: 'italystrap/',        // Where the zipfile should go
                        filter: 'isFile',
                    },
                ]
            },
            test: {
                options: {
                    archive: '../<%= pkg.name %> <%= pkg.version %> test.zip' // Create zip file in theme directory
                },
                files: [
                    {
                        src: [
                            '**' ,
                            '!.git/**',
                            '!.sass-cache/**',
                            '!bower_components/**',
                            '!node_modules/**',
                            '!.gitattributes',
                            '!.gitignore',
                            '!bower.json',
                            '!Gruntfile.js',
                            '!package.json',
                            '!codeception.yml',
                            '!composer.json',
                            '!composer.lock',
                            '!phpunit.xml',
                            '!test_italystrap.php',
                            '!wp-tests-config.php',
                            '!snippets.md',
                            '!tests/**',
                            '!future-inclusions/**',
                            '!*.zip'], // What should be included in the zip
                        dest: 'italystrap/',        // Where the zipfile should go
                        filter: 'isFile',
                    },
                ]
            }
        },

        "github-release": { // https://github.com/dolbyzerr/grunt-github-releaser
            options: {
                repository: 'overclokk/ItalyStrap', // Path to repository
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
                livereload: 9001,
            },
        },

    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.loadNpmTasks('grunt-bower-installer');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.loadNpmTasks('grunt-version');
    grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
    grunt.loadNpmTasks('grunt-git');
    grunt.loadNpmTasks('grunt-prompt');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-github-releaser');

    // https://github.com/tkadlec/grunt-perfbudget
    grunt.loadNpmTasks('grunt-perfbudget');

    /**
     * Check grunt plugin update
     * @link https://www.npmjs.com/package/npm-check-updates
     *
     * Show any new dependencies for the project in the current directory:
     * $ npm-check-updates
     *
     * Upgrade a project's package.json:
     * $ npm-check-updates -u
     *
     * Install update
     * $ npm install
     */
    
    /**
     * Update and copy bower dependency
     */
    // grunt.registerTask('update', [
    //                             'bower',
    //                             'copy',
    //                             'compass',
    //                             'uglify'
    //                             ]);

    /**
     * Verify new line in pot file
     */

    /**
     * My workflow when the all files are committed and the new version has to be created
     *
     * Add another step to workflow
     * First aff all check all update files with bower
     * 
     * $ cd bower
     * $ bower update
     * $ grunt copy (if bower has updated som files)
     * $ cd..
     * $ grunt less (in case bootstrap has been updated)
     * $ grunt uglify (in case bootstrap has been updated)
     * And commit new update
     *
     * Merge Dev to Master
     * Checkout in master (not dev)
     * Update description and changelog only in readme.txt
     * Change only version in package.json
     * $ grunt deploy
     * Merge Master to Dev
     */
    // grunt.registerTask('deploy',
    //     [
    //     'version',
    //     'wp_readme_to_markdown',
    //     'gitcommit',
    //     'gitpush',
    //     'prompt',
    //     'compress',
    //     'github-release',
    //     ]
    // );

    grunt.registerTask('deploy',
        [
        'gitcommit:first',
        'gitcheckout:devtomaster',
        'gitmerge:fromdev',
        'version',
        'wp_readme_to_markdown',
        'gitcommit:version',
        'gitpush',
        'prompt',
        'compress:main',
        'github-release',
        // 'clean',
        // 'copy',
        'gitcheckout:mastertodev',
        'gitmerge:frommaster',
        'gitpush',
        // 'update-no-dev',
        ]
    );

    grunt.registerTask('release',
        [
        // 'version',
        // 'wp_readme_to_markdown',
        'prompt',
        'compress',
        'github-release',
        ]
    );
    
    grunt.registerTask('testcssbuild', ['compass', 'csslint']);
    grunt.registerTask('testjsbuild', ['jshint', 'uglify']);

    // After botstrap update execute "grunt bootstrap"
    grunt.registerTask('bootstrap', ['uglify:bootstrapJS', 'compass']);


    grunt.registerTask('test', ['jshint', 'csslint']);
    grunt.registerTask('build', ['uglify', 'compass']);

    grunt.registerTask('php', 'A sample task that logs stuff.', function() {
        return null;
    });

    grunt.event.on('watch', function(action, filepath) {
      grunt.log.writeln(filepath + ' has ' + action);
    });

};