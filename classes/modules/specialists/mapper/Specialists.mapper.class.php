<?php
/**
 * @file        Specialists.mapper.class.php
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

if(!class_exists('Mapper')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ModuleSpecialists_MapperSpecialists extends Mapper {

    public function Get($bPublishedOnly = true) {
        $sql = 'SELECT * FROM `'.Config::Get('plugin.consultingroom.specialists.table').'` AS `sp`';
        $sql .= ' LEFT JOIN `'.Config::Get('plugin.consultingroom.users.table').'` AS `user` ON `sp`.`user_id`=`user`.`user_id`';
        $sql .= $bPublishedOnly ? ' WHERE `sp`.`published`=1' : '';

        $result = $this->oDb->select($sql);
        return $result;
    }

    public function Set($aSpecialists) {

        if(!is_array($aSpecialists)) {
            $aSpecialists = array($aSpecialists);
        }

        foreach($aSpecialists as $aSpecialist) {
            if(!isset($aSpecialist['consultingroom_id']) || empty($aSpecialist['consultingroom_id']) || $aSpecialist['consultingroom_id'] <= 0) {
                $this->_Insert($aSpecialist);
            } else {
                $this->_Update($aSpecialist);
            }
        }
    }

    protected function _Insert($aSpecialist) {
        $sql = 'INSERT INTO `'.Config::Get('plugin.consultingroom.specialists.table').'`';
        $sql .= '(`user_id`, `name`, `phone`, `description_short`, `published`)';
        $sql .= 'VALUES (?d,?s,?s,?s,?d)';

        return $this->oDb->query($sql, $aSpecialist['user_id'], $aSpecialist['name'], $aSpecialist['phone'], $aSpecialist['description_short'], $aSpecialist['published']);
    }

    protected function _Update($aSpecialist) {
        $sql = 'UPDATE `'.Config::Get('plugin.consultingroom.specialists.table').'`';
        $sql .= ' SET `user_id`=?d,`name`=?s,`phone`=?s,`description_short`=?s,`published`=?d';
        $sql .= ' WHERE `consultingroom_id`=?d';

        return $this->oDb->query($sql, $aSpecialist['user_id'], $aSpecialist['name'], $aSpecialist['phone'], $aSpecialist['description_short'], $aSpecialist['published'], $aSpecialist['consultingroom_id']);
    }

    public function Delete($aDeleteIds) {

        if(!is_array($aDeleteIds)) {
            $aDeleteIds = array($aDeleteIds);
        }

        foreach($aDeleteIds as $iDeleteId) {
            $this->_Delete($iDeleteId);
        }

    }

    protected function _Delete($iDeleteId) {

        if($iDeleteId <= 0) return false;

        $sql = 'DELETE FROM `'.Config::Get('plugin.consultingroom.specialists.table').'`';
        $sql .= ' WHERE `consultingroom_id`=?d';

        return $this->oDb->query($sql, $iDeleteId);
    }

    public function GetUsers() {
        $sql = 'SELECT `user_id`, `user_login`, `user_profile_name`, `user_mail`, `user_profile_about`, `user_profile_foto`, `user_profile_avatar`  FROM `'.Config::Get('plugin.consultingroom.users.table').'`';
        $sql .= ' ORDER BY `user_profile_name` ASC, `user_login` ASC';

        $aUsers = $this->oDb->select($sql);
        foreach($aUsers as $key => $aUser) {
            $aUsers[$key]['name'] = $this->GetUserName($aUser);
        }

        return $aUsers;
    }

    public function SetProfile($aProfile) {

        $sql = 'UPDATE `'.Config::Get('plugin.consultingroom.users.table').'`';
        $sql .= ' SET `user_mail`=?s, `user_profile_name`=?s,`user_profile_sex`=?s,`user_profile_country`=?s,`user_profile_region`=?s,';
        $sql .= '`user_profile_city`=?s,`user_profile_about`=?s,`user_profile_avatar`=?s,`user_profile_foto`=?s';
        $sql .= ' WHERE `user_id`=?d';

        PluginFirephp::GetLog($sql);

        $res = $this->oDb->query($sql,
            $aProfile['user_mail'], $aProfile['user_profile_name'], $aProfile['user_profile_sex'], $aProfile['user_profile_country'], $aProfile['user_profile_region'],
            $aProfile['user_profile_city'], $aProfile['user_profile_about'], $aProfile['user_profile_avatar'], $aProfile['user_profile_foto'],
            $aProfile['user_id']);

        PluginFirephp::GetLog($this->oDb);
        return $res;
    }

    public function GetUserName($aUser) {

        if(isset($aUser['user_profile_name']) && !empty($aUser['user_profile_name'])) {
            $sUserName = $aUser['user_profile_name'].' ('.$aUser['user_login'].')';
        } else {
            $sUserName = $aUser['user_login'];
        }

        return $sUserName;
    }

    public function GetSpecialistByUserLogin($sUserLogin) {

        $sql = 'SELECT * FROM `'.Config::Get('plugin.consultingroom.specialists.table').'` AS `sp`';
        $sql .= ' LEFT JOIN `'.Config::Get('plugin.consultingroom.users.table').'` AS `user` ON `sp`.`user_id`=`user`.`user_id`';
        $sql .= ' WHERE `user`.`user_login`=?s';

        $res = $this->oDb->selectRow($sql, $sUserLogin);

        return $res;

    }
}
