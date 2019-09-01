/* ========================================================================
 * Frank Communication Subtheme: Gruntfile.js v0.0.1
 * ========================================================================
 * Copyright 2019 Frank Communication Ltd.
 * Licensed under MIT
 * ======================================================================== */

module.exports = function (grunt) {

  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  var target = grunt.option('target') || 'dev';

  grunt.initConfig({

    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*!\n' +
      ' * Frank Communication Bootstrap Subtheme v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
      ' * Copyright 2011-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
      ' * Licensed under <%= pkg.license %>\n' +
      ' */\n',

    // Create an object to specify where all the theme resources are located
    resources: {
      theme: {
        images: [
          'images/**/*.*'
        ],
        js: [
          'src/js/*.js'
        ],
        scss: [
          'src/scss/**/*.scss'
        ]
      },
      bootstrap: {
        core: [
          'bootstrap/assets/javascripts/bootstrap.min.js'
        ],
        plugins: [
          'bootstrap/assets/javascripts/bootstrap/*.js'
        ],
        fonts: [
          'bootstrap/assets/fonts/bootstrap/*.woff',
          'bootstrap/assets/fonts/bootstrap/*.woff2'
        ],
      },
      bootswatch: {
        css: [
          'assets/bootstrap/3.4.1/8.x-3.x/drupal-bootstrap-cosmo.min.css'
        ]
      },
      fontawesome: {
        scss: ['assets/fontawesome/scss/**/*.scss'],
        fonts: [
          'assets/fontawesome/webfonts/*.woff',
          'assets/fontawesome/webfonts/*.woff2'
        ]
      }
    }, // files

    addbanner: {
      dist: {
        options: {
          position: 'top',
          banner: '<%= banner %>'
        },
        files: {
          src: [
            'dist/css/<%= pkg.name %>.css',
            'dist/css/<%= pkg.name %>.min.css',
            'dist/css/<%= pkg.name %>-theme.css',
            'dist/css/<%= pkg.name %>-theme.min.css'
          ]
        }
      }
    }, // addbanner

    clean: {
      all: ['dist/*'],
      css: ['dist/css/'],
      fonts: ['dist/fonts/'],
      images: ['dist/images/'],
      js: ['dist/js']
    }, // clean

    compass: {
      dev: {
        options: {
          environment: 'development',
          config: 'config-dev.rb'
        }
      },
      prod: {
        options: {
          environment: 'production',
          config: 'config-prod.rb'
        }
      }
    }, // compass

    concat: {
      options: {
        banner: '<%= banner %>\n',
        stripBanners: false
      },
      bootstrap: {
        src: '<%= resources.bootstrap.plugins %>',
        dest: 'dist/js/bootstrap-plugins.js'
      },
      theme: {
        src: '<%= resources.theme.js %>',
        dest: 'dist/js/theme.js'
      }
    }, // concat

    copy: {
      js: {
        expand: true,
        src: [
          '<%= resources.bootstrap.core %>',
        ],
        dest: 'dist/js/',
        flatten: true
      },
      fonts: {
        expand: true,
        src: [
          '<%= resources.bootstrap.fonts %>',
          '<%= resources.fontawesome.fonts %>',
        ],
        dest: 'dist/fonts/',
        filter: 'isFile',
        flatten: true
      },
      bootswatch: {
        expand: true,
        src: '<%= resources.bootswatch.css %>',
        dest: 'dist/css/',
        flatten: true
      }
    }, // copy

    imagemin: {
      options: {},
      dynamic: {
        files : [{
          expand: true,
          src: 'images/*.*',
          dest: 'dist'
        }]
      }
    }, // imagemin

    jshint: {
      options: {
        globals: {
          jQuery: true,
          console: true,
          module: true
        }
      },
      theme: {
        files: ['Gruntfile.js', '<%= resources.theme.js %>'] // only clean the files we have control over
      },
      all: {
        files: ['Gruntfile.js', '<%= resources.theme.js %>', '<%= concat.bootstrap.dest %>'] // clean everything
      }
    },

    sasslint: {
      options: {
        configFile: '.sass-lint.yml',
      },
      target: ['<%= resources.theme.scss %>']
    }, //sasslint

    uglify: {
      options: {
        banner: '<%= banner %>',
      },
      dev: {
        options: {
          beautify: true,
          compress: false,
          mangle: false,
          sourceMap: true,
          sourceMapIncludeSources: true
        },
        files: {
          'dist/js/plugins.min.js' : '<%= resources.bootstrap.plugins %>',
          'dist/js/theme.min.js' : '<%= resources.theme.js %>'
        }
      },
      prod: {
        options: {
          mangle: false,
          sourceMap: false
        },
        files: {
          'dist/js/plugins.min.js' : '<%= resources.bootstrap.plugins %>',
          'dist/js/theme.min.js' : '<%= resources.theme.js %>'
        }
      },
    }, // uglify

    watch: {
      options: {
        livereload: true
      },
      sass: {
        files: ['<%= resources.theme.scss %>'],
        tasks: ['compass']
      },
      scripts: {
        files: ['<%= resources.theme.js %>', '<%= resources.bootstrap.plugins %>'],
        tasks: ['uglify:' + target]
      },
    } // watch

  });

  require('load-grunt-tasks')(grunt);

  // JS build task
  grunt.registerTask('build-js', ['clean:js', 'copy:js', 'uglify:' + target]);

  // CSS build task
  grunt.registerTask('build-css', ['clean:css', 'clean:fonts', 'compass:' + target, 'copy:bootswatch', 'copy:fonts']);

  // Image build task
  grunt.registerTask('build-img', ['clean:images', 'imagemin']);

  // Full deployment task
  grunt.registerTask('deploy', ['build-css', 'build-js', 'build-img']);

  // Lint task
  grunt.registerTask('lint', 'Run sass-lint on styles', 'sasslint');

  // Default task
  grunt.registerTask('default', 'Default task', ['watch']);

};
