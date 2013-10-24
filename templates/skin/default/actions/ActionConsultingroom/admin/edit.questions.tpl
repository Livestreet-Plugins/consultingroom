{include file='header.tpl'}
<div class="title">{$aConsultingroom.name} : {$aLang.plugin.consultingroom.buttons.edit.questions}</div>
<p><a href="{router page="consultingroom/specialist"}{$aConsultingroom.user.user_login}"><small>&larr;&nbsp;{$aLang.plugin.consultingroom.goback}</small></a></p>
<form method="post" action="">
    <table class="consultingroom-edit">
    {foreach from=$aConsultingroom.communication item=aComm}
        <tr>
            <td>
                <input type="hidden" name="communication[{$aComm.communication_id}][communication_id]" value="{$aComm.communication_id}" />
                <input type="hidden" name="communication[{$aComm.communication_id}][consultingroom_id]" value="{$aComm.consultingroom_id}" />
                <input type="checkbox" name="communication[{$aComm.communication_id}][selected]" />
            </td>
            <td>
                <small>{$aLang.plugin.consultingroom.communication.communication_question_date} - {$aComm.communication_question_date_str}</small><br/>
                <small>{$aLang.plugin.consultingroom.communication.communication_enquirer} - {$aComm.communication_enquirer}</small><br/>
                <small>{$aLang.plugin.consultingroom.communication.communication_enquirer_mail} - {$aComm.communication_enquirer_mail}</small><br/>
                <label for="communication[{$aComm.communication_id}][communication_question]"><small>{$aLang.plugin.consultingroom.communication.communication_question}</small></label>
                <textarea class="consultingroom-communication-edit" name="communication[{$aComm.communication_id}][communication_question]">{$aComm.communication_question}</textarea>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <small>{$aLang.plugin.consultingroom.communication.communication_answer_date} - {$aComm.communication_answer_date_str}</small><br/>
                <label class="consultingroom-float-left" for="communication[{$aComm.communication_id}][communication_answer]"><small>{$aLang.plugin.consultingroom.communication.communication_answer}</small></label>
                <div class="consultingroom-communication-published" >
                    <label class="consultingroom-float-left" for="communication[{$aComm.communication_id}][communication_published]"><small>{$aLang.plugin.consultingroom.communication.communication_published}</small></small></label>
                    <input type="checkbox" name="communication[{$aComm.communication_id}][communication_published]" {if $aComm.communication_published}checked="checked" {/if}/>
                </div>
                <div class="clear"></div>
                <textarea class="consultingroom-communication-edit" name="communication[{$aComm.communication_id}][communication_answer]">{$aComm.communication_answer}</textarea>
            </td>
        </tr>
    {/foreach}
    </table>
    <input type="submit" name="consultingroom_edit_communication_save" value="{$aLang.plugin.consultingroom.buttons.save}"/>
    <input type="submit" name="consultingroom_edit_communication_delete" value="{$aLang.plugin.consultingroom.buttons.delete}"/>
</form>
<div class="clear"></div>

{include file='footer.tpl'}