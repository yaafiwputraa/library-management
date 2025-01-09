<?php

namespace App\Controllers;

use App\Models\BookModel;

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
        if (session()->get('user')['role'] !== 'admin') {
            return redirect()->to('/unauthorized');
        }

        return view('books/create');
    }

    public function store()
    {
        if (session()->get('user')['role'] !== 'admin') {
            return redirect()->to('/unauthorized');
        }

        $bookModel = new BookModel();
        $bookModel->save([
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/books');
    }

    public function edit($id)
{
    if (session()->get('user')['role'] !== 'admin') {
        return redirect()->to('/unauthorized');
    }

    $bookModel = new BookModel();
    $book = $bookModel->find($id);

    if (!$book) {
        return redirect()->to('/books')->with('error', 'Book not found.');
    }

    // Kirim data buku (termasuk `status` dan `category`) ke view
    return view('books/edit', ['book' => $book]);
}


public function get($id)
{
    if (session()->get('user')['role'] !== 'admin') {
        return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(403);
    }

    $bookModel = new BookModel();
    $book = $bookModel->find($id);

    if (!$book) {
        return $this->response->setJSON(['error' => 'Book not found'])->setStatusCode(404);
    }

    return $this->response->setJSON($book);
}

// Update the update method to handle AJAX requests
public function update($id)
{
    if (session()->get('user')['role'] !== 'admin') {
        return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(403);
    }

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
            'errors' => $this->validator->getErrors()
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
        'message' => 'Book updated successfully'
    ]);
}


public function delete($id)
{
    if (session()->get('user')['role'] !== 'admin') {
        return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(403);
    }

    $bookModel = new BookModel();
    $book = $bookModel->find($id);

    if (!$book) {
        return $this->response->setJSON(['error' => 'Book not found'])->setStatusCode(404);
    }

    $bookModel->delete($id);

    return $this->response->setJSON(['success' => true, 'message' => 'Book deleted successfully.']);
}



}
