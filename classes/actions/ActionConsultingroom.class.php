<?php
/**
 * @file        ActionConsultingroom.class.php
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

if(!class_exists('Action')) {
    die('This script can not be executed directly.');
}

class PluginConsultingroom_ActionConsultingroom extends ActionPlugin {

    protected $oViewerLocal;

    public function Init() {

        $this->oViewerLocal=$this->Viewer_GetLocalViewer();

        $this->SetDefaultEvent('index');

    }

    public function RegisterEvent() {
        //Common service actions and pages
        $this->AddEvent('description', 'ShowDescription');
        $this->AddEvent('license', 'ShowLicense');
        $this->AddEvent('donate', 'ShowDonate');

        //Admin pages and actions
        $this->AddEvent('admin', 'AdminMain');
        $this->AddEvent('profile', 'AdminProfile');

        //Public pages and actions
        $this->AddEvent('index', 'IndexRooms');

        //Specialists pages and actions
        $this->AddEvent('specialist', 'Consultingroom');
    }

    protected function ShowDescription() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.consultingroom.title').' : '.$this->Lang_Get('plugin.consultingroom.description'));
        $this->Viewer_Assign('sURLBack', 'consultingroom/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.consultingroom.goback'));
        $this->Viewer_Assign('sTextFile', Plugin::GetPath(__CLASS__).'/Readme.txt');
        $this->SetTemplateAction('showtext');
    }

    protected function ShowLicense() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.consultingroom.title').' : '.$this->Lang_Get('plugin.consultingroom.license'));
        $this->Viewer_Assign('sURLBack', 'consultingroom/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.consultingroom.goback'));
        $this->Viewer_Assign('sTextFile', Plugin::GetPath(__CLASS__).'/License.txt');
        $this->SetTemplateAction('showtext');
    }

    protected function ShowDonate() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.consultingroom.title').' : '.$this->Lang_Get('plugin.consultingroom.donate'));
        $this->Viewer_Assign('sURLBack', 'consultingroom/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.consultingroom.goback'));
        $this->Viewer_Assign('sHTMLFile', Plugin::GetPath(__CLASS__).'/Donate.html');
        $this->SetTemplateAction('showtext');
    }

    protected function AdminMain() {

        if (!LS::Adm()) {
            return parent::EventNotFound();
        }

        if(isPost('consultingroom_specialists_add')) {
            $this->Viewer_Assign('bSpecialistAddNew', 1);
        } elseif(isPost('consultingroom_specialists_delete')) {
            $aSpecialists = getRequest('specialists', array(), 'post');
            $aDelete = array();
            foreach($aSpecialists as $aSpecialist) {
                if(isset($aSpecialist['selected']) && ($aSpecialist['selected'] == 'on'))
                    $aDelete[] = $aSpecialist['consultingroom_id'];
            }
            if(!empty($aDelete)) $this->PluginConsultingroom_Specialists_Delete($aDelete);
            unset($aSpecialists);
            unset($aDelete);
        } elseif(isPost('consultingroom_specialists_save')) {
            $aSpecialists = getRequest('specialists', array(), 'post');
            foreach($aSpecialists as $key => $aSpecialist) {
                $aSpecialists[$key]['published'] = isset($aSpecialist['published']) ? 1 : 0;
            }
            PluginFirephp::GetLog($aSpecialists);
            $this->PluginConsultingroom_Specialists_Set($aSpecialists);
            unset($aSpecialists);
        }

        $aUsers = $this->PluginConsultingroom_Specialists_GetUsers();
        $aSpecialists = $this->PluginConsultingroom_Specialists_Get(false);

        $this->Viewer_Assign('aUsers', $aUsers);
        $this->Viewer_Assign('aSpecialists', $aSpecialists);
        $this->Viewer_Assign('sActionConsultingroomMenuTemplate', Plugin::GetTemplatePath(__CLASS__).'actions/ActionConsultingroom/admin/menu.tpl');
        $this->Viewer_Assign('bShowDonateLink', Config::Get('plugin.consiltingroom.show_donate_link'));
        $this->SetTemplateAction('admin/index');
    }

    protected  function AdminProfile() {

        if (!LS::Adm()) {
            return parent::EventNotFound();
        }

        if(isPost('consultingroom_profile_save')) {
            $aProfile = getRequest('profile', array(), 'post');
            //@todo проверку параметров
            $this->PluginConsultingroom_Specialists_SetProfile($aProfile);
            $sUserLogin = $aProfile['user_login'];
            unset($aProfile);
        } else {
            $sUserLogin = $this->GetParam(0);
        }

        $aProfile = array();
        if(($oUser = $this->User_GetUserByLogin($sUserLogin)) && is_object($oUser)) {
            $aProfile = $oUser->_getData();
            $aProfile['name'] = $this->PluginConsultingroom_Specialists_GetUserName($aProfile);
        }

        $this->Viewer_Assign('aProfile', $aProfile);
        $this->Viewer_Assign('sActionConsultingroomMenuTemplate', Plugin::GetTemplatePath(__CLASS__).'actions/ActionConsultingroom/admin/menu.tpl');
        $this->Viewer_Assign('bShowDonateLink', Config::Get('plugin.consiltingroom.show_donate_link'));
        $this->SetTemplateAction('admin/profile');
    }

    protected function IndexRooms() {

        $aSpecialists = $this->PluginConsultingroom_Specialists_Get(true);
        $this->Viewer_Assign('aSpecialists', $aSpecialists);
        $this->SetTemplateAction('index');
    }

    /**
     * Обработка формы редактирования новостей (не блоговых)
     * @param $oUser
     * @return string
     */
    protected function EditNews($oUser) {

        // Данная ф. вызывается уже после проверок, повторная проверка не нужна

        $iNow = time();

        if(isPost('consultingroom_edit_news_add')) {
            $this->Viewer_Assign('bConsultingroomAddNew', 1);
        } elseif(isPost('consultingroom_edit_news_delete')) {
            $aNews = getRequest('news', array(), 'post');
            foreach($aNews as $aRow) {
                if(isset($aRow['selected']) && ($aRow['selected'] == 'on')) {
                    $oNews = array_shift($this->PluginConsultingroom_ModuleConsultingroom_GetNewsItemsByNewsId($aRow['news_id'], array('#cache'=>'')));
                    if($oNews && is_object($oNews)) $oNews->Delete();
                }
            }
            unset($aNews);
        } elseif(isPost('consultingroom_edit_news_save')) {
            $aNews = getRequest('news', array(), 'post');
            foreach($aNews as $key => $aRow) {

                $oNews = Engine::GetEntity('PluginConsultingroom_ModuleConsultingroom_EntityNews');
                //Новая запись?
                $bNew = !isset($aRow['news_id']);

                //Подготовка данных новостной записи
                if($bNew) {
                    $aRow['news_date_created'] = $iNow;
                } else {
                    unset($aRow['news_date_created']);
                }
                $aRow['news_date'] = strtotime($aRow['news_date_str']);
                $aRow['news_date_edited'] = $iNow;
                $aRow['news_published'] = (isset($aRow['news_published']) && ($aRow['news_published'] == 'on')) ? 1 : 0;

                unset($aRow['news_date_edited_str']);
                unset($aRow['news_date_created_str']);
                unset($aRow['news_date_str']);

                $oNews->_setData($aRow);

                if($bNew) {
                    $oNews->Add();
                } else {
                    $oNews->Update();
                }

            }
            unset($aNews);
        }

        $oConsultingroom = array_shift($this->PluginConsultingroom_ModuleConsultingroom_GetConsultingroomItemsByUserId($oUser->GetId(), array('#cache'=>'')));
        //Если у пользователя нет консультационного кабинета
        if(empty($oConsultingroom) || !is_object($oConsultingroom)) {
            return parent::EventNotFound();
        }
        $aNews = $this->PluginConsultingroom_ModuleConsultingroom_GetNewsItemsByConsultingroomId($oConsultingroom->getId(), array('#cache'=>''));

        $aConsultingroom = $oConsultingroom->_getData();
        $aConsultingroom['user'] = $oUser->_getData();
        $aConsultingroom['news'] = array();
        foreach($aNews as $oNews) {
            $aNewsData = $oNews->_getData();
            $aNewsData['news_date_created_str'] = date(Config::Get('plugin.consultingroom.date_format'), $aNewsData['news_date_created']);
            $aNewsData['news_date_edited_str'] = date(Config::Get('plugin.consultingroom.date_format'), $aNewsData['news_date_edited']);
            $aNewsData['news_date_str'] = date(Config::Get('plugin.consultingroom.date_format'), $aNewsData['news_date']);
            $aConsultingroom['news'][] = $aNewsData;
        }
        $aConsultingroom['now'] = date(Config::Get('plugin.consultingroom.date_format'), $iNow);

        $this->Viewer_Assign('aConsultingroom', $aConsultingroom);
        $this->SetTemplateAction('admin/edit.news');
    }

    /**
     * Обрабатывает строковыую переменную экранируя кавычки и прочие символы, либо удаляет их по регулярному выражению
     * @param $sValue
     * @return string
     */
    public function SQLClean($sValue) {

        if(isset($sValue) && !empty($sValue)) {

            if (get_magic_quotes_gpc()) {
                $sValue = stripslashes($sValue);
            }
            else {
                $sValue = preg_replace(Config::Get('plugin.consultingroom.sql_clean'), "", $sValue);
            }

            $sValue = mysql_real_escape_string($sValue);
            return $sValue;

            // Empty or null or ...
        } else {
            return $sValue;
        }
    }

    /**
     * Обработка формы редактирования вопросов (Общения)
     * @param $oUser
     * @return string
     */
    protected function EditQuestions($oUser) {

        $iNow = time();

        if(isPost('consultingroom_edit_communication_delete')) {
            $aCommunication = getRequest('communication', array(), 'post');
            foreach($aCommunication as $aRow) {
                if(isset($aRow['selected']) && ($aRow['selected'] == 'on')) {
                    $oCommunication = array_shift($this->PluginConsultingroom_ModuleConsultingroom_GetCommunicationItemsByCommunicationId($aRow['communication_id'], array('#cache'=>'')));
                    if($oCommunication && is_object($oCommunication)) $oCommunication->Delete();
                }
            }
            unset($oCommunication);
        } elseif(isPost('consultingroom_edit_communication_save')) {

            $aCommunication = getRequest('communication', array(), 'post');
            foreach($aCommunication as $aRow) {

                $oCommunication = Engine::GetEntity('PluginConsultingroom_ModuleConsultingroom_EntityCommunication');
                $aRow2Save = array();
                //Новая запись?
                $bNew = !isset($aRow['communication_id']);
                //@todo проверка всех полей с переносом в другой массив
                //@todo кроме того - разобраться с проверкой ORM
                if(!$bNew) {
                    $aRow2Save['communication_id'] = (int)$aRow['communication_id'];
                } else {
                    $aRow2Save['consultingroom_id'] =(int)$aRow['consultingroom_id'];
                }
                $aRow2Save['communication_published'] = (int)(isset($aRow['communication_published']) && ($aRow['communication_published'] == 'on')) ? 1 : 0;

                $aRow2Save['communication_question'] = isset($aRow['communication_question'])? htmlspecialchars($aRow['communication_question'], ENT_QUOTES) : '';
                $aRow2Save['communication_question'] = $this->SQLClean($aRow2Save['communication_question']);

                $aRow2Save['communication_answer'] = isset($aRow['communication_answer']) ? htmlspecialchars($aRow['communication_answer'], ENT_QUOTES) : '';
                $aRow2Save['communication_answer'] = $this->SQLClean($aRow2Save['communication_answer']);

                //Если дан ответ - запоминаем дату, если она пуста
                if(!empty($aRow2Save['communication_answer']) && empty($aRow['communication_answer_date'])) $aRow2Save['communication_answer_date'] = $iNow;

                $oCommunication->_setData($aRow2Save);
                $oCommunication->_Validate();

                unset($aRow2Save);

                if($bNew) {
                    $oCommunication->Add();
                } else {
                    $oCommunication->Update();
                }

            }
            unset($oCommunication);
        }

        $oConsultingroom = array_shift($this->PluginConsultingroom_ModuleConsultingroom_GetConsultingroomItemsByUserId($oUser->GetId(), array('#cache'=>'')));
        //Если у пользователя нет консультационного кабинета
        if(empty($oConsultingroom) || !is_object($oConsultingroom)) {
            return parent::EventNotFound();
        }
        $aCommunication = $this->PluginConsultingroom_ModuleConsultingroom_GetCommunicationItemsByConsultingroomId($oConsultingroom->getId(), array('#cache'=>''));

        $aConsultingroom = $oConsultingroom->_getData();
        $aConsultingroom['user'] = $oUser->_getData();
        $aConsultingroom['now'] = date(Config::Get('plugin.consultingroom.date_format'), $iNow);
        //Подготавливаем данные общения
        $aConsultingroom['communication'] = array();
        foreach($aCommunication as $oCommunication) {
            $aData = $oCommunication->_getData();
            $aData['communication_question_date_str'] = date(Config::Get('plugin.consultingroom.date_format'), $aData['communication_question_date']);
            $aData['communication_answer_date_str'] = (!empty($aData['communication_answer_date']) ? date(Config::Get('plugin.consultingroom.date_format'), $aData['communication_answer_date']) : '');

            $aConsultingroom['communication'][] = $aData;
        }

        $this->Viewer_Assign('aConsultingroom', $aConsultingroom);
        $this->SetTemplateAction('admin/edit.questions');
    }

    protected function SendQuestion($oConsultingroom) {

        $oCommunication = Engine::GetEntity('PluginConsultingroom_ModuleConsultingroom_EntityCommunication');

        $aRequest = getRequest('communication', array(), 'post');

        $aQuestion['communication_enquirer'] = $this->SQLClean(htmlspecialchars(isset($aRequest['enquirer_name']) ? $aRequest['enquirer_name'] : ''));
        $aQuestion['communication_enquirer_mail'] = $this->SQLClean(htmlspecialchars(isset($aRequest['enquirer_mail']) ? $aRequest['enquirer_mail'] : ''));
        $aQuestion['communication_question'] = $this->SQLClean(htmlspecialchars(isset($aRequest['enquirer_question']) ? $aRequest['enquirer_question'] : ''));
        $aQuestion['communication_question_date'] = time();
        $aQuestion['consultingroom_id'] = $oConsultingroom->getId();
        $aQuestion['communication_published'] = 0;

        $oCommunication->_setData($aQuestion);
        if(!$oCommunication->_Validate()) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.communication.messages.question.error'));
            return false;
        }
        $oCommunication->Add();

        $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.communication.messages.question.sent'));
        return true;
    }

    protected function SendMail($sMail, $sName, $sSubject, $sMailTemplate, $aTemplateAssign = array()) {

        foreach($aTemplateAssign as $key => $value) {
            $this->oViewerLocal->Assign($key, $value);
        }
        $sMessage = $this->oViewerLocal->Fetch($sMailTemplate);

        $this->Mail_SetAdress($sMail,$sName);
        $this->Mail_SetSubject($sSubject);
        $this->Mail_SetBody($sMessage);
        $this->Mail_setHTML();
        $this->Mail_Send();

        if(Config::Get('plugin.consultingroom.logs.group_request.sent')) {
            $this->Logger_Notice("Mail sent to $sName <$sMail> with subject '$sSubject'");
//            $this->Logger_Notice($sMessage);
        }

    }

    protected function SendGroupRequest($oUser) {

        $aRequest = getRequest('grouprequest', array(), 'post');

        $aRequest['first_name'] = htmlspecialchars(isset($aRequest['first_name']) ? $aRequest['first_name'] : '');
        if(empty($aRequest['first_name'])) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.error.first_name.empty'));
            return false;
        }
        $aRequest['second_name'] = htmlspecialchars(isset($aRequest['second_name']) ? $aRequest['second_name'] : '');
        if(empty($aRequest['second_name'])) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.error.second_name.empty'));
            return false;
        }
        $aRequest['patronymic'] = htmlspecialchars(isset($aRequest['patronymic']) ? $aRequest['patronymic'] : '');
        if(empty($aRequest['patronymic'])) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.error.patronymic.empty'));
            return false;
        }
        $aRequest['contact_mail'] = htmlspecialchars(isset($aRequest['contact_mail']) ? $aRequest['contact_mail'] : '');
        if(empty($aRequest['contact_mail'])) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.error.contact_mail.empty'));
            return false;
        }
        $aRequest['contact_phone'] = htmlspecialchars(isset($aRequest['contact_phone']) ? $aRequest['contact_phone'] : '');
        if(empty($aRequest['contact_phone'])) {
            $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.error.contact_phone.empty'));
            return false;
        }

        $aRequest['full_name'] = $aRequest['second_name'].' '.$aRequest['first_name'].' '.$aRequest['patronymic'];

        $sSubject = $this->Lang_Get('plugin.consultingroom.group_request.messages.mail_subject');

        $this->SendMail($oUser->getMail(), $oUser->getLogin(), $sSubject, Plugin::GetTemplatePath(__CLASS__).'actions/ActionConsultingroom/mail/group_request.to_specialist.tpl', $aRequest);
        $this->SendMail($aRequest['contact_mail'], $aRequest['full_name'], $sSubject, Plugin::GetTemplatePath(__CLASS__).'actions/ActionConsultingroom/mail/group_request.to_requester.tpl', $aRequest);

        $this->Viewer_Assign('sConsultingroomMessage', $this->Lang_Get('plugin.consultingroom.group_request.messages.request_sent'));
        return true;
    }

    /**
     * Отработка по форме консультации специалиста
     * @return string
     */
    protected function Consultingroom() {

        $sUserLogin = $this->GetParam(0);
        //не указан специалист для консультации
        if(empty($sUserLogin)) {
            return parent::EventNotFound();
        }
        $oUser = $this->ModuleUser_GetUserByLogin($sUserLogin);
        //указанный пользователь отсутствует в БД
        if(empty($oUser) || !is_object($oUser)) {
            return parent::EventNotFound();
        }

        $bRoomOwner = false;
        $bCanEdit = false;
        //Определяем посетителя
        $oCurrentUser = $this->User_GetUserCurrent();
        //Если посетитель авторизован и это не гость
        if($oCurrentUser && is_object($oCurrentUser) && ($oCurrentUser->GetUserLogin() != 'guest') ) {

            //Редактирование разрешено хозяину кабинета и администраторам
            $bCanEdit = ($bRoomOwner = ($oCurrentUser->GetUserLogin() == $sUserLogin)) || LS::Adm();

            //Запрошено и разрешено редактирование
            if($bCanEdit && ($this->GetParam(1) == 'edit')) {

                // Определяем что редактируется
                if($this->GetParam(2) == 'news') {
                    $this->EditNews($oUser);
                }elseif($this->GetParam(2) == 'questions') {
                    $this->EditQuestions($oUser);
                } else {
                    return parent::EventNotFound();
                }
                return;
            }
        }

        $oConsultingroom = array_shift($this->PluginConsultingroom_ModuleConsultingroom_GetConsultingroomItemsByUserId($oUser->GetId(), array('#cache'=>'')));
        //Если у пользователя нет консультационного кабинета
        if(empty($oConsultingroom) || !is_object($oConsultingroom)) {
            return parent::EventNotFound();
        }

        if(isPost('consultingroom_communication_askform_submit')) {
            if(!$this->SendQuestion($oConsultingroom)) {
                $aRequest = getRequest('communication', array(), 'post');
                $this->Viewer_Assign('aPrevRequest', $aRequest);
            }
        } elseif(isPost('consultingroom_communication_grouprequestform_submit')) {
            $this->SendGroupRequest($oUser);
        }

        $aConsultingroom = $oConsultingroom->_getData();
        $aConsultingroom['edit'] = (int)$bCanEdit;
        $aConsultingroom['owner'] = (int)$bRoomOwner;
        $aConsultingroom['user'] = $oUser->_getData();

        //Подготавливаем данные новостей
        if(Config::Get('plugin.consultingroom.news.show') == 'news') {
            //Отображаем новости
            $aNews = $this->PluginConsultingroom_ModuleConsultingroom_GetNewsItemsByConsultingroomId($oConsultingroom->getId(), array('#cache'=>''));
            $aConsultingroom['news'] = array();
            foreach($aNews as $oNews) {
                $aData = $oNews->_getData();
                //Неопубликованные пропускаем
                if(!$aData['news_published'] ) continue;
                $aData['news_date'] = date(Config::Get('plugin.consultingroom.date_format'), $aData['news_date']);

                $aConsultingroom['news'][] = $aData;
            }
        } elseif(Config::Get('plugin.consultingroom.news.show') == 'topics') {
            //Отображаем топики специалиста
            $aTopicsFilter = array(
                'user_id' => $oUser->GetId(),
                'blog_id' => Config::Get('plugin.consultingroom.news.topics.blog_id'),
            );
            if(!$bCanEdit) $aTopicsFilter['topic_publish'] = 1;
            $aTopics = array_shift($this->Topic_GetTopicsByFilter($aTopicsFilter));
            $this->Viewer_Assign('aTopics', $aTopics);
        }

        //Подготавливаем данные общения
        $aCommunication = $this->PluginConsultingroom_ModuleConsultingroom_GetCommunicationItemsByConsultingroomId($oConsultingroom->getId(), array('#cache'=>''));
        $aConsultingroom['communication'] = array();
        foreach($aCommunication as $oCommunication) {
            $aData = $oCommunication->_getData();
            //Неопубликованные пропускаем
            if(!$aData['communication_published']) continue;
            //Пропускаем без ответа если настроено
            if(empty($aData['communication_answer']) && !Config::Get('plugin.consultingroom.communication.show_not_answered')) continue;
            $aData['communication_question_date'] = date(Config::Get('plugin.consultingroom.date_format'), $aData['communication_question_date']);
            $aData['communication_answer_date'] = date(Config::Get('plugin.consultingroom.date_format'), $aData['communication_answer_date']);

            $aConsultingroom['communication'][] = $aData;
        }

        $this->Viewer_Assign('aConsultingroom', $aConsultingroom);
        $this->SetTemplateAction('consultingroom');
    }
}
