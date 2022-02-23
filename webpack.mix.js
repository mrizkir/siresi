const mix = require('laravel-mix');
const lodash = require("lodash");
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const folder = {
    src: "resources/", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var third_party_assets = {
    css_js: [
        { "name": "@ckeditor", "assets": ["./node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"] },
        {
            "name": "@simonwep",
            "assets": ["./node_modules/@simonwep/pickr/dist/pickr.min.js",
                "./node_modules/@simonwep/pickr/dist/themes/classic.min.css",
                "./node_modules/@simonwep/pickr/dist/themes/monolith.min.css",
                "./node_modules/@simonwep/pickr/dist/themes/nano.min.css",
            ]
        },
        {
            "name": "@tarekraafat",
            "assets": [
                "./node_modules/@tarekraafat/autocomplete.js/dist/autoComplete.min.js",
                "./node_modules/@tarekraafat/autocomplete.js/dist/css/autoComplete.css",
            ]
        },
        {
            "name": "aos",
            "assets": [
                "./node_modules/aos/dist/aos.js",
                "./node_modules/aos/dist/aos.css",
            ]
        },

        { "name": "dom-autoscroller", "assets": ["./node_modules/dom-autoscroller/dist/dom-autoscroller.min.js"] },
        {
            "name": "dragula",
            "assets": ["./node_modules/dragula/dist/dragula.min.js",
                "./node_modules/dragula/dist/dragula.min.css"
            ]
        },
        { "name": "cleave.js", "assets": ["./node_modules/cleave.js/dist/cleave.min.js"] },
        { "name": "apexcharts", "assets": ["./node_modules/apexcharts/dist/apexcharts.min.js"] },
        { "name": "bootstrap", "assets": ["./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"] },
        { "name": "chart.js", "assets": ["./node_modules/chart.js/dist/chart.min.js"] },
        { "name": "fg-emoji-picker", "assets": ["./node_modules/fg-emoji-picker/fgEmojiPicker.js"] },

        {
            "name": "filepond-plugin-file-encode",
            "assets": ["./node_modules/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js", ]
        },
        {
            "name": "filepond-plugin-file-validate-size",
            "assets": ["./node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js", ]
        },
        {
            "name": "filepond-plugin-image-exif-orientation",
            "assets": ["./node_modules/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js", ]
        },
        {
            "name": "filepond-plugin-image-exif-orientation",
            "assets": ["./node_modules/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js", ]
        },
        {
            "name": "filepond-plugin-image-preview",
            "assets": [
                "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js",
                "./node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css",
            ]
        },
        {
            "name": "filepond",
            "assets": [
                "./node_modules/filepond/dist/filepond.min.js",
                "./node_modules/filepond/dist/filepond.min.css",
            ]
        },
        {
            "name": "dropzone",
            "assets": ["./node_modules/dropzone/dist/dropzone-min.js",
                "./node_modules/dropzone/dist/dropzone.css"
            ]
        },
        { "name": "echarts", "assets": ["./node_modules/echarts/dist/echarts.min.js"] },

        {
            "name": "fullcalendar",
            "assets": [
                "./node_modules/fullcalendar/main.min.js",
                "./node_modules/fullcalendar/main.min.css"
            ]
        },
        {
            "name": "flatpickr",
            "assets": ["./node_modules/flatpickr/dist/flatpickr.min.js",
                "./node_modules/flatpickr/dist/flatpickr.min.css"
            ]
        },
        {
            "name": "glightbox",
            "assets": ["./node_modules/glightbox/dist/js/glightbox.min.js",
                "./node_modules/glightbox/dist/css/glightbox.min.css"
            ]
        },
        { "name": "gmaps", "assets": ["./node_modules/gmaps/gmaps.min.js"] },

        { "name": "isotope-layout", "assets": ["./node_modules/isotope-layout/dist/isotope.pkgd.min.js"] },

        {
            "name": "gridjs",
            "assets": ["./node_modules/gridjs/dist/gridjs.umd.js",
                "./node_modules/gridjs/dist/theme/mermaid.min.css"
            ]
        },
        {
            "name": "jsvectormap",
            "assets": [
                "./node_modules/jsvectormap/dist/css/jsvectormap.min.css",
                "./node_modules/jsvectormap/dist/js/jsvectormap.min.js",
                "./node_modules/jsvectormap/dist/maps/world-merc.js",
                "./node_modules/jsvectormap/dist/maps/us-merc-en.js",
                "./node_modules/jsvectormap/dist/maps/canada.js",
                "./node_modules/jsvectormap/dist/maps/russia.js",
                "./node_modules/jsvectormap/dist/maps/spain.js",
            ]
        },
        {
            "name": "leaflet",
            "assets": [
                "./node_modules/leaflet/dist/leaflet.js",
                "./node_modules/leaflet/dist/leaflet.css",
            ]
        },
        { "name": "masonry-layout", "assets": ["./node_modules/masonry-layout/dist/masonry.pkgd.min.js"] },
        { "name": "particles.js", "assets": ["./node_modules/particles.js/particles.js"] },

        {
            "name": "prismjs",
            "assets": [
                "./node_modules/prismjs/prism.js",
                "./node_modules/prismjs/themes/prism.css",
                "./node_modules/prismjs/plugins/toolbar/prism-toolbar.min.css",

            ]
        },

        { "name": "list.pagination.js", "assets": ["./node_modules/list.pagination.js/dist/list.pagination.min.js"] },

        { "name": "list.js", "assets": ["./node_modules/list.js/dist/list.min.js"] },
        {
            "name": "multi.js",
            "assets": [
                "./node_modules/multi.js/dist/multi.min.js",
                "./node_modules/multi.js/dist/multi.min.css",
            ]
        },

        { "name": "moment", "assets": ["./node_modules/moment/min/moment.min.js"] },
        {
            "name": "nouislider",
            "assets": ["./node_modules/nouislider/dist/nouislider.min.js",
                "./node_modules/nouislider/dist/nouislider.min.css"
            ]
        },
        {
            "name": "quill",
            "assets": [
                "./node_modules/quill/dist/quill.core.css",
                "./node_modules/quill/dist/quill.bubble.css",
                "./node_modules/quill/dist/quill.snow.css",
                "./node_modules/quill/dist/quill.min.js"
            ]
        },
        { "name": "rater-js", "assets": ["./node_modules/rater-js/index.js"] },

        {
            "name": "shepherd.js",
            "assets": [
                "./node_modules/shepherd.js/dist/js/shepherd.min.js",
                "./node_modules/shepherd.js/dist/css/shepherd.css",
            ]
        },


        { "name": "simplebar", "assets": ["./node_modules/simplebar/dist/simplebar.min.js"] },
        {
            "name": "sweetalert2",
            "assets": ["./node_modules/sweetalert2/dist/sweetalert2.min.js",
                "./node_modules/sweetalert2/dist/sweetalert2.min.css"
            ]
        },
        {
            "name": "swiper",
            "assets": ["./node_modules/swiper/swiper-bundle.min.js",
                "./node_modules/swiper/swiper-bundle.min.css"
            ]
        },

        { "name": "feather-icons", "assets": ["./node_modules/feather-icons/dist/feather.min.js"] },
        { "name": "wnumb", "assets": ["./node_modules/wnumb/wNumb.min.js"] },
        { "name": "node-waves", "assets": ["./node_modules/node-waves/dist/waves.min.js"] },
        { "name": "sortablejs", "assets": ["./node_modules/sortablejs/Sortable.min.js"] }
    ]
};

//copying third party assets
lodash(third_party_assets).forEach(function(assets, type) {
    if (type == "css_js") {
        lodash(assets).forEach(function(plugin) {
            var name = plugin['name'],
                assetlist = plugin['assets'],
                css = [],
                js = [];
            lodash(assetlist).forEach(function(asset) {
                var ass = asset.split(',');
                for (let i = 0; i < ass.length; ++i) {
                    if (ass[i].substr(ass[i].length - 3) == ".js") {
                        js.push(ass[i]);
                    } else {
                        css.push(ass[i]);
                    }
                };
            });
            if (js.length > 0) {
                mix.combine(js, folder.dist_assets + "/libs/" + name + "/" + name + ".min.js");
            }
            if (css.length > 0) {
                mix.combine(css, folder.dist_assets + "/libs/" + name + "/" + name + ".min.css");
            }
        });
    }
});

// mix.copyDirectory("./node_modules/tinymce", folder.dist_assets + "/libs/tinymce");
mix.copyDirectory("./node_modules/leaflet/dist/images", folder.dist_assets + "/libs/leaflet/images");
// mix.copyDirectory("./node_modules/bootstrap-editable/img", folder.dist_assets + "/libs/img");

// copy all fonts
var out = folder.dist_assets + "fonts";
mix.copyDirectory(folder.src + "fonts", out);

// copy all images
var out = folder.dist_assets + "images";
mix.copyDirectory(folder.src + "images", out);

mix.sass('resources/scss/bootstrap.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/bootstrap.css");
mix.sass('resources/scss/icons.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/icons.css");
mix.sass('resources/scss/app.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/app.css");
mix.sass('resources/scss/style.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/style.css");


mix.webpackConfig({
    plugins: [
        new WebpackRTLPlugin()
    ]
});


//copying demo pages related assets
var app_pages_assets = {
    js: [
        {
            'file': folder.src + "js/pages/transaksi/resi.js",
            'dir': 'transaksi',
        },
        {
            'file': folder.src + "js/pages/setting/user-picker.js",
            'dir': 'setting',
        },
        
    ]
};

var out = folder.dist_assets + "js/";
lodash(app_pages_assets).forEach(function(assets, type) {
    for (let i = 0; i < assets.length; ++i) {
        mix.js(assets[i].file, out + "pages/" + assets[i].dir);
    };
});

mix.combine('resources/js/plugins.js', folder.dist_assets + "js/plugins.min.js");
mix.combine('resources/js/layout.js', folder.dist_assets + "js/layout.min.js");
mix.combine('resources/js/bootstrap.js', folder.dist_assets + "js/bootstrap.min.js");
mix.combine('resources/js/plugins/lord-icon.js', folder.dist_assets + "js/plugins/lord-icon.js");