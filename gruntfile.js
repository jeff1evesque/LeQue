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
        files: 'style/scss/*.scss',
        tasks: ['sass']
      }
    },

  // Sass task configuration
    sass: {
      dev: {
        files: {
          'style/css/main.css' : 'style/scss/main.scss'
        }
      } 
    },

  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

};
