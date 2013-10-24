<?php
/**
 * @file        HookConsultingroom.class.php
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
 * @created     26.03.13
 */

if (!class_exists('Hook')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_HookConsultingroom extends Hook {

    public function RegisterHook() {
        $this->AddHook('template_consultingroom_menu', 'FetchConsultingroomsMenu');
    }

    public function FetchConsultingroomsMenu() {
        $sOut = '';
        $aConsultingrooms = $this->PluginConsultingroom_ModuleConsultingroom_GetConsultingroomItemsAll();

        $aRoomsList = array();
        $oViewerLocal = $this->Viewer_GetLocalViewer();
        foreach($aConsultingrooms as $oConsultingroom) {

            if(!LS::Adm() && !$oConsultingroom->getPublished()) continue;

            $oUser = $this->ModuleUser_GetUserById($oConsultingroom->getUserId());

            $aRoomsList[] = array(
                'name' => $oConsultingroom->getName(),
                'user_login' => $oUser->GetUserLogin(),
                );
        }

        $oViewerLocal->Assign('aConsultingrooms', $aRoomsList);
        $sOut = $oViewerLocal->Fetch(Plugin::GetTemplatePath(__CLASS__).'hooks/HookConsultingroom/menu.tpl');

        return $sOut;
    }
}
