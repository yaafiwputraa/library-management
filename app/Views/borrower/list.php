<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Borrower Name</th>
            <th>Book Title</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($borrowers as $borrow): ?>
            <tr>
                <td><?= $borrow['id'] ?></td>
                <td><?= esc($borrow['name']) ?></td>
                <td><?= esc($borrow['book_title']) ?></td>
                <td><?= esc($borrow['borrow_date']) ?></td>
                <td><?= esc($borrow['return_date']) ?></td>
                <td>
                    <form action="/borrowers/return/<?= $borrow['id'] ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" onclick="return confirm('Return this book?')">Return</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
