<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class UserController extends BaseController
{
    use ResponseTrait;

    // public function register()
    // {
    //     try {
    //         $userModel = new UserModel();

    //         $username = $this->request->getPost('username');
    //         $password = $this->request->getPost('password');

    //         $existingUser = $userModel->where('username', $username)->first();
    //         if ($existingUser) {
    //             return redirect()->back()->with('error', 'Username sudah terdaftar, gunakan username lain.')->withInput();
    //         }
    //         if (!$username || !$password) {
    //             return redirect()->back()->with('error', 'Username dan Password harus diisi.')->withInput();
    //         }

    //         $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    //         $userData = [
    //             'username' => $username,
    //             'password' => $hashedPassword
    //         ];

    //         $userModel->insert($userData);

    //         return redirect()
    //             ->to('/users/login');
    //     } catch (Exception $e) {
    //         return $this->failServerError($e->getMessage());
    //     }
    // }
    public function register()
    {
        try {
            $userModel = new UserModel();

            // Aturan validasi
            $rules = [
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Username harus diisi.',
                        'min_length' => 'Username minimal harus 3 karakter.',
                        'max_length' => 'Username maksimal 100 karakter.',
                        'is_unique' => 'Username sudah digunakan, coba yang lain.'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|regex_match[/^(?=.*[0-9])(?=.*[\W]).+$/]',
                    'errors' => [
                        'required' => 'Password harus diisi.',
                        'min_length' => 'Password minimal harus 6 karakter.',
                        'regex_match' => 'Password harus mengandung minimal 1 angka dan 1 simbol.'
                    ]
                ]
            ];
            
            if (!$this->validate($rules)) {
                // Ambil semua error dari validasi
                $validationErrors = $this->validator->getErrors();
                
                // Redirect kembali dengan pesan error dan input
                return redirect()->back()->with('errors', $validationErrors)->withInput();
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $userData = [
                'username' => $username,
                'password' => $hashedPassword
            ];

            // Simpan ke database
            $userModel->insert($userData);

            // Alihkan ke form login dengan pesan sukses
            return redirect()
                ->to('/users/login')
                ->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function loginView()
    {
        return view('user/login');
    }
    public function registerView()
    {
        return view('user/register');
    }

    public function login()
    {
        try {
            $userModel = new UserModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if (!$username || !$password) {
                return redirect()->back()->with('error', 'Username dan Password harus diisi.')->withInput();
            }

            $user = $userModel->where('username', $username)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'User doesn\'t exist.')->withInput();
            }

            if (!password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Wrong password.')->withInput();
            }

            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $user['id'],
                'username'   => $user['username']
            ]);

            return redirect()
                ->to('/');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Internal server error: ' . $e->getMessage());
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('message', 'You have successfully logged out.');
    }



}
