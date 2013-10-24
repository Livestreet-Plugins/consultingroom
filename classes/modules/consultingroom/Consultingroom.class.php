<?php
/**
 * @file        Consultingroom.class.php
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

if(!class_exists('ModuleORM')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ModuleConsultingroom extends ModuleORM {
    public function Init() {
        parent::Init();
    }

}
