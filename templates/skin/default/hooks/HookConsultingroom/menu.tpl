    <li>
        <a>{$aLang.plugin.consultingroom.main_menu}</a>
        <ul class="submenu">
        {foreach from=$aConsultingrooms item=aRoom}
        <li><a href="{router page='consultingroom/specialist'}{$aRoom.user_login}">{$aRoom.name}</a></li>
        {/foreach}
        </ul>
    </li>