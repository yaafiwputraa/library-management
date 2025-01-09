<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }

        .image-container {
            position: relative;
            width: 70%;
            height: 100vh;
            overflow: hidden;
        }

        .background-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1);
            transition: transform 8s ease;
        }

        .image-container:hover .background-image {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(22, 22, 22, 0.8) 0%, rgba(0,0,0,0.6) 100%);
        }

        .login-container {
            width: 30%;
            height: 100vh;
            background:rgb(214, 214, 214);
            box-shadow: -10px 0 20px rgba(0,0,0,0.1);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-group label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 0.5rem;
            background: #ffffff;
            transition: all 0.3s ease;
            pointer-events: none;
            color: #6b7280;
        }

        .input-group input:focus ~ label,
        .input-group input:valid ~ label {
            top: 0;
            font-size: 0.875rem;
            color: #2563eb;
        }

        .btn-login {
            background: linear-gradient(45deg,rgb(130, 97, 42),rgb(93, 46, 17));
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,rgb(107, 107, 107),rgb(14, 33, 74));
            transition: all 0.5s ease;
            z-index: -1;
        }

        .btn-login:hover::before {
            left: 0;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .link-hover {
            position: relative;
            transition: all 0.3s ease;
        }

        .link-hover::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 50%;
            background: linear-gradient(to right,rgb(235, 166, 37),rgb(127, 72, 21));
            transition: all 0.3s ease;
        }

        .link-hover:hover::after {
            width: 100%;
            left: 0;
        }

        .title-animation {
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
        }

        .subtitle-animation {
            opacity: 0;
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 1024px) {
            .image-container {
                width: 100%;
                height: 40vh;
            }
            .login-container {
                width: 100%;
                height: auto;
            }
            .split-layout {
                flex-direction: column;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex split-layout">
        <!-- Image Background Section (70%) -->
        <div class="image-container">
            <img src="https://images.pexels.com/photos/2898170/pexels-photo-2898170.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Background" class="background-image">
            <div class="overlay"></div>
            <!-- Text overlay with enhanced styling -->
            <div class="absolute z-10 text-white top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center w-full px-4">
                <div class="glass-card inline-block">
                    <h1 class="text-6xl font-bold mb-6 title-animation bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-blue-100">
                        Library Management API
                    </h1>
                    <p class="text-2xl subtitle-animation text-blue-100">Manage your library resources with ease</p>
                </div>
            </div>
        </div>

        <!-- Login Section (30%) -->
        <div class="login-container flex items-center justify-center p-12">
            <div class="w-full max-w-md">
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-600">Please login to your account</p>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="/authenticate" method="post" class="space-y-6">
                    <div class="input-group">
                        <input type="text" name="username" id="username" required class="focus:ring-2 focus:ring-blue-500">
                        <label for="username">Username</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" required class="focus:ring-2 focus:ring-blue-500">
                        <label for="password">Password</label>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 link-hover">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-login w-full py-4 text-white rounded-xl font-semibold text-lg">
                        Sign In
                    </button>
                </form>

                <p class="mt-8 text-center text-gray-600">
                    Don't have an account? 
                    <a href="/register" class="text-blue-600 font-medium link-hover">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>