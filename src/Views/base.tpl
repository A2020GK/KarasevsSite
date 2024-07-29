<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <meta name="description" content="{$title}. Сайт Карасей.">
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" >
    <script src="/js/lib.js"></script>
    <script src="/js/default.js" defer></script>
    {block "assets"}
    {/block}
</head>

<body>
    <div class="container">
        <main>
            <header>
                <h1>{$header}</h1>
                <button class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </header>
            <aside class="sidebar">
                <button class="close-sidebar">
                    <i class="fas fa-times"></i>
                </button>
                <ul>
                    <li><a href="{route name="homepage"}"><i class="fa-solid fa-house"></i> Главная страница</a></li>
                    {if $currentUser}
                        <li><a href="{route name="user.profile" id=$currentUser->id}"><i class="fa-solid fa-user"></i> {$currentUser->name}</a></li>
                    {else}
                        <li><a href="{route name="user.login"}">Войти</a></li>
                    {/if}
                </ul>
            </aside>
            <div class="content">
                {block "content"}
                    <p>&lt;No content&gt;
                {/block}
            </div>
            <footer>Copyright Antony Karasev {$smarty.now|date_format:"Y"}</footer>
        </main>
    </div>
</body>
</html>