<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('include.css')
        @include('include.login-css')
    </head>
    <body class="min-h-screen flex items-center justify-center bg-[#A5D6A7] !important" style="font-family: 'Inter', sans-serif; font-size: 16px;">
        <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-2xl border-t-4 border-[#4CAF50] !important">
            <div class="text-center">
                <i class="fa fa-box text-5xl text-[#4CAF50] !important"></i>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">Salveowell Order Tracker</h3>
            </div>
            <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#4CAF50] outline-none !important" placeholder="Username" value="{{ old('username') }}" required>
                    <x-error-message field="username" />
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#4CAF50] outline-none !important" placeholder="Password" required>
                    <i class="fa fa-eye text-gray-500 absolute right-3 top-3 cursor-pointer !important" onclick="togglePassword()"></i>
                    <x-error-message field="password" />
                </div>
                <button type="submit" class="w-full py-2 mt-4 bg-[#4CAF50] hover:bg-[#388E3C] text-white font-semibold rounded-lg shadow-md transition !important">Login</button>
            </form>
        </div>
    
        <script>
            function togglePassword() {
                const passwordField = document.getElementById("password");
                const toggleIcon = document.querySelector(".fa-eye");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
                }
            }
        </script>
    </body>
</html>
