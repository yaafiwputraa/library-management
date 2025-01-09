<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $allowedFields = ['title', 'author', 'description', 'status', 'category']; // Tambahkan 'status' dan 'category'
}
