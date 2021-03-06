(function(){
    tinymce.create("tinymce.plugins.Upload",
        {
            init:function(a,b){
                var c=this;
                c.editor=a;
                //a.addCommand("mceVisualChars",c._toggleVisualChars,c);
                a.addButton(
                    "upload",
                    {
                        title:"Загрузка файлов",
						image: b+'/img/upload.gif',
                        onclick: function() {
                            window.open('/upload/index?area='+ a.getParam('plugin_upload_area')+'&user_id='+ a.getParam('plugin_upload_user_id')+'&post_id='+ a.getParam('plugin_upload_post_id')+'&r_id='+ a.getParam('plugin_upload_r_id')+'&date_dir='+ a.getParam('plugin_upload_date_dir')+'&wysiwyg=yes', '_Addimage', 'toolbar=0,location=0,status=0, left=0, top=0, menubar=0,scrollbars=yes,resizable=0,width=640,height=550');
                        }
                    }
                );
            },
        });
    tinymce.PluginManager.add("upload",tinymce.plugins.Upload)
})();