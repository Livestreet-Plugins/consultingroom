{include file='header.tpl'}

<div class="consultingroom-specialists">
{foreach from=$aSpecialists item=aSpecialist}
    <div class="consultingroom-specialists-row">
        <a href="/consultingroom/specialist/{$aSpecialist.user_login}" title="{$aSpecialist.user_profile_name}">
            <img src="{$aSpecialist.user_profile_avatar}"/>
            </a>
        <a href="/consultingroom/specialist/{$aSpecialist.user_login}" title="{$aSpecialist.user_profile_name}">
            {$aSpecialist.user_profile_name}
            </a>
    </div>
{foreachelse}
    {$aLang.plugin.consultingroom.nodata}
{/foreach}
</div>

{include file='footer.tpl'}