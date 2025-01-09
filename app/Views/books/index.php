<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <div class="max-w-7xl mx-auto p-8">
        <!-- Header Section with white card and corner decoration -->
        <div class="bg-white rounded-2xl p-8 mb-8 relative overflow-hidden shadow-sm">
            <!-- Corner decoration -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-amber-50 rounded-full transform -translate-x-16 -translate-y-16"></div>
            
            <div class="relative flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-amber-900">Library Collection</h1>
                    <p class="text-orange-400">Browse and manage your library resources</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="/dashboard" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    
                    <?php if (session()->get('user')['role'] === 'admin'): ?>
                        <a href="/books/create" class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-300">
                            <i class="fas fa-plus"></i>
                            Add Book
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="flex gap-4 mb-8">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search books..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg bg-white">
            </div>
            <select class="px-4 py-2 border border-gray-200 rounded-lg bg-white">
                <option>All Categories</option>
            </select>
            <select class="px-4 py-2 border border-gray-200 rounded-lg bg-white">
                <option>All Status</option>
            </select>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($books as $book): ?>
        <div class="group bg-white rounded-lg p-6 relative overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Corner decoration with hover effect -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-full transform translate-x-8 -translate-y-8 group-hover:scale-150 transition-transform duration-300"></div>
            
            <?php if (session()->get('user')['role'] === 'admin'): ?>
                <div class="absolute top-4 right-4 dropdown z-20">
                    <button class="p-2 hover:bg-amber-50 rounded-lg transition-colors duration-300" onclick="toggleDropdown(<?= $book['id'] ?>)">
                        <i class="fas fa-ellipsis-vertical text-gray-600"></i>
                    </button>
                    <div id="dropdown-<?= $book['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200">
                        <a href="/books/edit/<?= $book['id'] ?>" class="block px-4 py-2 text-gray-700 hover:bg-amber-50 transition-colors duration-300">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <button onclick="deleteBook(<?= $book['id'] ?>)" 
                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="relative flex gap-4 z-10">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-amber-800"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-amber-900"><?= $book['title'] ?></h3>
                    <p class="text-orange-500 mt-1"><?= $book['author'] ?></p>
                    <div class="mt-4 space-y-2">
                        <div class="text-sm text-gray-500">Category: <?= $book['category'] ?? 'N/A' ?></div>
                        <span class="inline-block px-3 py-1 rounded-full text-sm <?= ($book['status'] ?? 'available') === 'available' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
                            <?= ucfirst($book['status'] ?? 'available') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <?php if (empty($books)): ?>
            <div class="text-center py-16 bg-white rounded-lg">
                <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700">No books available</h3>
                <p class="text-gray-500 mt-2">Books you add will appear here</p>
                <?php if (session()->get('user')['role'] === 'admin'): ?>
                    <a href="/books/create" class="inline-flex items-center px-4 py-2 mt-6 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                        <i class="fas fa-plus mr-2"></i>
                        Add Your First Book
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-2xl font-bold text-amber-900">Edit Book</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 p-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editBookForm" class="mt-6 space-y-6">
                <input type="hidden" id="bookId" name="bookId">
                <?= csrf_field() ?>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" id="editTitle" name="title" required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" id="editAuthor" name="author" required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="editDescription" name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <input type="text" id="editCategory" name="category" required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="editStatus" name="status"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-300">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
    <script>
    function openEditModal(bookId) {
    // Close any open dropdowns first
    document.querySelectorAll('.dropdown div').forEach(el => el.classList.add('hidden'));
    
    // Get the book data
    fetch(`/books/get/${bookId}`)
        .then(response => response.json())
        .then(book => {
            document.getElementById('bookId').value = book.id;
            document.getElementById('editTitle').value = book.title;
            document.getElementById('editAuthor').value = book.author;
            document.getElementById('editDescription').value = book.description || '';
            document.getElementById('editCategory').value = book.category || '';
            document.getElementById('editStatus').value = book.status || 'available';
            
            // Show the modal
            document.getElementById('editModal').classList.remove('hidden');
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Handle form submission
document.getElementById('editBookForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const bookId = document.getElementById('bookId').value;
    const formData = new FormData(this);
    
    fetch(`/books/update/${bookId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the page or update the book display
            window.location.reload();
        } else {
            alert('Error updating book: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error updating book');
        console.error('Error:', error);
    });
});

// Update the existing toggleDropdown function to include the edit option
function toggleDropdown(bookId) {
    const dropdown = document.getElementById(`dropdown-${bookId}`);
    dropdown.innerHTML = `
        <button onclick="openEditModal(${bookId})" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-amber-50 transition-colors duration-300">
            <i class="fas fa-edit mr-2"></i> Edit
        </button>
        <button onclick="deleteBook(${bookId})" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300">
            <i class="fas fa-trash mr-2"></i> Delete
        </button>
    `;
    dropdown.classList.toggle('hidden');
}


// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                dropdown.querySelector('div').classList.add('hidden');
            }
        });
    });

    function deleteBook(bookId) {
    // Konfirmasi sebelum menghapus
    if (!confirm('Are you sure you want to delete this book?')) {
        return;
    }

    fetch(`/books/${bookId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest', // Untuk memastikan AJAX request
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book deleted successfully');
            window.location.reload(); // Refresh halaman setelah berhasil
        } else {
            alert('Error deleting book: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error deleting book');
        console.error('Error:', error);
    });
}

    </script>
</body>
</html>