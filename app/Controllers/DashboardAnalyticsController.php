<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BorrowerModel;
use CodeIgniter\API\ResponseTrait;

class DashboardAnalyticsController extends BaseController
{
    use ResponseTrait;

    public function getStatistics()
    {
        $bookModel = new BookModel();
        $borrowerModel = new BorrowerModel();

        // Total Books
        $totalBooks = $bookModel->countAll();
        
        // Total Books Added This Month
        $booksThisMonth = $bookModel->where('MONTH(created_at)', date('m'))
                                   ->where('YEAR(created_at)', date('Y'))
                                   ->countAllResults();

        // Active Users (users with active borrowings)
        $activeUsers = $borrowerModel->select('name')
                                   ->distinct()
                                   ->where('return_date >=', date('Y-m-d'))
                                   ->countAllResults();

        // User Increase vs Last Week
        $lastWeekUsers = $borrowerModel->select('name')
                                     ->distinct()
                                     ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                                     ->countAllResults();

        // Currently Borrowed Books
        $borrowedBooks = $bookModel->where('status', 'borrowed')->countAllResults();

        return $this->response->setJSON([
            'total_books' => [
                'count' => $totalBooks,
                'added_this_month' => $booksThisMonth
            ],
            'active_users' => [
                'count' => $activeUsers,
                'increase' => $lastWeekUsers
            ],
            'borrowed_books' => [
                'count' => $borrowedBooks,
                'active_checkouts' => $borrowedBooks
            ]
        ]);
    }
}