<?php
/**
 * @file        Consultingroom.entity.class.php
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
 * @created     19.03.13
 */

if (!class_exists('EntityORM')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ModuleConsultingroom_EntityConsultingroom extends EntityORM {
    protected $aRelations = array(
        'user' => array(EntityORM::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id'),
        'news' => array(EntityORM::RELATION_TYPE_HAS_MANY, 'PluginConsultingroom_ModuleConsultingroom_EntityNews', 'consultingroom_id'),
        'communication' => array(EntityORM::RELATION_TYPE_HAS_MANY, 'PluginConsultingroom_ModuleConsultingroom_EntityCommunication', 'consultingroom_id'),
    );
}
