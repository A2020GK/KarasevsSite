{extends file="base.tpl"}

{$title  = "Регистрация"}
{$header = $title}

{block "assets"}
    <script src="/js/register.js" defer></script>
{/block}

{block "content"}
    <h2>Регистрация</h2>

    <div class="frame">
        <form method="post">
            <p><b><label for="username">Имя пользователя</label></b></p>
            <p><input type="text" id="username" name="username" placeholder="Имя пользователя" required></p>
            
            {if $fail}
                <p><span style="color:red">Такой пользователь уже существует</span></p>
            {/if}

            <p><b><label for="password">Пароль</label></b></p>
            <p><input type="password" id="password" name="password" placeholder="Пароль" required></p>
            
            <p><b><label for="password_repeat">Повторите пароль</label></b></p>
            <p><input type="password" id="password_repeat" placeholder="Повторите пароль" required></p>
            
            <p id="password-err" style="display: none;"><span style="color: red;">Пароли не совпадают</span></p>

            <p><b><label for="name">Имя</label></b></p>
            <p><input type="text" id="name" name="name" placeholder="Имя" required></p>

            <p><label for="birthday">Дата рождения</label></p>
            <p><input type="date" id="birthday" name="birthday" value="{$smarty.now|date_format:"Y-m-d"}" placeholder="Дата рождения" required></p>


            <p><input type="submit" id="submit" value="Зарегистрироваться"></p>
            <p>Есть аккаунт? <a href="{route name="user.login"}">Войти</a></p>
        </form>
    </div>
{/block}