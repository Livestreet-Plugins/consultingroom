{include file='header.tpl'}
<div class="title">{$aConsultingroom.name} : {$aLang.plugin.consultingroom.buttons.edit.news}</div>
<p><a href="{router page="consultingroom/specialist"}{$aConsultingroom.user.user_login}"><small>&larr;&nbsp;{$aLang.plugin.consultingroom.goback}</small></a></p>
<form method="post" action="">
    <table class="consultingroom-edit">
{foreach from=$aConsultingroom.news item=aNews}
    <tr>
        <td>
        <input type="hidden" name="news[{$aNews.news_id}][news_id]" value="{$aNews.news_id}" />
        <input type="hidden" name="news[{$aNews.news_id}][consultingroom_id]" value="{$aNews.consultingroom_id}" />
        <input type="checkbox" name="news[{$aNews.news_id}][selected]" />
        </td>
        <td>
            <label for="news[{$aNews.news_id}][news_date_str]">{$aLang.plugin.consultingroom.news.news_date}</label>
            <input type="text" name="news[{$aNews.news_id}][news_date_str]" value="{$aNews.news_date_str}" />
            <label for="news[{$aNews.news_id}][news_published]">{$aLang.plugin.consultingroom.news.news_published}</label>
            <input type="checkbox" name="news[{$aNews.news_id}][news_published]" {if $aNews.news_published}checked="checked" {/if}/>
            <p>
                <small>{$aLang.plugin.consultingroom.news.news_date_created} - {$aNews.news_date_created_str}</small><br/>
                <small>{$aLang.plugin.consultingroom.news.news_date_edited} - {$aNews.news_date_edited_str}</small>
            </p>
        </td>
        <td>
        <label for="news[{$aNews.news_id}][news_text]">{$aLang.plugin.consultingroom.news.news_text}</label>
        <textarea class="consultingroom-edit" name="news[{$aNews.news_id}][news_text]">{$aNews.news_text}</textarea>
        </td>
    </tr>
{/foreach}
    {if $bConsultingroomAddNew}
        <tr>
            <td>
                &nbsp;
                <input type="hidden" name="news[new][consultingroom_id]" value="{$aConsultingroom.consultingroom_id}" />
            </td>
            <td>
                <label for="news[new][news_date_str]">{$aLang.plugin.consultingroom.news.news_date}</label>
                <input type="datetime" name="news[new][news_date_str]" value="{$aConsultingroom.now}" />
                <label for="news[new][news_published]">{$aLang.plugin.consultingroom.news.news_published}</label>
                <input type="checkbox" name="news[new][news_published]"/>
            </td>
            <td>
                <label for="news[new][news_text]">{$aLang.plugin.consultingroom.news.news_text}</label>
                <textarea class="consultingroom-edit" name="news[new][news_text]"></textarea>
            </td>
        </tr>
    {/if}
    </table>
    <input type="submit" name="consultingroom_edit_news_save" value="{$aLang.plugin.consultingroom.buttons.save}"/>
    <input type="submit" name="consultingroom_edit_news_delete" value="{$aLang.plugin.consultingroom.buttons.delete}"/>
    <input type="submit" name="consultingroom_edit_news_add" value="{$aLang.plugin.consultingroom.buttons.add}" {if $bConsultingroomAddNew}disabled="disabled"{/if}/>
</form>
<div class="clear"></div>

{include file='footer.tpl'}