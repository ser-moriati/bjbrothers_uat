<!DOCTYPE html>
<html>
<head><!-- CDN hosted by Cachefly -->
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea",
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern responsivefilemanager"
        ],

        toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
        toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

        menubar: true,
        toolbar_items_size: 'small',

        style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],

        templates: [
                {title: 'Test template 1', content: '<!DOCTYPE html><html><head></head><body><h4 class="row" style="text-align: left;">&nbsp;</h4><h1 class="col-sm-12">consectetur adipiscing elit. Nullam varius turpis non sapien porta.</h1><div class="col-sm-12">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam varius turpis non sapien porta, sed pretium metus finibus. Phasellus mattis tempor erat sit amet ultrices. Curabitur dignissim, dolor dictum malesuada placerat, nisi ex auctor libero, ut sollicitudin lectus nisl ut elit. Nullam posuere orci quis rutrum molestie. Vivamus feugiat ultrices lacus a eleifend. Nulla eu venenatis dolor. Fusce nec turpis vitae leo dapibus tempor nec egestas tellus. Nam et euismod arcu.</div><ol><li class="col-sm-12">ut sollicitudin lectus nisl ut elit.</li><li class="col-sm-12">Nullam posuere orci quis rutrum molestie.</li><li class="col-sm-12">Vivamus feugiat ultrices lacus a eleifend.</li></ol><table style="height: 136px;" width="692"><thead><tr style="text-align: center;"><td style="border-color: #000000; width: 50px; background-color: #327fd1;"><h4><span style="color: #ffffff;">No</span></h4></td><td style="border-color: #000000; background-color: #327fd1;"><h4><span style="color: #ffffff;">Title</span></h4></td><td style="border-color: #000000; width: 100px; background-color: #327fd1;"><h4><span style="color: #ffffff;">Download</span></h4></td></tr></thead><tbody><tr><td style="text-align: center;">1.</td><td><p>&nbsp;Nullam posuere orci quis rutrum molestie.</p></td><td style="text-align: center;"><a href="google.com">google.com</a></td></tr><tr><td style="text-align: center;">2.</td><td>&nbsp;Nullam posuere orci quis rutrum molestie.</td><td style="text-align: center;"><a href="facebook.com">facebook.com</a></td></tr></tbody></table></body></html>'},
                {title: 'Test template 2', content: 'Test 2'}
        ],
        image_advtab: true,
		external_filemanager_path:"/demo/tinymce/filemanager/",
		filemanager_title:"Responsive Filemanager" ,
		external_plugins: { "filemanager" : "/demo/tinymce/filemanager/plugin.min.js"},
                forced_root_block : 'div'

});</script>
</head>
<body>
        <textarea> filemanager>config>config.php upload_dir,current_path,thumbs_base_path</textarea>
</body>
</html>