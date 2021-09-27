const bower_path = 'bower/';
const bootstrap_path = bower_path + 'bootstrap-sass/assets/';
const bootstrap_js_path = bootstrap_path + 'javascripts/bootstrap/';
const bootstrap_fonts_path = bootstrap_path + 'fonts/bootstrap/';

const config = require( './assets/tasks/config' );

const BOOTSTRAP_JS_FILES = [
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
];

module.exports = grunt => {
	'use strict';

	/**
	 * https://www.npmjs.com/package/load-grunt-tasks
	 */
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

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
		},

		ts: {
			default: {
				src: ['assets/ts/index.ts'],
			},
		},

		uglify: { // https://github.com/gruntjs/grunt-contrib-uglify
			src: {
				options: {
					sourceMap: true,
					beautify: true,
					mangle: false,
				},
				files: {
					'assets/js/index.js': [
						...BOOTSTRAP_JS_FILES,
						'assets/ts/index.js' // <- Modify this
					],
				}
			},
			dist: {
				files: {
					'assets/js/index.min.js': [
						...BOOTSTRAP_JS_FILES,
						'assets/ts/index.js' // <- Modify this
					],                   
				}
			}
		},

		jshint: {
			all: [
				'Gruntfile.js',
				'assets/js/*.js',
			],
			options: true,
		},

		compass:{ // https://github.com/gruntjs/grunt-contrib-compass
			options: {
				force:true,
				sassDir:'assets/sass',
				cssDir:'assets/css',
				imagesDir:'assets/img',
				relativeAssets: true,
				// fontsPath: './assets/fonts/',
				// fontsDir: '../fonts/',
				// importPath: bootstrap_path,
			},
			dist:{
				options: {
					environment: 'production',
					specify: [
						'assets/sass/*.min.scss',
					],
					// importPath: 'bower/bootstrap-sass/assets/stylesheets'
				}
			},
			dev:{
				options: {
					sourcemap: true,
					specify: [
						'assets/sass/*.scss',
						'!assets/sass/*.min.scss',
					],
					// importPath: 'bower/bootstrap-sass/assets/stylesheets'
				}
			},
		},

		/**
		 * https://github.com/nDmitry/grunt-postcss
		 */
		postcss: {
			options: {
				processors: [
					require('pixrem')(), // add fallbacks for rem units
					require('autoprefixer')({overrideBrowserslist: 'last 5 versions'}), // add vendor prefixes
					require('cssnano')() // minify the result
				]
			},
			dist: {
				src: 'assets/css/*.min.css'
			}
		},

		csslint: { // http://astainforth.com/blogs/grunt-part-2
			files: ['assets/css/src/*.css'],
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
					message: 'Commit before deploy a new version'
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

		exec: { // https://github.com/jharding/grunt-exec
			composer_update: 'composer update --no-dev && composer dumpautoload -o',
			composer_update_dev: 'composer update && composer dumpautoload',
			unit: 'codecept run unit --debug',
			wpunit: 'codecept run wpunit --debug',
		},

		compress: { // https://github.com/gruntjs/grunt-contrib-compress
			main: {
				options: {
					archive: '../<%= pkg.name %> <%= pkg.version %>.zip' // Create zip file in theme directory
				},
				files: [
					{
						src: config.files, // What should be included in the zip
						dest: '<%= pkg.name %>/',        // Where the zipfile should go
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
						src: config.files, // What should be included in the zip
						dest: '<%= pkg.name %>/',        // Where the zipfile should go
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
						src: config.files, // What should be included in the zip
						dest: '<%= pkg.name %>/',        // Where the zipfile should go
						filter: 'isFile',
					},
				]
			}
		},

		"github-release": { // https://github.com/dolbyzerr/grunt-github-releaser
			options: {
				repository: 'ItalyStrap/<%= pkg.name %>', // Path to repository
				release: {
					name: '<%= pkg.name %> <%= pkg.version %>',
					body: '## New release of <%= pkg.name %> <%= pkg.version %> \nSee the **[changelog](https://github.com/ItalyStrap/<%= pkg.name %>#changelog)**',
					prerelease: true,
				}
			},
			files: {
				src: ['../<%= pkg.name %> <%= pkg.version %>.zip'] // Files that you want to attach to Release
			}

		},

		watch: { // https://github.com/gruntjs/grunt-contrib-watch
			unit: {
				files: [
					'tests/unit/**/*.php',
					'src/**/*.php',
					'functions/**/*.php',
				],
				tasks: ['exec:unit'],
			},
			wpunit: {
				files: [
					'tests/wpunit/**/*.php',
					// 'src/**/*.php',
					// 'functions/**/*.php',
				],
				tasks: ['exec:wpunit'],
			},
			css: {
				files: ['assets/sass/**/*.{scss,sass}'],
				tasks: ['css'],
			},
			js: {
				files: ['assets/ts/*.js'],
				tasks: ['js'],
			},
			options: {
				livereload: 9001,
			},
		},

	});

	// // https://github.com/tkadlec/grunt-perfbudget
	// grunt.loadNpmTasks('grunt-perfbudget');

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


	grunt.registerTask('default', ['watch']);

	/**
	 * ========================================
	 * REMEMBER:
	 * Delete prerelease in case stable version
	 * will be released
	 * ========================================
	 */

	grunt.registerTask(
		'deploy',
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
	
	grunt.registerTask(
		'css',
		[
			'compass',
			'postcss'
		]
	);
	
	grunt.registerTask(
		'js',
		['ts', 'uglify']
	);

	grunt.registerTask('testcssbuild', ['compass', 'csslint']);
	grunt.registerTask('testjsbuild', ['jshint', 'uglify']);

	// After botstrap update execute "grunt bootstrap"
	grunt.registerTask('bootstrap', ['uglify:bootstrapJS', 'compass']);


	grunt.registerTask('readme', ['wp_readme_to_markdown']);


	grunt.registerTask('test', ['jshint', 'csslint']);
	grunt.registerTask('build', ['uglify', 'compass']);

	grunt.registerTask('php', 'A sample task that logs stuff.', function() {
		return null;
	});

	grunt.event.on('watch', function(action, filepath, target) {
		grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
	});

};