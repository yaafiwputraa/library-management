<form action="/borrowers" method="post">
    <?= csrf_field() ?>
    <label for="name">Borrower Name</label>
    <input type="text" name="name" id="name" required>

    <label for="book_id">Book</label>
    <select name="book_id" id="book_id" required>
        <?php foreach ($availableBooks as $book): ?>
            <option value="<?= $book['id'] ?>"><?= esc($book['title']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="borrow_date">Borrow Date</label>
    <input type="date" name="borrow_date" id="borrow_date" required>

    <label for="return_date">Return Date</label>
    <input type="date" name="return_date" id="return_date" required>

    <button type="submit">Borrow</button>
</form>
