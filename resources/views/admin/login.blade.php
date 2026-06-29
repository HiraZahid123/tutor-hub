<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TutorHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-Outfit">
    <section class="min-h-screen bg-white flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-10 border border-gray-200">
            <h2 class="text-3xl font-bold text-center mb-6 text-blue-700">Admin Login</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Login
                </button>
            </form>
        </div>
    </section>
</body>
</html>
