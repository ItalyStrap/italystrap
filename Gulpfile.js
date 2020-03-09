const gulp = require('gulp');
const path = require('path');
const fs = require('fs');
const pkg = JSON.parse(fs.readFileSync('./package.json'));
const compass = require('gulp-compass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const pixrem = require('pixrem');
const sourcemaps = require('gulp-sourcemaps');

const gulpCopy = require('gulp-copy');
const zip = require('gulp-zip');
var clean = require('gulp-clean');

const italystrap_theme = [
    '**', // All

    /**
     * Directories
     */
    '!.git/**',
    '!.sass-cache/**',
    '!node_modules/**',
    '!backups/**',
    '!bower/**',
    '!**/test*/**',
    '!future-inclusions/**',
    '!sass/**',
    '!css/src/**',
    '!js/src/**',
    '!_others',
    '!_template/**',

    /**
     * Files
     */
    '!codecept',
    '!.gitattributes',
    '!.gitignore',
    '!snippets.md',
    '!bower.json',
    '!Gruntfile.js',
    '!Gulpfile.js',
    '!package.json',
    '!package-look.json',
    '!*.bat',
    '!*.lock',
    '!*.yml',
    '!*.zip',
    '!**/*.map',
    '!*.xml',
    '!*.dist',
    '!c3.php',
];

gulp.task('compass', function() {
    return gulp.src('./assets/sass/*.scss')
        .pipe(compass({
            project: path.join(__dirname, 'assets'),
            import_path: __dirname + '/bower/bootstrap-sass/assets/stylesheets',
            css: 'css/src',
            sass: 'sass'
        }));
});

gulp.task('postcss', function () {
    const browser = {
        overrideBrowserslist: ['last 2 version']
    };

    const plugins = [
        autoprefixer(browser),
        pixrem(browser),
        cssnano({
            preset: ['default', {
                discardComments: {
                    removeAll: true,
                },
            }]
        })
    ];

    return gulp.src('./assets/css/src/*.css')
        .pipe(sourcemaps.init())
        .pipe(postcss(plugins))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('copyTemp', function () {
    return gulp
        .src(italystrap_theme)
        // .src('src/**')
        .pipe(gulpCopy('../temp/' + pkg.name, {}));
});

gulp.task('compress', function () {
    return gulp.src('../temp/**')
        .pipe(zip(pkg.name + ' ' + pkg.version + '-archive.zip', {}))
        .pipe(gulp.dest('../'));
});
gulp.task('cleanTemp', function () {
    return gulp.src('../temp', {read: false})
        .pipe(clean({force: true}));
});

gulp.task('css', gulp.series('compass','postcss'));
gulp.task('zip', gulp.series('copyTemp','compress','cleanTemp'));

gulp.task('default', gulp.series('compass','postcss'));

gulp.task('watch', function() {
    gulp.watch(['./assets/sass/*.scss'], gulp.series('css'));
});