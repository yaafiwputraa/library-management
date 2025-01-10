<?php

namespace App\Controllers;

use App\Models\BorrowerModel;
use App\Models\BookModel;
use CodeIgniter\API\ResponseTrait;

class BorrowerController extends BaseController
{
    use ResponseTrait;

    public function listBorrowers()
    {
        $borrowerModel = new BorrowerModel();
        $data['borrowers'] = $borrowerModel
            ->select('borrowers.*, books.title as book_title')
            ->join('books', 'books.id = borrowers.book_id')
            ->findAll();

        return view('borrower/list', $data);
    }

    public function create()
    {
        $bookModel = new BookModel();
        $data['availableBooks'] = $bookModel->where('status', 'available')->findAll();

        return view('borrower/create', $data);
    }

    public function store()
    {
        $borrowerModel = new BorrowerModel();
        $bookModel = new BookModel();

        // Validasi input
        $validation = $this->validate([
            'name' => 'required|min_length[3]',
            'book_id' => 'required|is_not_unique[books.id]',
            'borrow_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Pastikan buku tersedia
        $book = $bookModel->find($this->request->getPost('book_id'));
        if (!$book || $book['status'] !== 'available') {
            return redirect()->back()->with('error', 'Book is not available for borrowing.');
        }

        // Simpan data peminjam
        $borrowerModel->save([
            'name' => $this->request->getPost('name'),
            'book_id' => $this->request->getPost('book_id'),
            'borrow_date' => $this->request->getPost('borrow_date'),
            'return_date' => $this->request->getPost('return_date'),
        ]);

        // Perbarui status buku menjadi "borrowed"
        $bookModel->update($this->request->getPost('book_id'), ['status' => 'borrowed']);

        return redirect()->to('/borrowers')->with('success', 'Book borrowed successfully.');
    }

    public function returnBook($id)
    {
        $borrowerModel = new BorrowerModel();
        $bookModel = new BookModel();

        // Temukan data peminjaman
        $borrow = $borrowerModel->find($id);
        if (!$borrow) {
            return redirect()->back()->with('error', 'Borrow record not found.');
        }

        // Perbarui status buku menjadi "available"
        $bookModel->update($borrow['book_id'], ['status' => 'available']);

        // Hapus data peminjaman
        $borrowerModel->delete($id);

        return redirect()->to('/borrowers')->with('success', 'Book returned successfully.');
    }
}
