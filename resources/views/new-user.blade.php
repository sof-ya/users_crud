<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form id="user-form" action="{{ route('users.store') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Имя, фамилия" required maxlength="100">
            <div class="error_name"></div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты" required maxlength="100">
            <div class="error_email"></div>
        </div>
        <div class="form-group">
            <input type="phone" class="form-control" name="phone" placeholder="Номер телефона" required maxlength="100">
            <div class="error_phone"></div>
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
        let name = form.querySelector('input[name="name"]').value;
        let email = form.querySelector('input[name="email"]').value;
        let phone = form.querySelector('input[name="phone"]').value;
        let password = form.querySelector('input[name="password"]').value;
        
        let errorName = form.querySelector('.error_name');
        let errorEmail = form.querySelector('.error_email');
        let errorPhone = form.querySelector('.error_phone');
        let errorPassword = form.querySelector('.error_password');
        
        fetch("{{ route('users.store') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    password: password
                })
            })
            .then((data) => {
                console.log(data)
                data.errors.name ? errorName.innerHTML = data.errors.name[0] : errorName.innerHTML = "";
                data.errors.email ? errorEmail.innerHTML = data.errors.email[0] : errorEmail.innerHTML = "";
                data.errors.phone ? errorPhone.innerHTML = data.errors.phone[0] : errorPhone.innerHTML = "";
                data.errors.password ? errorPassword.innerHTML = data.errors.password[0] : errorPassword.innerHTML = "";
            })
            
            .then((res) => {
                return res.json();
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>