'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');

var Eyeglass = require('eyeglass').Eyeglass;

var eyeglass = new Eyeglass({
    includePaths: require('node-bourbon').includePaths,
    importer: function(uri, prev, done) {
        done(sass.compiler.types.NULL);
    }
});

// Disable import once with gulp until we
// figure out how to make them work together.
eyeglass.enableImportOnce = false

gulp.task('sass:prod', function () {
  gulp.src('./sass/**/*.scss')
    .pipe(sass(eyeglass.sassOptions()).on("error", sass.logError))
    .pipe(autoprefixer({
       browsers: ['last 2 version']
    }))
    .pipe(gulp.dest('./css'));
});

gulp.task('sass:dev', function () {
  gulp.src('./sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass(eyeglass.sassOptions()).on("error", sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 version']
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./css'));
});

gulp.task('lr', function () {
    gulp.src('./css/*.css')
        .pipe(livereload());
});


gulp.task('sass:watch', function () {
  livereload.listen();
    gulp.watch('./sass/**/*.scss', ['sass:dev']);
    gulp.watch('./css/**/*.css', ['lr']);
});

gulp.task('default', ['sass:dev', 'sass:watch']);
