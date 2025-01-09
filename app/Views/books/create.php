<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Add Book</h1>
                <a href="/books" class="flex items-center text-gray-600 hover:text-indigo-600 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Books
                </a>
            </div>

            <form action="/books/store" method="post" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        required 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 p-3"
                        placeholder="Enter book title"
                    >
                </div>
                
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                    <input 
                        type="text" 
                        name="author" 
                        required 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 p-3"
                        placeholder="Enter author name"
                    >
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea 
                        name="description" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 p-3 h-32"
                        placeholder="Enter book description"
                    ></textarea>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Save Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>