/**
 * gruntfile.js
 *
 * This file automates Sass compilation
 */

module.exports = function (grunt) {

  grunt.initConfig({

  // Watch task configuration
    watch: {
      sass: {
        files: 'src/scss/*.scss',
        tasks: ['sass']
      }
    },

  // Sass task configuration
    sass: {
      dist: {
        options: {
          style: 'compressed'
        }
        files: {
          'assets/css/main.css' : 'src/scss/main.scss'
        }
      } 
    },

  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

};
