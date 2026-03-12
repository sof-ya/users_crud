<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form id="user-form" action="" method="patch">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Имя, фамилия" maxlength="100">
            <div class="error_name"></div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты" maxlength="100">
            <div class="error_email"></div>
        </div>
        <div class="form-group">
            <input type="phone" class="form-control" name="phone" placeholder="Номер телефона" maxlength="100">
            <div class="error_phone"></div>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Пароль" maxlength="100">
            <div class="error_password"></div>
        </div>

        <div class="form-group">
            <button id="btn" type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
</body>
</html>

<script>
    setData()
    document.querySelector("#user-form").addEventListener("submit", function(event) {
        event.preventDefault();
        ajaxForm();
    });

    function setData() {
        let form = document.querySelector('#user-form');
        return fetch("{{ route('me') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Authorization': `Bearer ${localStorage.getItem("authToken")}`
                },
                method: 'post',
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(body => {
                form.querySelector('input[name="name"]').value = body.name
                form.querySelector('input[name="email"]').value = body.email
                form.querySelector('input[name="phone"]').value = body.phone
                form.action = 'api/users/'+body.id
                return body
            });
    }
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

        let data = {}
        if (name.length > 0) {
            data.name = name
        }        
        if (email.length > 0) {
            data.email = email
        }
        if (phone.length > 0) {
            data.phone = phone
        }
        if (password.length > 0) {
            data.password = password
        }
        
        console.log(data)
        fetch(form.action, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token,
                    'Authorization': `Bearer ${localStorage.getItem("authToken")}`
                },
                method: 'PATCH',
                credentials: "same-origin",
                body: JSON.stringify({
                    ...data
                })
            })
            .then((data) => {
                console.log(data)
            })
            
            .then((res) => {
                return res.json();
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>