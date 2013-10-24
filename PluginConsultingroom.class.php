<?php
/**
 * @file        PluginConsultingroom.class.php
 * @description
 *
 * PHP Version  5.3
 *
 * @package
 * @category
 * @plugin URI
 * @copyright   2013, Vadim Pshentsov. All Rights Reserved.
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author      Vadim Pshentsov <pshentsoff@gmail.com>
 * @created     16.03.13
 */

if(!class_exists('Plugin')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom extends Plugin {

    public function Init() {
        parent::Init();
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__).'css/consultingroom.css');

        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/jquery.validate.min.js');
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/messages_ru.js');
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/consultingroom.js');
    }

    public function Activate() {
        $file = dirname(__FILE__).'/sql/install.sql';
        if(file_exists($file)) {
            $this->ExportSQL($file);
        }
        return true;
    }

    public function Deactivate() {
        $file = dirname(__FILE__).'/sql/uninstall.sql';
        if(file_exists($file)) {
            $this->ExportSQL($file);
        }
        return true;
    }

}
