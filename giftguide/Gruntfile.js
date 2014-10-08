module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            // 2. Configuration for concatinating files goes here.
            dist: {
		        src: [
		            'js/sha1.js',
		            'js/jquery.flexslider.js',
		            'js/jquery.colorbox-min.js',
		            /*
'js/cdc-utils.js',
		            'js/cdc-data.js',
		            'js/cdc-adserver.js',
*/
		            'js/sochi.js'
		     
		            
		             // All JS in the libs folder
		            //'js/global.js'  // This specific file
		        ],
		        dest: 'js/build/production.js',
		    }
        },
        
        uglify: {
		    build: {
		        src: 'js/build/production.js',
		        dest: 'js/build/production.min.js'
		    }
		}

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify']);

};