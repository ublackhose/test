const del = require('del');
const gulp = require('gulp');
const sass = require('gulp-sass')(require('node-sass'));
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify-es').default;
const rename = require('gulp-rename');
const webpack = require('webpack');
const webpackStream = require('webpack-stream');
const _ = require('lodash');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

const paths = {
	distDir: './assets',

	theme: {
		src: './resources/theme/**/*',
		dist: './assets/theme',
	},
	
	vendors: {
		src: './resources/vendors/**/*',
		dist: './assets/vendors',
	},

	styles: {
		src: './resources/styles/**/*.scss',
		dist: './assets/css',
		watch: './resources/styles/**/*.scss'
	},

	scripts: {
		src: './resources/scripts/main.js',
		dist: './assets/js',
        watch: ['./resources/scripts/**/*.js', './resources/scripts/vue/**/*.vue']
	}
};

const ASSET_PATH = './{#SITE_TEMPLATE_PATH#}/';

const webpackConfig = {
	output: {
        filename: "[name].js",
		publicPath: ASSET_PATH
	},
	module: {
		rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
			{
				test: /\.js$/,
				exclude: '/node_modules/',
				use: {
					loader: 'babel-loader',
					query: {
						presets: [
							["@babel/preset-env", { modules: false }]
						]
					}
				}
			}
		]
    },
    plugins: [
		new VueLoaderPlugin(),
		new webpack.DefinePlugin({
			'process.env.ASSET_PATH': JSON.stringify(ASSET_PATH)
		})
    ]
};

const autoprefixerOptions = {}

const clean = (done) => del(paths.distDir, done);

const styles = () => (
    gulp
        .src(paths.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.styles.dist))
);

const watchStyles = () => gulp.watch(paths.styles.watch, styles);

const buildStyles = () => (
    gulp
        .src(paths.styles.src)
        .pipe(sass())
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest(paths.styles.dist))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(paths.styles.dist))
);

const script = (input, output = '[name].js', devtool = '', mode = 'development', config = webpackConfig) => (
    gulp
        .src(input)
        .pipe(
            webpackStream({
                config: _.merge(
                    webpackConfig,
                    {
                        output: {
                            filename: output
                        },
                        devtool: devtool,
                        mode: mode,
                    }
                )
            }),
            webpack
        )
        .pipe(gulp.dest(paths.scripts.dist))
);

const scripts = () => script(paths.scripts.src, '[name].js', 'eval');

const watchScripts = () => gulp.watch(paths.scripts.watch, scripts);

const buildScripts = gulp.series(
    () => script(paths.scripts.src, '[name].js', 'source-map'),
    () => script(paths.scripts.src, '[name].min.js', '', 'production')
);

const theme = () => (
    gulp
        .src(paths.theme.src)
        .pipe(gulp.dest(paths.theme.dist))
);

const optimizeThemeStyles = () => (
	gulp
		.src(paths.theme.dist + '/**/*.css')
		.pipe(cleanCSS())
		.pipe(rename({
            suffix: '.min'
        }))
		.pipe(gulp.dest(paths.theme.dist))
);

const optimizeThemeScripts = () => (
	gulp
		.src(paths.theme.dist + '/**/*.bundle.js')
		.pipe(uglify({
			mangle: false
		}))
		.pipe(rename({
            suffix: '.min'
        }))
		.pipe(gulp.dest(paths.theme.dist))
);

const optimizeTheme = gulp.parallel(optimizeThemeScripts, optimizeThemeStyles);

const vendors = () => (
    gulp
        .src(paths.vendors.src)
        .pipe(gulp.dest(paths.vendors.dist))
);

const watch = gulp.parallel(
    gulp.series(
        styles,
        watchStyles
    ),
    gulp.series(
        scripts,
        watchScripts
    )
);

exports.watch = watch;

exports.default = gulp.series(
	clean,
	theme,
	vendors,
	watch
);

exports.clean = clean;
exports.theme = theme;

exports.styles = styles;
exports['styles:watch'] = gulp.series(styles, watchStyles);

exports.scripts = scripts;
exports['scripts:watch'] = gulp.series(scripts, watchScripts);

exports['build:scripts'] = buildScripts;
exports['build:styles'] = buildStyles;

exports.optimize = gulp.series(optimizeTheme);

exports.build = gulp.series(
	clean,
    theme,
	vendors,
    gulp.parallel(
        buildStyles,
        buildScripts
    ),
	optimizeTheme
);
