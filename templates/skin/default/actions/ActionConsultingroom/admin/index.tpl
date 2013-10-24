{include file='header.tpl'  noSidebar=true}

<h3>{$aLang.plugin.consultingroom.title} : {$aLang.plugin.consultingroom.specialists.title}</h3>

{include file=$sActionConsultingroomMenuTemplate}

<form method="post" action="{router page='consultingroom/admin'}">
    <div class="consultingroom-admin-specialists">
        <table>
            <tbody>
            {foreach from=$aSpecialists item=aSpecialist}
            <tr>
                <td>
                    <input type="checkbox" name="specialists[{$aSpecialist.consultingroom_id}][selected]"/>
                    <input type="hidden" name="specialists[{$aSpecialist.consultingroom_id}][consultingroom_id]" value="{$aSpecialist.consultingroom_id}"/>
                </td>
                <td>
                    <p>
                        <small>{$aLang.plugin.consultingroom.specialists.published}</small> <input type="checkbox" name="specialists[{$aSpecialist.consultingroom_id}][published]" {if $aSpecialist.published}checked="checked" {/if}/>
                    </p>
                    <p>
                        <label for="specialists[{$aSpecialist.consultingroom_id}][name]">{$aLang.plugin.consultingroom.specialists.name}</label>
                        <input type="text" name="specialists[{$aSpecialist.consultingroom_id}][name]" value="{$aSpecialist.name}"/><br/>
                        <label for="specialists[{$aSpecialist.consultingroom_id}][phone]">{$aLang.plugin.consultingroom.specialists.phone}</label>
                        <input type="text" name="specialists[{$aSpecialist.consultingroom_id}][phone]" value="{$aSpecialist.phone}"/><br/>
                    </p>
                </td>
                <td>
                    <p>
                    <div class="consultingroom-align-right">
                        <ul class="topic-actions">
                            <li class="edit"><i class="icon-synio-actions-edit"></i><a href="{router page="consultingroom/profile"}{$aSpecialist.user_login}">{$aLang.plugin.consultingroom.users.edit}</a></li>
                            <li class="edit"><i class="icon-synio-actions-edit"></i><a href="{router page="consultingroom/specialist"}{$aSpecialist.user_login}">{$aLang.plugin.consultingroom.specialists.go_consultingroom}</a></li>
                        </ul>
                    </div>
                    </p>
                    <p>
                    <label for="specialists[{$aSpecialist.consultingroom_id}][user_id]">{$aLang.plugin.consultingroom.specialists.user_id}</label>
                    <select name="specialists[{$aSpecialist.consultingroom_id}][user_id]">
                        <option value="0" {if !$aSpecialist.user_id}selected="selected" {/if}>{$aLang.plugin.consultingroom.elements.please_select}</option>
                        {foreach from=$aUsers item=aUser}
                        <option value="{$aUser.user_id}" {if $aSpecialist.user_id == $aUser.user_id}selected="selected" {/if}>{$aUser.name}</option>
                        {/foreach}
                    </select>
                    </p>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <p>
                        <label for="specialists[{$aSpecialist.consultingroom_id}][description_short]">{$aLang.plugin.consultingroom.specialists.description_short}</label>
                        <textarea name="specialists[{$aSpecialist.consultingroom_id}][description_short]">{$aSpecialist.description_short}</textarea>
                    </p>
                </td>
            </tr>
            {foreachelse}
            <tr>
                <td colspan="3">
                    {$aLang.plugin.consultingroom.nodata}
                </td>
            </tr>
            {/foreach}
            {if $bSpecialistAddNew}
            <tr><td colspan="3"><h3>{$aLang.plugin.consultingroom.new_record}</h3></td> </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td>
                    <p>
                    <small>{$aLang.plugin.consultingroom.specialists.published}</small> <input type="checkbox" name="specialists[new][published]" /><br/>
                    </p>
                    <p>
                    <label for="specialists[new][name]">{$aLang.plugin.consultingroom.specialists.name}</label>
                    <input name="specialists[new][name]" value=""/><br/>
                    <label for="specialists[new][phone]">{$aLang.plugin.consultingroom.specialists.phone}</label>
                    <input type="text" name="specialists[new][phone]" value=""/><br/>
                    </p>
                </td>
                <td>
                    <label for="specialists[{$aSpecialist.consultingroom_id}][user_id]">{$aLang.plugin.consultingroom.specialists.user_id}</label>
                    <select name="specialists[new][user_id]">
                        <option value="0" selected="selected">{$aLang.plugin.consultingroom.elements.please_select}</option>
                        {foreach from=$aUsers item=aUser}
                            <option value="{$aUser.user_id}">{$aUser.name}</option>
                        {/foreach}
                    </select><br/>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            <td colspan="2">
                <p>
                    <label for="specialists[new][description_short]">{$aLang.plugin.consultingroom.specialists.description_short}</label>
                    <textarea name="specialists[new][description_short]"></textarea>
                </p>
                </td>
                </tr>
            {/if}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    <input type="submit" name="consultingroom_specialists_add" value="{$aLang.plugin.consultingroom.buttons.add}" {if $bSpecialistAddNew}disabled="disabled"{/if}/>
                    <input type="submit" name="consultingroom_specialists_delete" value="{$aLang.plugin.consultingroom.buttons.delete}"/>
                    <input type="submit" name="consultingroom_specialists_save" value="{$aLang.plugin.consultingroom.buttons.save}" />
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</form>

{include file='footer.tpl'}