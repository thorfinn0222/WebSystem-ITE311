<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please Login to access the admin dashboard.');
            return redirect()->to(base_url('/login'));
        }
        
        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'You do not have permission to access');
            return redirect()->to(base_url('/login'));
        }
        
        return view('auth/dashboard', [
            'user' => [
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role'),
            ]
        ]);
    }
}