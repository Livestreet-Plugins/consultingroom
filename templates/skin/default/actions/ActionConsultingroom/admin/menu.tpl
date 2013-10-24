<div class="consultingroom-menu">
    <a href="{router page='consultingroom/admin'}">{$aLang.plugin.consultingroom.admin}</a>
    &nbsp;|&nbsp;<a href="{router page='consultingroom/description'}">{$aLang.plugin.consultingroom.description}</a>
    &nbsp;|&nbsp;<a href="{router page='consultingroom/license'}">{$aLang.plugin.consultingroom.license}</a>
    {if $bShowDonateLink}
    &nbsp;|&nbsp;<a href="{router page='consultingroom/donate'}">{$aLang.plugin.consultingroom.donate}</a>
    {/if}
</div>