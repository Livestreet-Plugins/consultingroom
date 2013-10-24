<?php
/**
 * @file        russian.php
 * @description
 *
 * PHP Version  5.3
 *
 * @package     Consultingroom plugin
 * @category    Language
 * @plugin URI
 * @copyright   2013, Vadim Pshentsov. All Rights Reserved.
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author      Vadim Pshentsov <pshentsoff@gmail.com>
 * @created     16.03.13
 */

return array(
    'title' => 'Consultingroom',
    'admin' => 'Специалисты',
    'description' => 'Описание',
    'license' => 'Лицензия',
    'donate' => 'Пожертвования',
    'goback' => 'Вернуться',
    'nodata' => 'Нет данных',
    'question' => 'Вопрос',
    'question_from' => 'Вопрос от',
    'answer' => 'Ответ',
    'edit' => 'Редактировать',
    'main_menu' => 'Кабинет врача',
    'new_record' => 'Новая запись',

    'buttons' => array(
        'add' => 'Добавить',
        'delete' => 'Удалить',
        'save' => 'Сохранить',
        'record2group' => 'Запись в группу занятий',
        'news' => 'Новости',
        'communication' => 'Общение',
        'edit' => array(
            'news' => 'Редактировать новости',
            'questions' => 'Редактировать вопросы',
            'add' => 'Добавить новость',
        ),
    ),

    'elements' => array(
        'please_select' => 'Выберите, пожалуйста...',
        'ask_question' => 'Задайте свой вопрос',
        'your_name' => 'Пожалуйста, представьтесь',
        'your_mail' => 'Ваш Email (не публикуется)',
        'your_question' => 'Ваш вопрос',
        'send_question' => 'Отправить вопрос',
    ),

    'specialists' => array(
        'title' => 'Специалисты',
        'user_id' => 'Специалист',
        'name' => 'Наименование кабинета',
        'phone' => 'Контактный телефон',
        'description_short' => 'Краткое описание',
        'published' => 'Кабинет доступен посетителям',
        'go_consultingroom' => 'Перейти в кабинет',
    ),

    'users' => array(
        'edit' => 'Изменить',
        'user_id' => 'ID',
        'name' => 'Полное имя (логин)/Логин',
        'user_mail' => 'Email',
        'user_login' => 'Логин',
        'user_profile_name' => 'Полное имя',
        'user_profile_avatar' => 'Аватарка',
        'user_profile_foto' => 'Фото (ширина:300, высота (max):400)',
        'user_profile_sex' => 'Пол',
        'user_profile_country' => 'Страна',
        'user_profile_region' => 'Область/штат/регион',
        'user_profile_city' => 'Город/нас.пункт',
        'user_profile_about' => 'Информация',
    ),

    'news' => array(
        'news_date_created' => 'Создана',
        'news_date_edited' => 'Последнее редактирование',
        'news_date' => 'Дата новости',
        'news_published' => 'Опубликована',
        'news_text' => 'Текст новости',
    ),

    'communication' => array(
        'communication_question_date' => 'Вопрос задан',
        'communication_enquirer'=> 'Вопрос задал',
        'communication_enquirer_mail' => 'Email задавшего',
        'communication_published' => 'Вопрос опубликован',
        'communication_answer_date' => 'Ответ дан',
        'communication_answer' => 'Текст ответа',
        'communication_question' => 'Текст вопроса',
        'messages' => array(
            'question' => array(
                'sent' => 'Спасибо за сообщение! Ваш вопрос передан специалисту.',
                'error' => 'Ваше сообщение содержит ошибочные сведения.',
            ),
        ),
    ),

    'group_request' => array(
        'title' => 'Запись в группу занятий',
        'first_name' => 'Имя',
        'second_name' => 'Фамилия',
        'patronymic' => 'Отчество',
        'contact_phone' => 'Контактный телефон',
        'contact_mail' => 'Контактный Email',
        'send_request' => 'Отправить заявку',
        'messages' => array(
            'request_sent' => 'Ваша заявка отправлена специалисту.',
            'mail_subject' => 'Запись в группу занятий',
            'error' => array(
                'first_name' => array(
                    'empty' => '',
                    ),
                'second_name' => array(
                    'empty' => '',
                    ),
                'patronymic' => array(
                    'empty' => '',
                ),
                'contact_mail' => array(
                    'empty' => '',
                ),
                'contact_phone' => array(
                    'empty' => '',
                ),
            ),
        ),
    ),

    'errors' => array(
        'id' => array(
            'min' => 'Значение меньше минимально допустимого',
            'max' => 'Превышено максимально допустимое значение.',
        ),
        'integer' => array(
            'not_integer' => 'Значением данного поля может быть только целое число.',
        ),
    ),

);