<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center h-screen">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" required autofocus>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Stop the default form submission

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const token = document.querySelector('input[name="_token"]').value;

                console.log('--- Admin Login Attempt ---');
                console.log('Email:', email);
                console.log('Password:', password);
                console.log('CSRF Token:', token);

                fetch('{{ route('admin.login') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                })
                .then(response => {
                    console.log('--- Server Response ---');
                    console.log('Status:', response.status);
                    console.log('Status Text:', response.statusText);
                    response.json().then(data => {
                        console.log('Response Body:', data);
                        if (response.ok && data.redirect) {
                            console.log('Redirecting to:', data.redirect);
                            window.location.href = data.redirect;
                        } else {
                            console.error('Login failed. Server response:', data);
                        }
                    }).catch(err => {
                        console.error('Error parsing JSON response:', err);
                        response.text().then(text => console.log('Non-JSON Response Body:', text));
                    });
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                });
            });
        });
    </script>
</body>
</html>