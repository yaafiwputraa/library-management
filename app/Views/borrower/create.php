<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow a Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <div class="max-w-3xl mx-auto p-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl p-8 mb-8 relative overflow-hidden shadow-sm">
            <!-- Corner decoration -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-amber-50 rounded-full transform -translate-x-16 -translate-y-16"></div>
            
            <div class="relative flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-amber-900">Borrow a Book</h1>
                    <p class="text-orange-400">Fill in the borrowing details</p>
                </div>
                
                <div>
                    <a href="/books" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                        <i class="fas fa-arrow-left"></i>
                        Back to Books
                    </a>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        <?php if (session()->has('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Borrow Form -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <form action="/borrowers" method="post" class="p-8">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-amber-900">Personal Information</h3>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" required
                                value="<?= old('name') ?>"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Enter your full name">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" required
                                value="<?= old('email') ?>"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="your@email.com">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" required
                                value="<?= old('phone_number') ?>"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Enter your phone number">
                        </div>
                    </div>

                    <!-- Borrowing Details -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-amber-900">Borrowing Details</h3>

                        <div>
                            <label for="id_book" class="block text-sm font-medium text-gray-700 mb-1">Select Book</label>
                            <select id="id_book" name="id_book" required
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                <option value="">Choose a book</option>
                                <?php foreach ($availableBooks as $book): ?>
                                    <option value="<?= $book['id'] ?>" 
                                        <?= (old('id_book') == $book['id'] || (isset($_GET['book_id']) && $_GET['book_id'] == $book['id'])) ? 'selected' : '' ?>>
                                        <?= esc($book['title']) ?> by <?= esc($book['author']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Borrow Date</label>
                            <input type="date" id="borrow_date" name="borrow_date" required
                                value="<?= old('borrow_date') ?? date('Y-m-d') ?>"
                                min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
                            <input type="date" id="return_date" name="return_date" required
                                value="<?= old('return_date') ?? date('Y-m-d', strtotime('+14 days')) ?>"
                                min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                    <a href="/books" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-300">
                        <i class="fas fa-book-reader mr-2"></i>
                        Borrow Book
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Validate return date is after borrow date
    document.getElementById('return_date').addEventListener('change', function() {
        const borrowDate = new Date(document.getElementById('borrow_date').value);
        const returnDate = new Date(this.value);
        
        if (returnDate <= borrowDate) {
            alert('Return date must be after borrow date');
            this.value = document.getElementById('borrow_date').value;
        }
    });

    // Update return date when borrow date changes
    document.getElementById('borrow_date').addEventListener('change', function() {
        const borrowDate = new Date(this.value);
        const returnDateInput = document.getElementById('return_date');
        
        // Set minimum return date to next day after borrow date
        const minReturnDate = new Date(borrowDate);
        minReturnDate.setDate(minReturnDate.getDate() + 1);
        returnDateInput.min = minReturnDate.toISOString().split('T')[0];
        
        // Set default return date to 14 days after borrow date
        const defaultReturnDate = new Date(borrowDate);
        defaultReturnDate.setDate(defaultReturnDate.getDate() + 14);
        returnDateInput.value = defaultReturnDate.toISOString().split('T')[0];
    });
    </script>
</body>
</html>