{include file='header.tpl'  noSidebar=true}

<h3>{$aLang.plugin.consultingroom.title} : {$aProfile.name}</h3>

{include file=$sActionConsultingroomMenuTemplate}

<form method="post" action="{router page='consultingroom/profile'}">

<div class="consultingroom-profile">
    <div class="consultingroom-profile-avatar">
    {if $aProfile.user_profile_avatar}
        <img src="{$aProfile.user_profile_avatar}"/>
        {else}
        {$aLang.plugin.consultingroom.nodata}
    {/if}
    <br/>
    <span>{$aLang.plugin.consultingroom.users.user_profile_avatar}</span>
    </div>
    <div class="consultingroom-profile-data">
    <table>
        <tbody>
        <tr>
            <td>{$aLang.plugin.consultingroom.users.user_id}</td>
            <td><input type="text" readonly="readonly" name="profile[user_id]" value="{$aProfile.user_id}"/></td>
            <td rowspan="10">
                <div class="consultingroom-profile-foto">
                {if $aProfile.user_profile_foto}
                    <img src="{$aProfile.user_profile_foto}"/>
                    {else}
                    {$aLang.plugin.consultingroom.nodata}
                {/if}
                    <br/>
                {$aLang.plugin.consultingroom.users.user_profile_foto}
                </div>
            </td>
        </tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_login}</td><td><input type="text" readonly="readonly"  name="profile[user_login]" value="{$aProfile.user_login}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_mail}</td><td><input type="text" name="profile[user_mail]" value="{$aProfile.user_mail}"/></td></tr>
        {*<tr><td>{$aLang.plugin.consultingroom.users.name}</td><td><input type="text" readonly="readonly"  name="profile[name]" value="{$aProfile.name}"/></td></tr>*}
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_name}</td><td><input type="text" name="profile[user_profile_name]" value="{$aProfile.user_profile_name}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_avatar}</td><td><input type="text" name="profile[user_profile_avatar]" value="{$aProfile.user_profile_avatar}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_foto}</td><td><input type="text" name="profile[user_profile_foto]" value="{$aProfile.user_profile_foto}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_sex}</td><td><input type="text" name="profile[user_profile_sex]" value="{$aProfile.user_profile_sex}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_country}</td><td><input type="text" name="profile[user_profile_country]" value="{$aProfile.user_profile_country}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_region}</td><td><input type="text" name="profile[user_profile_region]" value="{$aProfile.user_profile_region}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_city}</td><td><input type="text" name="profile[user_profile_city]" value="{$aProfile.user_profile_city}"/></td></tr>
        <tr><td>{$aLang.plugin.consultingroom.users.user_profile_about}</td><td><textarea name="profile[user_profile_about]">{$aProfile.user_profile_about}</textarea></td></tr>
        </tbody>
        <tfoot><tr><td colspan="2">
        <input type="submit" name="consultingroom_profile_save" value="{$aLang.plugin.consultingroom.buttons.save}"/>
        </td> </tr></tfoot>
    </table>
    </div>
</div>
</form>
{include file='footer.tpl'}