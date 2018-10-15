'use strict';
(function() {
	var util = require('gulp-util');
	var run	= require('run-sequence');
	var bs 	= require('browser-sync').create();
	var gulp = require('gulp');
	var watch = require('gulp-watch');
	var plumber = require('gulp-plumber');
	var sourcemaps = require('gulp-sourcemaps');
	var sass = require('gulp-sass');
	var autoprefixer = require('gulp-autoprefixer');
	var concat = require('gulp-concat');
	var uglify = require('gulp-uglify');
	var changed = require('gulp-changed');

	function errorHandler(error) {
		util.beep();
		util.beep();
		util.beep();
		console.log(error.toString());
		return true;
	}

	var refreshFunction = function () {
		bs.reload();
		return;
	}

	var sassPublicFunction = function() {
		gulp.src('./resources/_dev/public/styles/**/*')
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed',
			includePaths: [
			]
		}))
		.pipe(autoprefixer({
			browsers: ['last 2 versions']
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(plumber.stop())
		.pipe(gulp.dest('./resources/'))
		.pipe(bs.stream({match: '**/*.css'}));
	};

	var jsPublicFunction = function() {
		gulp.src([
				'./resources/_dev/public/scripts/**/*.js',
			])
			.pipe(plumber(errorHandler))
			.pipe(sourcemaps.init())
			.pipe(concat('script.js'))
			.pipe(uglify())
			.pipe(sourcemaps.write('./'))
			.pipe(plumber.stop())
			.pipe(gulp.dest('./resources/'))
			.pipe(bs.stream());
	};

	var sassAdminFunction = function() {
		gulp.src('./resources/_dev/admin/styles/**/*')
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed',
			includePaths: [
			]
		}))
		.pipe(autoprefixer({
			browsers: ['last 2 versions']
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(plumber.stop())
		.pipe(gulp.dest('./resources/'))
		.pipe(bs.stream({match: '**/*.css'}));
	};

	var jsAdminFunction = function() {
		gulp.src([
			'./resources/_dev/admin/scripts/**/*.js',
		])
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(concat('admin.js'))
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(plumber.stop())
		.pipe(gulp.dest('./resources/'))
		.pipe(bs.stream());
	};

	gulp.task('sass-public', sassPublicFunction);
	gulp.task('js-public', jsPublicFunction);
	gulp.task('sass-admin', sassAdminFunction);
	gulp.task('js-admin', jsAdminFunction);
	
	gulp.task(
		'default', 
		['sass-public', 'js-public', 'sass-admin', 'js-admin'], 
		function() {
			bs.init({
				proxy: 'localhost/'
			});
			watch('./resources/_dev/public/styles/**/*', sassPublicFunction);
			watch('./resources/_dev/public/scripts/**/*.js', jsPublicFunction);
			watch('./resources/_dev/admin/styles/**/*', sassAdminFunction);
			watch('./resources/_dev/admin/scripts/**/*.js', jsAdminFunction);
			watch(['./application/*.php', './application/**/*.php'], refreshFunction);
		}
	);
})();