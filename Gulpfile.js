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

const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');

const gulpCopy = require('gulp-copy');
const zip = require('gulp-zip');
const clean = require('gulp-clean');

const theme_src = [
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
    '!**/sass/**',
    '!**/css/src/**',
    '!**/js/src/**',
    '!**/img/src/**',
    '!**/img/svg/**',
    '!_others/**',
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

gulp.task('imagemin', function () {
    return gulp.src('assets/img/src/*')
        .pipe(imagemin(
            [
                imagemin.gifsicle({interlaced: true}),
                imagemin.mozjpeg({quality: 75, progressive: true}),
                imagemin.optipng({optimizationLevel: 5}),
                imagemin.svgo({
                    plugins: [
                        {removeViewBox: true},
                        {cleanupIDs: false}
                    ]
                }),
            ]
        ))
        .pipe(gulp.dest('assets/img'));
});
gulp.task('webp', function () {
    return gulp.src('assets/img/*')
        .pipe(webp({quality: 50}))
        .pipe(gulp.dest('assets/img'));
});

gulp.task('copyTemp', function () {
    return gulp
        .src(theme_src)
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
gulp.task('img', gulp.series('imagemin','webp'));

gulp.task('zip', gulp.series('copyTemp','compress','cleanTemp'));

gulp.task('build', gulp.series('css','img','zip'));

gulp.task('watch', function() {
    gulp.watch(['./assets/sass/*.scss'], gulp.series('css'));
    gulp.watch(['./assets/img/src/*'], gulp.series('img'));
});

gulp.task('default', gulp.series('watch'));