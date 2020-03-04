const gulp = require('gulp');
const path = require('path');
const compass = require('gulp-compass');

gulp.task('compass', function() {
    return gulp.src('.assets/sass/*.scss')
        .pipe(compass({
            project: path.join(__dirname),
            import_path: 'bower/bootstrap-sass/assets/stylesheets',
            css: 'css',
            sass: 'sass'
        }))
        .pipe(gulp.dest('./assets/css'));
});