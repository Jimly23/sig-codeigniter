<?php

namespace App\Controllers;

class Auth extends BaseController
{
    /** GET /login */
    public function loginPage()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('auth/login');
    }

    /** POST /login */
    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // ─── Kredensial statis (ganti dengan query DB nantinya) ───
        $validUser = 'admin';
        $validPass = 'admin123';

        if ($username === $validUser && $password === $validPass) {
            session()->set([
                'is_admin'  => true,
                'username'  => $username,
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()
                         ->with('error', 'Username atau password salah.')
                         ->withInput();
    }

    /** GET /logout */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
