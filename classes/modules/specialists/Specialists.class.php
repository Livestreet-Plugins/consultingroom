<?php
/**
 * @file        Specialists.class.php
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

if(!class_exists('Module')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ModuleSpecialists extends Module {

    protected $oMapper;
    protected $oUserCurrent;

    public function Init() {
        $this->oUserCurrent=$this->User_GetUserCurrent();
        $this->oMapper=Engine::GetMapper(__CLASS__);
    }

    /**
     * Возвращает данные по всем специалистам созданным для Consultingroom
     * @param bool $bPublishedOnly - возвращать только разрешенных к публикации
     * @return mixed
     */
    public function Get($bPublishedOnly = true) {

        $sTag = 'consultingrooms_specialists_'.($bPublishedOnly ? 'published' : 'all');

        if(($aSpecialists = $this->Cache_Get($sTag)) === false) {
            $aSpecialists = $this->oMapper->Get($bPublishedOnly);
            $this->Cache_Set($aSpecialists, $sTag, array('specialists_changed'), Config::Get('plugin.consultingroom.cache.ttl'));
        }

        return $aSpecialists;
    }

    /**
     * Сохраняет данные по специалистам Consultingroom
     * @param $aSpecialists
     */
    public function Set($aSpecialists) {
        $this->oMapper->Set($aSpecialists);
    }

    public function Delete($aDeleteIds) {
        $this->oMapper->Delete($aDeleteIds);
    }

    /**
     * Возвращает данные по всем пользоваетлям, зарегистрированным в системе
     * @return mixed
     */
    public function GetUsers() {
        $sTag = 'consultingrooms_specialists_users';
        if(($aUsers = $this->Cache_Get($sTag)) === false) {
            $aUsers = $this->oMapper->GetUsers();
            $this->Cache_Set($aUsers, $sTag, array(), Config::Get('plugin.consultingroom.cache.ttl'));
        }

        return $aUsers;
    }

    /**
     * Сохраняет данные профиля передаваемые в массиве
     *
     * @param $aProfile
     */
    public function SetProfile($aProfile) {
        //@todo сброс кеша

        $oUser = $this->User_GetUserByLogin($aProfile['user_login']);
        $oUser->_setData($aProfile);
        $this->User_Update($oUser);

        //return $this->oMapper->SetProfile($aProfile);
    }

    /**
     * Возвращает имя пользователя - user_profile_name + (user_login) если user_profile_name задан
     * иначе - тлько user_login
     *
     * @param $aUser - массив записи user
     * @return string
     */
    public function GetUserName($aUser) {
        return $this->oMapper->GetUserName($aUser);
    }

    public function GetSpecialistByUserLogin($sUserLogin) {

        if(true) {
            $aSpecialist = $this->oMapper->GetSpecialistByUserLogin($sUserLogin);
        }

        return $aSpecialist;
    }
}
