{extends "base.tpl"}

{$title  = "Ошибка {$code}"}
{$header = $title}

{$types=[404=>"ресурс не найден"]}

{block "content"}

    <p>Упс, кажется произошла ошибка {$code}, {$types[$code] ?? "тип которой не может быть определён."}</p>
    <p><a href="{route name="homepage"}">Главная страница</a></p>

{/block}