<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BorrowerModel;

class BooksController extends BaseController
{
    public function index()
    {
        $bookModel = new BookModel();
        $data['books'] = $bookModel->findAll();
        return view('books/index', $data);
    }

    public function create()
    {
        return view('books/create'); // Hanya admin, middleware sudah menangani
    }

    public function store()
    {
        $validation = $this->validate([
            'title' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'description' => 'permit_empty|max_length[255]',
            'category' => 'required|min_length[3]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bookModel = new BookModel();
        $bookModel->save([
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'status' => 'available',
        ]);

        return redirect()->to('/books')->with('success', 'Book added successfully.');
    }

    public function edit($id)
    {
        $bookModel = new BookModel();
        $book = $bookModel->find($id);

        if (!$book) {
            return redirect()->to('/books')->with('error', 'Book not found.');
        }

        return view('books/edit', ['book' => $book]);
    }

    public function update($id)
    {
        $validation = $this->validate([
            'title' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'description' => 'permit_empty|max_length[255]',
            'category' => 'required|min_length[3]',
            'status' => 'required|in_list[available,borrowed]',
        ]);

        if (!$validation) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $bookModel = new BookModel();
        $bookModel->update($id, [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'status' => $this->request->getPost('status'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book updated successfully',
        ]);
    }

    public function delete($id)
    {
        $bookModel = new BookModel();
        $book = $bookModel->find($id);

        if (!$book) {
            return $this->response->setJSON(['error' => 'Book not found'])->setStatusCode(404);
        }

        $bookModel->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Book deleted successfully.']);
    }

    public function trackBook($id)
    {
        $bookModel = new BookModel();
        $borrowerModel = new BorrowerModel();

        $book = $bookModel->find($id);
        if (!$book) {
            return $this->response->setJSON(['error' => 'Book not found'])->setStatusCode(404);
        }

        $borrower = null;
        if ($book['status'] === 'borrowed') {
            $borrower = $borrowerModel->where('book_id', $id)->first();
        }

        return $this->response->setJSON([
            'book' => $book,
            'is_borrowed' => $book['status'] === 'borrowed',
            'borrower' => $borrower,
        ]);
    }
}
