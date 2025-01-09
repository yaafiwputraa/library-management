<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <!-- Navbar with glassmorphism effect -->
    <nav class="bg-white bg-opacity-10 backdrop-blur-md shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <span class="text-2xl font-bold bg-gradient-to-r from-amber-700 to-amber-900 text-transparent bg-clip-text">📚 Library</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="px-4 py-2 rounded-full bg-gradient-to-r from-amber-50 to-orange-50 text-amber-900 text-sm font-medium border border-amber-200">
                            Role: <?= esc($role) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Library Image -->
    <div class="relative overflow-hidden mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative pt-8 pb-16">
                <div class="absolute inset-0">
                    <img src="https://images.pexels.com/photos/2041540/pexels-photo-2041540.jpeg" alt="Library Interior" class="w-full h-full object-cover rounded-3xl opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-900/90 to-amber-800/70 mix-blend-multiply rounded-3xl"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <h1 class="text-4xl font-bold text-white mb-4">Welcome Back! 👋</h1>
                    <p class="text-amber-100 text-lg mb-8 max-w-xl">Discover the magic of books in our cozy digital library space</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 border border-amber-100/20">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-amber-500">Total Books</h3>
                                <div class="p-2 bg-amber-50 rounded-lg">
                                    <i class="fas fa-book text-amber-700"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-amber-500">247</p>
                            <p class="text-sm text-amber-700 mt-2">+12 this month</p>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 border border-amber-100/20">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-amber-500">Active Users</h3>
                                <div class="p-2 bg-amber-50 rounded-lg">
                                    <i class="fas fa-users text-amber-700"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-amber-500">1,234</p>
                            <p class="text-sm text-amber-700 mt-2">+8% vs last week</p>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 border border-amber-100/20">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-amber-500">Borrowed Books</h3>
                                <div class="p-2 bg-amber-50 rounded-lg">
                                    <i class="fas fa-hand-holding-heart text-amber-700"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-amber-500">89</p>
                            <p class="text-sm text-amber-700 mt-2">Active checkouts</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <h2 class="text-xl font-semibold text-amber-900 mb-6">Quick Actions</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <a href="/books" class="group">
                <div class="p-6 rounded-xl bg-white border border-amber-200 hover:border-amber-400 hover:shadow-md transition duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full transform translate-x-8 -translate-y-8 group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="relative flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-amber-700 to-amber-900 rounded-lg text-white">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="text-lg font-semibold text-amber-900 group-hover:text-amber-700">View Books</span>
                    </div>
                </div>
            </a>

            <?php if ($role === 'admin'): ?>
            <a href="/books/create" class="group">
                <div class="p-6 rounded-xl bg-white border border-amber-200 hover:border-amber-400 hover:shadow-md transition duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full transform translate-x-8 -translate-y-8 group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="relative flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-amber-700 to-amber-900 rounded-lg text-white">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="text-lg font-semibold text-amber-900 group-hover:text-amber-700">Add New Book</span>
                    </div>
                </div>
            </a>
            <?php endif; ?>

            <a href="/logout" class="group">
                <div class="p-6 rounded-xl bg-white border border-red-200 hover:border-red-400 hover:shadow-md transition duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-red-50 to-orange-50 rounded-full transform translate-x-8 -translate-y-8 group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="relative flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-red-600 to-red-700 rounded-lg text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <span class="text-lg font-semibold text-red-700 group-hover:text-red-600">Logout</span>
                    </div>
                </div>
            </a>
        </div>
    </main>
</body>
</html>