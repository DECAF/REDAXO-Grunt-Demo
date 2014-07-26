module.exports = function (grunt) {
	var SCRIPTS_SRC = './scripts.json';

	var scripts = require(SCRIPTS_SRC);
	var moment = require('moment');

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			options: {
				livereload: true
			},
			coffee: {
				files: ['app/static/coffee/**/*.coffee'],
				tasks: ['clean:coffee', 'coffee', 'appSources']
			},
			compass: {
				options: {
					livereload: false
				},
				files: ['app/static/sass/**/*.scss', 'app/static/sass/**/*.sass', 'app/static/sass/**/*.css', ],
				tasks: ['compass:dev']
			},
			css: {
				files: ['app/static/css_src/**/*.css', 'app/static/css/**/*.css' ],
				tasks: []
			},
			appSources: {
				files: ['scripts.json'],
				tasks: ['appSources']
			},
			all: {
				files: ['app/dev/**/*', 'app/pages/**/*']
			}
		},
		clean: {
			coffee: ['app/static/js/coffee/**/*.js', 'app/static/js/coffee/**/*.map'],
			htmlTmp : ['app/.tmp/'],
			releaseTmp : ['.tmp/']
		},
		coffee: {
			dist: {
				options: {
					bare: false,
					sourceMap: true
				},
				expand: true,
				cwd: 'app/static/coffee',
				src: ['**/*.coffee'],
				dest: 'app/static/js/coffee',
				ext: '.js'
			}
		},
		compass: {
			options: {
				sassDir: 'app/static/sass',
				imagesDir: 'app/static/img',
				relativeAssets: true,
				require: ['sass-globbing']
			},
			clean: {
				options: {
					clean: true
				}
			},
			init: {
				options: {
					cssDir: 'app/static/css_src',
					environment: 'development',
					force: true
				}
			},
			dev: {
				options: {
					cssDir: 'app/static/css_src',
					environment: 'development'
				}
			},
			dist: {
				options: {
					cssDir: 'app/static/css',
					environment: 'production',
					force: true
				}
			}
		},
		uglify: {
			options: {
				compress: false,
				report: 'min',
				wrap: false
			},
			dist: {
				files: {
					'app/static/js/head.min.js': scripts.head,
					'app/static/js/body.min.js': scripts.body
				}
			}
		},
		bytesize: {
			all: {
				src: [
					'app/static/js/head.min.js',
					'app/static/js/body.min.js',
					'app/static/css/site.css'
				]
			}
		},
		appSources: {
			dist: {
				options: {
					'replacePattern': /^app\//gi
				},
				files: {
					'app/static/js/head.json': scripts.head,
					'app/static/js/body.json': scripts.body
				}
			}
		},
		php2html: {
			default: {
				options: {
					// relative links should be renamed from .php to .html
					//processLinks: false
					htmlhint: {
						'tagname-lowercase': false,
						'attr-lowercase': false,
						'attr-value-double-quotes': false,
						'doctype-first': false,
						'tag-pair': false,
						'spec-char-escape': false,
						'id-unique': true,
						'src-not-empty': true
					}
				},
				files: [
					{expand: true, cwd: 'app/dev/', src: ['*.php'], dest: 'app/.tmp/', ext: '.html' }
				]
			}
		},
		rename: {
			options: {
				ignore: true
			},
			enableDebug: {
				src: 'app/NO_DEBUG',
				dest: 'app/_DEBUG'
			},

			// Any number of targets here...

			disableDebug: {
				src: 'app/_DEBUG',
				dest: 'app/NO_DEBUG'
			}
		},
		compress: {
			dist: {
				options: {
					mode: 'zip',
					pretty: true,
					archive: function () {
						var rev = grunt.config.get('meta.revision'),
								now = moment().format('YYYY-MM-DD');
						return 'dist/app.'+ now + '.HEAD' + rev + '.zip';
					}
				},
				files: [
					{
						expand: true,
						cwd: '.tmp/app/',
						src: ['**']
					}
				]
			}
		},
		revision: {
			options: {
				property: 'meta.revision',
				ref: 'HEAD',
				short: true
			}
		},
		copy: {
			dist: {
				files: [
					// includes files within path
					{expand: true, src: ['app/.tmp/**'], dest: '.tmp/app/html', filter: 'isFile', flatten: true},
					{src: ['app/static/components/**', '!app/static/components/_DO_NOT_MODIFY'], dest: '.tmp/', filter: 'isFile'}, // includes files in path
					{src: ['app/static/css/**.css'], dest: '.tmp/', filter: 'isFile'}, // includes files in path
					{cwd: 'app/static/fonts/', src: ['**', '!icomoon_src/**','!**.md'], dest: '.tmp/app/static/fonts/', filter: 'isFile', expand: true}, // includes files in path
					{src: ['app/static/img/**'], dest: '.tmp/', filter: 'isFile'}, // includes files in path
					{src: ['app/static/js/**.js', 'app/static/js/**.jon'], dest: '.tmp/', filter: 'isFile'}, // includes files in path
					{src: ['app/static/media/**'], dest: '.tmp/', filter: 'isFile'}, // includes files in path
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-bytesize');
	grunt.loadNpmTasks('grunt-php2html');
	grunt.loadNpmTasks('grunt-rename');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-git-revision');
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.registerMultiTask('appSources', 'Creates the json file for the app sources.', function () {
		var replacePattern = this.options().replacePattern;
		var createAppScriptPaths = function (pattern, list) {
			var result = [];
			list.forEach(function (item) {
				result.push(item.replace(pattern, ''));
			});
			return result;
		};

		this.files.forEach(function (file) {
			grunt.file.write(file.dest, JSON.stringify(createAppScriptPaths(replacePattern, file.src)));
		});
	});

	grunt.registerTask('dev', ['clean', 'coffee', 'compass:clean', 'compass:init', 'appSources', 'watch']);
	grunt.registerTask('build', ['clean', 'coffee', 'compass:clean', 'compass:dist', 'uglify', 'appSources', 'bytesize']);
	grunt.registerTask('generateHtml', ['rename:disableDebug','php2html', 'rename:enableDebug']);

	grunt.registerTask('zip', ['generateHtml', 'copy:dist','revision','compress:dist', 'clean:releaseTmp', 'clean:htmlTmp']);

	grunt.registerTask('dist', ['build', 'zip']);

	grunt.registerTask('default', ['dev']);
};