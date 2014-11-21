var gulp = require('gulp');

var $ = require('gulp-load-plugins')();
var minifyCSS = require('gulp-minify-css');
var gulpif = require("gulp-if");
var sass = require('gulp-ruby-sass');
var browserSync = require('browser-sync');
var config = {
	'development': false
};

var AUTOPREFIXER_BROWSERS = [
'ie >= 9',
'ie_mob >= 10',
'ff >= 30',
'chrome >= 34',
'safari >= 7',
'opera >= 23',
'ios >= 7',
'android >= 4.4',
'bb >= 10'
];

gulp.task('set-development', function() {
	config.development = true;
});

gulp.task('browser-sync', function() {
    browserSync({
        proxy: "avana-knox-henderson.dev"
    });
});

gulp.task('sass', function (){
	gulp.src([
		'assets/sass/main.scss'])
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe(sass({style: 'expanded'}))
	.pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
	.pipe($.concat('main.css'))
	.pipe($.rename({suffix: '.min'}))
	.pipe(gulpif(config.development == false, minifyCSS()))
	.pipe(gulp.dest('assets/css/'))
	.pipe(gulpif(config.development == true, $.notify('SASS compilation complete.')))
	.pipe(gulpif(config.development == true, browserSync.reload({stream: true})));
	// .pipe(gulpif(config.development == true, $.livereload()));
});

gulp.task('javascripts', function(){
	gulp.src([
		'assets/scripts/plugins/*.js',
		'assets/scripts/_*.js',
		'assets/vendor/imagesloaded/imagesloaded.pkgd.min.js',
		'assets/vendor/packery/dist/packery.pkgd.js'])
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.concat('main.js'))
	.pipe($.rename({suffix: '.min'}))
	.pipe(gulpif(config.development == false, $.uglify()))
	.pipe(gulp.dest('assets/scripts/'))
	.pipe(gulpif(config.development == true, $.notify('JavaScript compiled and minified')));
	// .pipe(gulpif(config.development == true, $.livereload()));
});

gulp.task('copy', function(){
	gulp.src('assets/vendor/modernizr/modernizr.js')
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.uglify())
	.pipe($.rename({suffix: '.min'}))
	.pipe(gulp.dest('assets/scripts/vendor'))
	.pipe(gulpif(config.development == true, $.notify('Files copied.')));
});

gulp.task('jshint', function() {
	gulp.src('assets/scripts/_*.js')
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.jshint())
	.pipe($.jshint.reporter('jshint-stylish'));
});

gulp.task('svgmin', function() {
	gulp.src('assets/images/*.svg')
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.svgmin())
	.pipe(gulp.dest('assets/images/'))
	.pipe($.notify('SVGs minifed.'));
});

gulp.task('imagemin', function () {
	gulp.src(['assets/images/*', '!assets/images/*.svg'])
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.imagemin())
	.pipe(gulp.dest('assets/images/'))
	.pipe($.notify('Images minified.'));
});

gulp.task('sprites', function () {
	return gulp.src('assets/images/sprites/*.png')
	.pipe($.plumber({errorHandler: $.notify.onError("<%= error.message %>")}))
	.pipe($.spritesmith({
		imgName: 'sprite.png',
		styleName: '_sprite.scss',
		imgPath: '../images/sprite.png'
	}))
	.pipe(gulpif('*.png', gulp.dest('assets/images/')))
	.pipe(gulpif('*.scss', gulp.dest('assets/sass/base')));
	// .pipe(gulpif(config.development == true, $.livereload()));
});

gulp.task('watch', function(){

	// var server = $.livereload();
	gulp.watch('**/*.php').on('change', function(file) {
		// server.changed(file.path);
		browserSync.reload;
		$.notify('PHP file changed' + ' (' + file.path + ')');
	});

	gulp.watch("assets/sass/**/*.scss", ['sass']);
	gulp.watch("assets/scripts/_*.js", ['jshint', 'javascripts', browserSync.reload]);
	// gulp.watch("assets/images/*", ['imagemin', 'svgmin']);
	// gulp.watch("assets/images/sprites/*.png", ['sprites', browserSync.reload]);

});

gulp.task('default', ['set-development', 'sprites', 'sass', 'jshint', 'javascripts', 'watch', 'browser-sync']);
gulp.task('build', ['sprites', 'sass', 'jshint', 'copy', 'javascripts']);

