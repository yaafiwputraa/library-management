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
            ->join('books', 'books.id = borrowers.id_book')
            ->findAll();

        return view('borrower/list', $data);
    }

    public function create()
    {
        $bookModel = new BookModel();
        $data['availableBooks'] = $bookModel->where('status', 'available')->findAll();

        // Pre-select book if book_id is provided in URL
        if ($bookId = $this->request->getGet('book_id')) {
            $data['selectedBook'] = $bookModel->find($bookId);
        }

        return view('borrower/create', $data);
    }

    public function store()
    {
        $validation = $this->validate([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone_number' => 'required|min_length[10]|max_length[15]',
            'id_book' => 'required|is_not_unique[books.id]',
            'borrow_date' => 'required|valid_date',
            'return_date' => 'required|valid_date'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            $borrowerModel = new BorrowerModel();
            $bookModel = new BookModel();

            // Verify book availability
            $book = $bookModel->find($this->request->getPost('id_book'));
            if (!$book || $book['status'] !== 'available') {
                return redirect()->back()->withInput()->with('error', 'Book is not available for borrowing.');
            }

            // Save borrower data
            $borrowerModel->insert([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone_number' => $this->request->getPost('phone_number'),
                'id_book' => $this->request->getPost('id_book'),
                'borrow_date' => $this->request->getPost('borrow_date'),
                'return_date' => $this->request->getPost('return_date')
            ]);

            // Update book status
            $bookModel->update($this->request->getPost('id_book'), [
                'status' => 'borrowed'
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Failed to process borrowing.');
            }

            $db->transCommit();
            return redirect()->to('/borrowers')->with('success', 'Book borrowed successfully.');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', '[BorrowerController::store] Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function returnBook($id)
    {
        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            $borrowerModel = new BorrowerModel();
            $bookModel = new BookModel();

            $borrow = $borrowerModel->find($id);
            if (!$borrow) {
                return redirect()->back()->with('error', 'Borrow record not found.');
            }

            // Update book status to available
            $bookModel->update($borrow['id_book'], ['status' => 'available']);

            // Delete borrow record
            $borrowerModel->delete($id);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Failed to process return.');
            }

            $db->transCommit();
            return redirect()->to('/borrowers')->with('success', 'Book returned successfully.');

        } catch (\Exception $e) {
            if (isset($db)) $db->transRollback();
            log_message('error', '[BorrowerController::returnBook] Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }
}