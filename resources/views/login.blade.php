<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form id="user-form" action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты" required maxlength="100">
            <div class="error_email"></div>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Пароль" required maxlength="100">
            <div class="error_password"></div>
        </div>

        <div class="form-group">
            <button id="btn" type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
</body>
</html>

<script>
    document.querySelector("#user-form").addEventListener("submit", function(event) {
        event.preventDefault();
        ajaxForm();
    });
    function ajaxForm() {
        
        let form = document.querySelector('#user-form');

        let token = form.querySelector('input[name="_token"]').value;
        let email = form.querySelector('input[name="email"]').value;
        let password = form.querySelector('input[name="password"]').value;
        
        let errorEmail = form.querySelector('.error_email');
        let errorPassword = form.querySelector('.error_password');
        
        fetch("{{ route('login') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
            .then(response => response.json())
            .then(body => {
                localStorage.setItem("authToken", body.access_token)
                console.log(body.token_type)
            });
    }
</script>