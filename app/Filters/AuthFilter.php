<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->has('user')) {
            // Redirect ke halaman login dengan pesan error
            return redirect()->to('/login')->with('error', 'You must log in to access this page.');
        }

        // Jika role dibutuhkan, validasi role user
        if ($arguments && !in_array($session->get('user')['role'], $arguments)) {
            // Redirect ke halaman unauthorized dengan pesan error
            return redirect()->to('/unauthorized')->with('error', 'You are not authorized to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan tambahan setelah request
    }
}
