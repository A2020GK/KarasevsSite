{extends file="base.tpl"}

{$title = "Пользователь {$user->username}"}
{$header = "<i class=\"fa-solid fa-user\"></i> {$title}"}

{block "content"}
    <table width="33%" border="1">
        <tr><th colspan="2">{$user->username}</th></tr>
        <tr><th>Имя</th><td>{$user->name}</td></tr>
        <tr><th>Дата рождения</th><td>{$user->birthday|date_format:"d.m.Y"}</td></tr>
    </table>
    {if $currentUser->hasRole("admin") or $currentUser eq $user}
        <p>sss</p>
    {/if}
    {if $currentUser eq $user}
        <p><a href="{route name="user.unlogin"}">Выйти</a></p>
    {/if}
{/block}