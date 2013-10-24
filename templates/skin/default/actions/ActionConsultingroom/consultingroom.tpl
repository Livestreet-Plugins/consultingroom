{include file='header.tpl'}
<div class="consultinroom">
<div class="title">{$aConsultingroom.name}</div>
    {if $sConsultingroomMessage}
    <div class="consultingroom-message">
        <span>
            {$sConsultingroomMessage}
        </span>
    </div>
    {/if}
    {if $aConsultingroom.edit}
        <div class="topic">
            <div class="topic-header">
                <ul class="topic-actions">
                {if $oConfig->GetValue('plugin.consultingroom.news.show') EQ 'news'}
                    <li class="edit"><i class="icon-synio-actions-edit"></i><a href="/consultingroom/specialist/{$aConsultingroom.user.user_login}/edit/news" title="{$aLang.plugin.consultingroom.buttons.edit.news}" class="actions-edit">{$aLang.plugin.consultingroom.buttons.edit.news}</a></li>
                {elseif $oConfig->GetValue('plugin.consultingroom.news.show') EQ 'topics'}
                    {if $aConsultingroom.owner}
                    <li class="edit"><i class="icon-synio-actions-edit"></i><a href="{router page="/topic/add"}" title="{$aLang.plugin.consultingroom.buttons.edit.add}" class="actions-edit">{$aLang.plugin.consultingroom.buttons.edit.add}</a></li>
                    {/if}
                {/if}
                    <li class="edit"><i class="icon-synio-actions-edit"></i><a href="{router page="/consultingroom/specialist/"}{$aConsultingroom.user.user_login}/edit/questions" title="{$aLang.plugin.consultingroom.buttons.edit.questions}" class="actions-edit">{$aLang.plugin.consultingroom.buttons.edit.questions}</a></li>
                </ul>
            </div>
        </div>
    {/if}
    <div class="consultingroom-foto">
        <img src="{$aConsultingroom.user.user_profile_foto}" alt="{$aConsultingroom.user.user_profile_name}"/>
    </div>
    <div class="consultingroom-info">
        <div class="consultingroom-about">
            <span class="col-item-desc"><p>
            {$aConsultingroom.user.user_profile_about}
            </p></span>
        </div>
        <div class="consultingroom-phone">
            <p>
            {$aLang.plugin.consultingroom.specialists.phone}: {$aConsultingroom.phone}
            </p>
        </div>
        <div class="consultingroom-mail">
            <p>
            {$aLang.plugin.consultingroom.users.user_mail}: {$aConsultingroom.user.user_mail}
            </p>
        </div>
        <div class="consultingroom-buttons">
            <button class="js-consultingroom-group-request-form-show">{$aLang.plugin.consultingroom.buttons.record2group}</button>
        </div>
    </div>
    <div class="consultingroom-group-request-container">
        <div id="consultingroom-group-request-form" class="consultingroom-group-request">
            <form id="consultingroomCommunicationGroupRequestForm" method="post" action="" class="consultingroom-communication-form">
                <fieldset title="{$aLang.plugin.consultingroom.group_request.title}" form="consultingroomCommunicationGroupRequestForm">
                    <p>
                        <label for="ccgrfsname">* {$aLang.plugin.consultingroom.group_request.second_name}:</label>
                        <input id="ccgrfsname" type="text" class="required" name="grouprequest[second_name]"/>
                    </p>
                    <p>
                        <label for="ccgrffname">* {$aLang.plugin.consultingroom.group_request.first_name}:</label>
                        <input id="ccgrffname" type="text" class="required" name="grouprequest[first_name]"/>
                    </p>
                    <p>
                        <label for="ccgrfpatronymic">* {$aLang.plugin.consultingroom.group_request.patronymic}:</label>
                        <input id="ccgrfpatronymic" type="text" class="required" name="grouprequest[patronymic]"/>
                    </p>
                    <p>
                        <label for="ccgrfcontact_phone">* {$aLang.plugin.consultingroom.group_request.contact_phone}:</label>
                        <input id="ccgrfcontact_phone" type="text" class="required" name="grouprequest[contact_phone]"/>
                    </p>
                    <p>
                        <label for="ccgrfcontact_mail">* {$aLang.plugin.consultingroom.group_request.contact_mail}:</label>
                        <input id="ccgrfcontact_mail" type="text" class="required email" name="grouprequest[contact_mail]"/>
                    </p>
                    <p class="consultingroom-align-right">
                        <input type="submit" class="submit" name="consultingroom_communication_grouprequestform_submit" value="{$aLang.plugin.consultingroom.group_request.send_request}"/>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="clear"></div>
    <ul class="consultingroom-tabs">
        <li><a rel="nofollow" href="#tabs1">{$aLang.plugin.consultingroom.buttons.news}</a></li>
        <li><a rel="nofollow" href="#tabs2">{$aLang.plugin.consultingroom.buttons.communication}</a></li>
    </ul>
    <div class="consultingroom-data">
        <div class="consultingroom-data-content" id="tabs1">
        {if $oConfig->GetValue('plugin.consultingroom.news.show') EQ 'news'}
            {foreach from=$aConsultingroom.news item=aNews}
            <p>
                <span class="col-item-date consultingroom-news-date">{$aNews.news_date}</span>
                <div class="col-item-desc">
                {$aNews.news_text}
                </div>
            </p>
                {foreachelse}
                {$aLang.plugin.consultingroom.nodata}
            {/foreach}
        {elseif $oConfig->GetValue('plugin.consultingroom.news.show') EQ 'topics'}
            {include file='topic_list.tpl'}
        {/if}
        </div>
        <div class="consultingroom-data-content" id="tabs2">
        {foreach from=$aConsultingroom.communication item=aCommunication}
            <div class="consultingroom-data-communication-row">
            <p>
                <span class="col-item-date">{$aCommunication.communication_question_date}  {$aLang.plugin.consultingroom.question_from} <strong>{$aCommunication.communication_enquirer}</strong></span>
                <div class="col-item-desc">
                {$aCommunication.communication_question}
                </div>
            </p>
            <p>
                <span class="col-item-date">{$aCommunication.communication_answer_date} {$aLang.plugin.consultingroom.answer}</span>
                <div class="col-item-desc">
                {$aCommunication.communication_answer}
                </div>
            </p>
            </div>
            {foreachelse}
            {$aLang.plugin.consultingroom.nodata}
        {/foreach}
            <form id="consultingroomCommunicationAskForm" class="consultingroom-communication-form" method="post" action="">
                <fieldset title="{$aLang.plugin.consultingroom.elements.ask_question}" form="consultingroomCommunicationAskForm">
                    <p>
                        <label for="ccafname">* {$aLang.plugin.consultingroom.elements.your_name}:</label>
                        <input id="ccafname" type="text" class="required" name="communication[enquirer_name]" value="{if $aPrevRequest.enquirer_name}{$aPrevRequest.enquirer_name}{/if}"/>
                    </p>
                    <p>
                        <label for="ccafmail">* {$aLang.plugin.consultingroom.elements.your_mail}:</label>
                        <input id="ccafmail" type="text" class="required email" name="communication[enquirer_mail]" value="{if $aPrevRequest.enquirer_mail}{$aPrevRequest.enquirer_mail}{/if}"/>
                    </p>
                    <p>
                        <label for="ccafquestion">* {$aLang.plugin.consultingroom.elements.your_question}:</label>
                        <textarea id="ccafquestion" class="required" name="communication[enquirer_question]">{if $aPrevRequest.enquirer_question}{$aPrevRequest.enquirer_question}{/if}</textarea>
                    </p>
                    <p>
                        <input type="submit" class="submit" name="consultingroom_communication_askform_submit" value="{$aLang.plugin.consultingroom.elements.send_question}"/>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<div class="clear"></div>


{include file='footer.tpl'}