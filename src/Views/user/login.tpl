{extends file="base.tpl"}
{assign var="title" value="Вход"}

{block "content"}
    <h2>Вход в аккаунт</h2>
    
    <div class="frame">
        <form method="post">
            <p><b><label for="username">Имя пользователя</label></b></p>
            <p><input type="text" required name="username" id="username" placeholder="Имя пользователя"></p>
            <p><b><label for="password">Пароль</label></b></p>
            <p><input type="password" required name="password" id="password" placeholder="Пароль"></p>

            {if $fail}
                <p><b><span style="color:red">Неверное имя пользователя или пароль</span></b></p>
            {/if}

            <p><input type="submit" value="Войти"></p>
            <p>Нет аккаунта? <a href="{route name="user.register"}">Зарегистрироваться</a></p>
        </form>
    </div>

{/block}