'use strict';

const { src, dest, parallel, series, watch } = require('gulp');
const strip = require('gulp-strip-comments');
const sass = require("gulp-sass")(require("sass"));
const	cssmin = require('gulp-clean-css');
const rigger = require('gulp-rigger');
const rename = require('gulp-rename');
const prefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify-es').default;
const babel = require('gulp-babel');
const npmDist = require('gulp-npm-dist');
const browserSync = require('browser-sync').create();
const rimraf = require('rimraf');
const imagemin = require('gulp-imagemin');
const	newer = require('gulp-newer');
const iconfontCss = require('gulp-iconfont-css');
const iconfontFont = require('gulp-iconfont');
const runTimestamp = Math.round(Date.now()/1000);

// RELOAD
	function reload(done) {
		// Just reload
		browserSync.reload();
		done();
	}

// HTML
	function html() {
		return src('app/*.html')
			.pipe(rigger())
			.pipe(strip())
			.pipe(dest('dist'))
			.pipe(browserSync.reload({ stream: true }))
	}

// CSS
	function scss() {
		return src('app/scss/main.scss', { sourcemaps: true })
			.pipe(sass().on("error", sass.logError))
			.pipe(prefixer({ remove: false }))
			.pipe(dest('dist/css'))
			.pipe(cssmin())
			.pipe(rename({ suffix: '.min' }))
			.pipe(dest('dist/css', { sourcemaps: '.' }))
			.pipe(browserSync.reload({ stream: true }))
	}	

// JS
	function js() {
		return src('app/js/main.js', { sourcemaps: true })
			.pipe(rigger())
      .pipe(babel({ presets: ['@babel/env'] }))
			.pipe(dest('dist/js'))
			.pipe(uglify())
			.pipe(rename({ suffix: '.min' }))
			.pipe(dest('dist/js', { sourcemaps: '.' }))
			.pipe(browserSync.reload({ stream: true }))
	}

// Assets
	function npm2dist() {
		return src(npmDist(), {base: './node_modules/'})
			.pipe(dest('dist/lib'));
	}

// Fonts
	function font() {
		return src('app/font/**')
			.pipe(dest('dist/font'))
	}

// SVG
	function svg() {
		return src('app/svg/**/*.svg')
			.pipe(imagemin([
				imagemin.svgo({
					plugins: [
					// { removeViewBox: true },
					{ cleanupIDs: true }
					]
				})
				]))
			.pipe(dest('dist/svg'))
	}

// Favicon
	function favicon() {
		return src('app/favicon/**')
			.pipe(imagemin([
				imagemin.optipng({ optimizationLevel: 5 })
			]))
			.pipe(dest('dist/favicon'))
	}

// Images
	function image() {
		return src('app/img/**')
			.pipe(newer('dist/img'))
			.pipe(imagemin([
				imagemin.gifsicle({interlaced: true}),
				imagemin.mozjpeg({progressive: true}),
				imagemin.optipng({optimizationLevel: 5})
				]))
			.pipe(dest('dist/img'))
	}

// Iconfont
	function iconfont() {
		return src('app/icon/*.svg')
			.pipe(iconfontCss({
				fontName: 'iconfont',
				path: 'app/icon/_icon.css',
				targetPath: 'stylesheet.css',
				fontPath: '',
				cacheBuster: `?v=${runTimestamp}`,
			}))
			.pipe(iconfontFont({
				fontName: 'iconfont',
				prependUnicode: true,
				formats: ['eot', 'woff', 'woff2', 'ttf', 'svg'],
				timestamp: runTimestamp,
				normalize: true,
				fontHeight: 1001,
			}))
			.pipe(dest('dist/font/iconfont'))
	}

// Vendor
	function vendorJS() {
	  return src('app/js/vendor.js')
	    .pipe(rigger())
	    .pipe(uglify())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('dist/js'))
			.pipe(browserSync.reload({ stream: true }))
	}
	function vendorCSS() {
	  return src('app/scss/vendor.scss')
			.pipe(sass().on("error", sass.logError))
			.pipe(cssmin())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('dist/css'))
			.pipe(browserSync.reload({ stream: true }))
	}


// Watcher
	function watcher() {
		watch(['app/*.html', 'app/template/*.html'], parallel(html));
		watch(['app/js/main.js', 'app/js/include/*.js'], parallel(js));
		watch(['app/scss/main.scss', 'app/scss/include/*.scss'], parallel(scss));
		// watch('package.json', parallel(npm2dist));
		watch('app/scss/vendor.scss', parallel(vendorCSS));
		watch('app/js/vendor.js', parallel(vendorJS));
		watch('app/font/**', parallel(font));
		watch('app/svg/*.svg', parallel(svg));
		watch('app/favicon/**', parallel(favicon));
		watch('app/img/**', parallel(image));
		watch('app/icon/svg/*.svg', series(iconfont, scss));
	}

// Server
	function server() {
		browserSync.init({
			server: './dist',
			directory: true,
			notify: false,
			open: false
		});
	}

// Clean
	function clean(cb) {
		rimraf('./dist', cb);
	}

// Modules
	exports.js = js;
	exports.scss = scss;
	exports.html = html;
	exports.npm2dist = npm2dist;
	exports.font = font;
	exports.svg = svg;
	exports.favicon = favicon;
	exports.image = image;
	exports.iconfont = series(iconfont, scss);
	exports.vendor = series(vendorJS, vendorCSS);

	exports.watcher = watcher;
	exports.server = server;
	exports.clean = clean;

	exports.build = series(clean, parallel(html, scss, js,/* npm2dist,*/ vendorJS, vendorCSS, font, svg, favicon, image, iconfont));
	exports.default = parallel(server, watcher);


