<?php
/**
 * @file        config.php
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

$config = array ();

$config['$root$']['router']['page']['consultingroom'] = 'PluginConsultingroom_ActionConsultingroom';

$config['consultingroom']['table'] = '___db.table.prefix___consultingroom';
//это от старого варианта, пока используется
$config['specialists']['table'] = '___db.table.prefix___consultingroom';

$config['news'] = array(
    'table' => '___db.table.prefix___consultingroom_news',
    //Переносить новые в актуально
    'new_to_actual' => true,
    //'topics' - отображать топики специалиста кабинета или 'news' - отображать новости
    'show' => 'topics',
    'topics' => array(
        //ID блога топики которого будут выводиться как новости (если значение ['show'] = 'topics')
        'blog_id' => 4,
    ),
);

$config['communication'] = array(
    'table' => '___db.table.prefix___consultingroom_communication',
    //Показывать вопросы без ответа
    'show_not_answered' => false,
);

$config['users'] = array(
    'table' => '___db.table.prefix___user',
/*    'photo' => array(
        'width' => 300,
        'max-height' => 400,
    ),*/
);

//plugin's cache settings
$config['cache']['ttl'] = 1;
$config['date_format'] = 'd-m-Y H:i';
//reqular expression against symbols that can be used as SQL injection
$config['sql_clean'] = '/[=\/\*;\"\`]/im';
$config['show_donate_link'] = 1;

$config['logs'] = array(
    'group_request' => array(
        'sent' => true,
    ),
);

return $config;
