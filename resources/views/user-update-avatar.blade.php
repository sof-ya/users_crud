<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <img id="avatar" src="" alt="Image" width="300" height="300">
    <form id="user-form" action="" method="patch">
        @csrf
        <div class="form-group">
            <input type="file" class="form-control" name="file" placeholder="Изображение" required maxlength="100">
            <div class="error_file"></div>
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
                method: 'POST',
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(body => {
                document.querySelector('#avatar').src = '{{ asset('storage') }}'+'/'+body.avatar
                form.action = 'api/users/'+body.id+'/avatar'
                return body
            });
    }
    function ajaxForm() {
        
        let form = document.querySelector('#user-form');
        
        let token = form.querySelector('input[name="_token"]').value;
        const fileField = document.querySelector('input[type="file"]');
        
        const formData = new FormData();

        formData.append("file", fileField.files[0]);

        fetch(form.action, {
                headers: {
                    "X-CSRF-TOKEN": token,
                    'Authorization': `Bearer ${localStorage.getItem("authToken")}`
                },
                method: 'POST',
                body: formData
            })
            .then((data) => {
                console.log(data)
            })
            
            .then((res) => {
                setData()
                return res;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>