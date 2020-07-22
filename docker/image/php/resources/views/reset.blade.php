<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reset Password</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .form-group {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            button[type="submit"] {
                color: #fff;
                font-size: 20px;
                background: #1a91d6;
                border: 0;
                border-radius: 4px;
                padding: 15px;
                cursor: pointer;
            }
            .error {
                display: none;
                color: #ff0d0d;
                margin-bottom: 20px;
            }
            .error.show {
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Сброс пароля
                </div>

                <form method="POST" id="reset-password-form" action="/api/password/reset" onsubmit="checkPassword(event);">
                    <div class="form-group">
                        <label for="password">Введите новый пароль</label>
                        <input id="password" name="password" type="password" onkeydown="removeError()" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Подтвердите новый пароль</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" onkeydown="removeError()" required>
                    </div>
                    <div id="password-error" class="error">
                        Пароли не совпадают
                    </div>
                    <div id="password-error-min" class="error">
                        Пароль должен быть не меньше 6 символов
                    </div>
                    <input type="text" name="email" value={{$email}} hidden>
                    <input type="text" name="token" value={{$token}} hidden>
                    <button type="submit">Изменить пароль</button>
                </form>
            </div>
        </div>
        <script>
            function checkPassword(event) {
              if(document.getElementById('password').value.length < 6) {
                event.preventDefault();
                document.getElementById('password-error-min').className = 'error show';
              } else if(document.getElementById('password').value !== document.getElementById('password_confirmation').value) {
                event.preventDefault();
                document.getElementById('password-error').className = 'error show';
              }
            }
            function removeError() {
              document.getElementById('password-error').className = 'error';
              document.getElementById('password-error-min').className = 'error';
            }
        </script>
    </body>
</html>
