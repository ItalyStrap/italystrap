const gulp = require('gulp');
const path = require('path');
const compass = require('gulp-compass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const pixrem = require('pixrem');
const sourcemaps = require('gulp-sourcemaps');

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

gulp.task('css', gulp.series('compass','postcss'));
gulp.task('default', gulp.series('compass','postcss'));

gulp.task('watch', function() {
    gulp.watch(['./assets/sass/*.scss'], gulp.series('css'));
});