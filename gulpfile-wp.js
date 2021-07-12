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

// PHP
	function php() {
		return src('**/*.php')
			// Just reload
			.pipe(browserSync.reload({ stream: true }))
	}

// CSS
	function scss() {
		return src('scss/main.scss', { sourcemaps: true })
			.pipe(sass().on("error", sass.logError))
			.pipe(prefixer({ remove: false }))
			.pipe(dest('css'))
			.pipe(cssmin())
			.pipe(rename({ suffix: '.min' }))
			.pipe(dest('css', { sourcemaps: '.' }))
			.pipe(browserSync.reload({ stream: true }))
	}	

// JS
	function js() {
		return src('js/main.js', { sourcemaps: true })
			.pipe(rigger())
			.pipe(babel({ presets: ['@babel/env'] }))
			.pipe(uglify())
			.pipe(rename({ suffix: '.min' }))
			.pipe(dest('js', { sourcemaps: '.' }))
			.pipe(browserSync.reload({ stream: true }))
	}

// SVG
	function svg() {
		return src('svg/**/*.svg')
			.pipe(imagemin([
				imagemin.svgo({
					plugins: [
					// { removeViewBox: true },
					{ cleanupIDs: true }
					]
				})
				]))
			.pipe(dest('svg'))
	}

// Favicon
	function favicon() {
		return src('favicon/**')
			.pipe(imagemin([
				imagemin.optipng({ optimizationLevel: 5 })
			]))
			.pipe(dest('favicon'))
	}

// Images
	function image() {
		return src('img/**')
			.pipe(imagemin([
				imagemin.gifsicle({interlaced: true}),
				imagemin.mozjpeg({progressive: true}),
				imagemin.optipng({optimizationLevel: 5})
				]))
			.pipe(dest('img'))
	}

// Iconfont
	function iconfont() {
		return src('icon/*.svg')
			.pipe(iconfontCss({
				fontName: 'iconfont',
				path: 'icon/_icon.css',
				targetPath: 'stylesheet.css',
				fontPath: ''
			}))
			.pipe(iconfontFont({
				fontName: 'iconfont',
				prependUnicode: true,
				formats: ['eot', 'woff', 'woff2', 'ttf', 'svg'],
				timestamp: runTimestamp,
				normalize: true,
				fontHeight: 1001,
			}))
			.pipe(dest('font/iconfont'))
	}

// Vendor
	function vendorJS() {
	  return src('js/vendor.js')
	    .pipe(rigger())
	    .pipe(uglify())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('js'))
			.pipe(browserSync.reload({ stream: true }))
	}
	function vendorCSS() {
	  return src('scss/vendor.scss')
			.pipe(sass().on("error", sass.logError))
			.pipe(cssmin())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('css'))
			.pipe(browserSync.reload({ stream: true }))
	}

// Admin
	function adminJS() {
	  return src('js/admin.js')
	    .pipe(rigger())
	    .pipe(uglify())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('js'))
			// .pipe(browserSync.reload({ stream: true }))
	}
	function adminCSS() {
	  return src('css/admin.css')
			.pipe(cssmin())
	    .pipe(rename({ suffix: '.min' }))
	    .pipe(dest('css'))
			// .pipe(browserSync.reload({ stream: true }))
	}


// Watcher
	function watcher() {
		watch('**/*.php', parallel(php));
		watch(['js/main.js', 'js/include/*.js'], parallel(js));
		watch(['scss/main.scss', 'scss/include/*.scss'], parallel(scss));
		watch('scss/vendor.scss', parallel(vendorCSS));
		watch('js/vendor.js', parallel(vendorJS));
		watch('css/admin.css', parallel(adminCSS));
		watch('js/admin.js', parallel(adminJS));
		watch('favicon/**', parallel(favicon));
		watch('icon/svg/*.svg', series(iconfont, scss));
	}

// Server
	function server() {
		browserSync.init({
			proxy: 'https://project.localhost',
      notify: false,
      open: false,
      https: {
        	key: '/Users/ma4ine/Dev/ssl/server.key',
        	cert: "/Users/ma4ine/Dev/ssl/server.crt"
        }
		});
	}

// Modules
	exports.js = js;
	exports.scss = scss;
	exports.php = php;
	exports.svg = svg;
	exports.favicon = favicon;
	exports.image = image;
	exports.iconfont = series(iconfont, scss);
	exports.vendor = parallel(vendorJS, vendorCSS);
	exports.admin = parallel(adminJS, adminCSS);

	exports.watcher = watcher;
	exports.server = server;

	exports.build = parallel(php, scss, js, vendorJS, vendorCSS, adminJS, adminCSS, svg, favicon, image, iconfont);
	exports.default = parallel(server, watcher);