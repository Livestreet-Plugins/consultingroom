<?php
/**
 * @file        Communication.entity.class.php
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

class PluginConsultingroom_ModuleConsultingroom_EntityCommunication extends EntityORM {

    protected $aRelations = array(
        'consultingroom' => array(EntityORM::RELATION_TYPE_BELONGS_TO, 'PluginConsultingroom_ModuleConsultingroom_EntityConsultingroom', 'consultingroom_id'),
    );

    protected $aValidateRules = array(
        //какого-то хрена не видит валидатор:
        //Fatal error: Class 'ModuleValidate_EntityValidatorInt' not found in T:\home\const\takzdorovo-to\engine\classes\Engine.class.php on line 807
        //@todo прописать сущность валидатора в движке?
//        array('communication_id, consultingroom_id', 'id'),
//        array('communication_question_date, communication_answer_date', 'int', 'max' => 9999999999, 'min' => 0, ),
        array('consultingroom_id', 'required'),
        array('communication_question', 'required'),
        array('communication_enquirer', 'required'),
        array('communication_enquirer', 'string', 'allowEmpty'=>false,'min' => 3,),
        array('communication_question, communication_answer', 'string', 'max' => 2000),
        array('communication_enquirer_mail', 'email', 'allowEmpty'=>false),
        array('communication_published', 'boolean'),
    );

    public function ValidateId($iValue, $aParams) {
        $aParams['max'] = isset($aParams['max']) ? $aParams['max'] : 9999999999;
        $aParams['min'] = isset($aParams['min']) ? $aParams['min'] : 0;
        if(!is_integer($iValue)) {
            return $this->Lang_Get('plugin.consultingroom.errors.integer.not_integer');
        } elseif($iValue > $aParams['max']) {
            return $this->Lang_Get('plugin.consultingroom.errors.id.max');
        } elseif($iValue < $aParams['min']) {
            return $this->Lang_Get('plugin.consultingroom.errors.id.min');
        }
        return true;
    }
}
