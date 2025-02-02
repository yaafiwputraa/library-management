<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <div class="max-w-7xl mx-auto p-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl p-8 mb-8 relative overflow-hidden shadow-sm">
            <!-- Corner decoration -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-amber-50 rounded-full transform -translate-x-16 -translate-y-16"></div>
            
            <div class="relative flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-amber-900">Borrowed Books</h1>
                    <p class="text-orange-400">Track and manage book borrowings</p>
                </div>
                
                <div class="flex gap-3">
                    <a href="/dashboard" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    <a href="/borrowers/create" class="flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-300">
                        <i class="fas fa-plus"></i>
                        New Borrowing
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
                <span><?= session()->getFlashdata('success') ?></span>
                <button onclick="this.parentElement.remove()" class="text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
                <span><?= session()->getFlashdata('error') ?></span>
                <button onclick="this.parentElement.remove()" class="text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Borrowings Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-amber-50 border-b border-amber-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Borrower Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Book Title</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Borrow Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Return Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-amber-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($borrowers)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-book-open text-4xl mb-4 text-gray-400"></i>
                                        <p class="text-lg font-medium text-gray-600">No borrowings yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Borrowings will appear here</p>
                                        <a href="/borrowers/create" class="mt-4 inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
                                            <i class="fas fa-plus mr-2"></i>
                                            Add First Borrowing
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($borrowers as $borrow): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= $borrow['id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?= esc($borrow['name']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= esc($borrow['email']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= esc($borrow['book_title']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= date('d M Y', strtotime($borrow['borrow_date'])) ?></td>
                                    <td class="px-6 py-4 text-sm">
                                        <?php 
                                            $returnDate = strtotime($borrow['return_date']);
                                            $today = time();
                                            $daysLeft = ceil(($returnDate - $today) / (60 * 60 * 24));
                                            
                                            $statusClass = $daysLeft < 0 ? 'text-red-600' : 
                                                        ($daysLeft <= 3 ? 'text-amber-600' : 'text-emerald-600');
                                        ?>
                                        <span class="<?= $statusClass ?>">
                                            <?= date('d M Y', $returnDate) ?>
                                            <?php if ($daysLeft < 0): ?>
                                                <span class="text-xs ml-2">(<?= abs($daysLeft) ?> days overdue)</span>
                                            <?php elseif ($daysLeft <= 3): ?>
                                                <span class="text-xs ml-2">(<?= $daysLeft ?> days left)</span>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form action="/borrowers/return/<?= $borrow['id'] ?>" method="post" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to return this book?')"
                                                    class="text-amber-600 hover:text-amber-900 transition-colors">
                                                <i class="fas fa-undo-alt mr-1"></i> Return
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>