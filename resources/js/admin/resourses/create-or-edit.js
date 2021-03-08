// Import ACE editor
//import ace from 'ace-builds';

// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// Default icons are required for TinyMCE 5.3 or above
import 'tinymce/icons/default';

// A theme is also required
import 'tinymce/themes/silver';

// Any plugins you want to use has to be imported
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/print';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/hr';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
//import 'tinymce/plugins/code';
//import 'tinymce/plugins/codeeditor/plugin';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/media';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/save';
import 'tinymce/plugins/table';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/template';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/textpattern';

var config = {
    path_absolute : '/',
    skin_url: '/tinymce/skins/ui/oxide',
    content_css: false,
    selector: 'textarea.tinymce',
    //plugins: ['paste', 'link']
    plugins: [
        'advlist', 'autolink' , 'lists', 'link', 'image', 'charmap', 'print',
        'preview', 'hr', 'anchor', 'pagebreak', 'searchreplace', 'wordcount',
        'visualblocks', 'visualchars', 'fullscreen', 'insertdatetime',
        'media', 'nonbreaking', 'save', 'table', 'directionality',
        'template', 'paste', 'textpattern',
        //'codeeditor'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codeeditor',
    //toolbar: ['insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',  'codeeditor'],

    relative_urls: false,
    /*file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinymce.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
        });

        tinymce.activeEditor.windowManager.openUrl({
            url : url,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    }*/

    file_picker_callback: function (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        let type = 'image' === meta.filetype ? 'Images' : 'Files',
            url  = config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

        tinymce.activeEditor.windowManager.openUrl({
            url : url,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    }
};

// Initialize the app
tinymce.init(config);

