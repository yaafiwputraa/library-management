<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
{
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $userModel = new UserModel();
    $user = $userModel->where('username', $username)->first();

    // Gunakan password_verify untuk mencocokkan password
    if ($user && password_verify($password, $user['password'])) {
        session()->set('user', [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
        ]);

        return redirect()->to('/dashboard');
    }

    return redirect()->to('/login')->with('error', 'Invalid Credentials');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
{
    return view('auth/register');
}

public function storeUser()
{
    $validation = $this->validate([
        'username' => 'required|is_unique[users.username]|min_length[3]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'required|matches[password]',
        'role' => 'required|in_list[user,admin]',
    ]);

    if (!$validation) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $userModel = new UserModel();
    $userModel->save([
        'username' => $this->request->getPost('username'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        'role' => $this->request->getPost('role'),
    ]);

    return redirect()->to('/login')->with('success', 'Account created successfully. Please login.');
}

}
