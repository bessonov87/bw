<?php
namespace backend\components\editor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class TinyMCE extends InputWidget
{
    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language = 'ru';
    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];

    public $selectors = '#post-short';
    private $_tinymceAssetBundle;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        $this->_tinymceAssetBundle = TinyMceAsset::register($view);

        // Загружаем дефолтные значения настроек, если они не указаны в свойстве clientOptions
        $defaults = $this->defaultOptions();
        foreach($defaults as $key => $value) {
            if(!array_key_exists($key, $this->clientOptions)){
                $this->clientOptions[$key] = $value;
            }
        }

        if ($this->language !== null) {
            $this->clientOptions['language'] = $this->language;
            $this->clientOptions['script_url'] = $this->_tinymceAssetBundle->baseUrl . "/tiny_mce.js";
        }

        $options = Json::encode($this->clientOptions);

        $js[] = "$('".$this->selectors."').tinymce($options);";
        $view->registerJs(implode("\n", $js));
    }

    public function defaultOptions(){
        $defaults['theme'] = 'advanced';
        $defaults['skin'] = 'cirkuit';
        $defaults['width'] = '98%';
        $defaults['height'] = '400';
        $defaults['plugins'] = 'table,style,advhr,advimage,advlist,emotions,inlinepopups,media,searchreplace,print,contextmenu,paste,fullscreen,nonbreaking,upload';
        $defaults['relative_urls'] = false;
        $defaults['convert_urls'] = false;
        $defaults['media_strict'] = false;
        $defaults['paste_auto_cleanup_on_paste'] = false;
        $defaults['paste_text_use_dialog'] = true;
        $defaults['dialog_type'] = 'window';
        $defaults['forced_root_block'] = false;
        $defaults['force_br_newlines'] = false;
        $defaults['force_p_newlines'] = true;
        $defaults['extended_valid_elements'] = 'noindex,div[align|class|style|id|title]';
        $defaults['custom_elements'] = 'noindex';
        $defaults['theme_advanced_buttons1'] = 'formatselect,fontselect,fontsizeselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,backcolor,|,removeformat,cleanup,|,code';
        $defaults['theme_advanced_buttons2'] = 'print,|,tablecontrols,|,styleprops,|,sub,sup,|,charmap,advhr,visualaid';
        $defaults['theme_advanced_buttons3'] = 'cut,copy,|,paste,pastetext,pasteword,|,search,replace,|,outdent,indent,|,undo,redo,|,link,unlink,dle_leech,|,upload,image,media,dle_mp,dle_mp3,emotions,dle_spoiler,|,dle_tube,dle_quote,dle_code,dle_hide,dle_break,dle_page';
        $defaults['theme_advanced_toolbar_location'] = 'top';
        $defaults['theme_advanced_toolbar_align'] = 'left';
        $defaults['theme_advanced_statusbar_location'] = 'bottom';
        $defaults['plugin_upload_area'] = 'addpost';
        $defaults['plugin_upload_date_dir'] = date('Y-m');
        $defaults['plugin_upload_post_id'] = 0;
        $defaults['plugin_upload_user_id'] = \Yii::$app->user->getId();
        $defaults['plugin_upload_r_id'] = \Yii::$app->request->cookies->getValue('r_id');
        //$defaults['content_css'] = $this->_tinymceAssetBundle->baseUrl . "/css/content.css";
        $defaults['content_css'] = \Yii::$app->params['frontendBaseUrl'] . "/bw15/css/theme.css";
        /*$defaults['setup'] = "function(ed) { ed.addButton('dle_quote', {
			title : 'Вставка цитаты',
			image : '/admin/js/editor/tiny_mce/themes/advanced/img/dle_quote.gif',
			onclick : function() {
				// Add you own code to execute something on click
				ed.execCommand('mceReplaceContent',false,'[quote]' + ed.selection.getContent() + '[/quote]');
			}
	           }); }";
        $defaults[''] = '';
        $defaults[''] = '';
        $defaults[''] = '';
        $defaults[''] = '';*/
        //$defaults[''] = '';

        return $defaults;
    }
}