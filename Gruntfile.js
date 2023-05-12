module.exports = function (grunt) {

    var jsFiles = [
        'assets/template_front/js/jquery-1.12.4.min.js',
        'assets/template_front/js/jquery-ui.js',
        'assets/template_front/js/popper.min.js',
        'assets/template_front/bootstrap/js/bootstrap.min.js',
        'assets/template_front/owlcarousel/js/owl.carousel.min.js',
        'assets/template_front/js/magnific-popup.min.js',
        'assets/template_front/js/waypoints.min.js',
        'assets/template_front/js/parallax.js',
        'assets/template_front/js/jquery.countdown.min.js',
        'assets/template_front/js/Hoverparallax.min.js',
        'assets/template_front/js/jquery.countTo.js',
        'assets/template_front/js/imagesloaded.pkgd.min.js',
        'assets/template_front/js/isotope.min.js',
        'assets/template_front/js/jquery.appear.js',
        'assets/template_front/js/jquery.parallax-scroll.js',
        'assets/template_front/js/jquery.dd.min.js',
        'assets/template_front/js/slick.min.js',
        'assets/template_front/js/jquery.elevatezoom.js',
        'assets/template_front/js/scripts.js',
        'node_modules/sweetalert2/dist/sweetalert2.all.min.js',
        'assets/template_front/js/select2.full.min.js',
        'assets/template_front/js/countdown-timer.min.js',
        'assets/template_front/js/momentjs.min.js',
        'assets/template_front/js/custom.js'
    ];
    var cssFiles = [
        'assets/template_front/css/animate.css',
        'assets/template_front/bootstrap/css/bootstrap.min.css',
        'assets/template_front/css/all.min.css',
        'assets/template_front/css/ionicons.min.css',
        'assets/template_front/css/themify-icons.css',
        'assets/template_front/css/linearicons.css',
        'assets/template_front/css/flaticon.css',
        'assets/template_front/css/simple-line-icons.css',
        'assets/template_front/owlcarousel/css/owl.carousel.min.css',
        'assets/template_front/owlcarousel/css/owl.theme.css',
        'assets/template_front/owlcarousel/css/owl.theme.default.min.css',
        'assets/template_front/css/magnific-popup.css',
        'assets/template_front/css/jquery-ui.css',
        'assets/template_front/css/slick.css',
        'assets/template_front/css/slick-theme.css',
        'assets/template_front/css/select2.min.css',
        'assets/template_front/css/style.css',
        'assets/template_front/css/responsive.css',
        'assets/template_front/css/custom.css',
        'assets/template_front/css/font-google-roboto.css',
        'assets/template_front/css/font-google-poppins.css'
    ];
    var allFiles = jsFiles.concat(cssFiles); // merge js & css files directory

    grunt.initConfig({
        jsDistDir: 'js/',
        cssDistDir: 'assets/template_front/css/',
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            js: {
                options: {
                    separator: ';'
                },
                src: jsFiles,
                dest: '<%=jsDistDir%><%= pkg.name %>.js'
            },
            css: {
                src: cssFiles,
                dest: '<%=cssDistDir%><%= pkg.name %>.css'
            }
        },
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%=grunt.template.today("dd-mm-yyyy") %> */\n'
            },
            dist: {
                files: {
                    '<%=jsDistDir%><%= pkg.name %>.min.js': ['<%= concat.js.dest %>']
                }
            }
        },
        cssmin: {
            add_banner: {
                options: {
                    banner: '/*! <%= pkg.name %> <%=grunt.template.today("dd-mm-yyyy") %> */\n'
                },
                files: {
                    '<%=cssDistDir%><%= pkg.name %>.min.css': ['<%= concat.css.dest %>']
                }
            }
        },
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', [
        'concat',
        'uglify',
        'cssmin',
    ]);

};