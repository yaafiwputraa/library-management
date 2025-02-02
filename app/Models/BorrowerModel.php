<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowerModel extends Model
{
    protected $table            = 'borrowers';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'email', 'phone_number', 'id_book', 'borrow_date', 'return_date'];
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'name'         => 'required|min_length[3]',
        'email'        => 'required|valid_email',
        'phone_number' => 'required|min_length[10]|max_length[15]',
        'id_book'      => 'required|numeric|is_not_unique[books.id]',
        'borrow_date'  => 'required|valid_date',
        'return_date'  => 'required|valid_date'
    ];
}