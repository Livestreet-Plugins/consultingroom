<?php
/**
 * @file        News.entity.class.php
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
 * @created     21.03.13
 */

if (!class_exists('EntityORM')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ModuleConsultingroom_EntityNews extends EntityORM {

    protected $aRelations = array(
        'consultingroom' => array(EntityORM::RELATION_TYPE_BELONGS_TO, 'PluginConsultingroom_ModuleConsultingroom_EntityConsultingroom', 'consultingroom_id'),
    );

}
