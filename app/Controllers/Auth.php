<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $db;
    protected $session;

   

    public function register()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            // Get form data
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role') ?? 'user';

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $builder = $this->db->table('users');
            if ($builder->insert($data)) {
                $this->session->setFlashdata('success', 'Registration successful! Please login.');
                return redirect()->to('/login');
            } else {
                $this->session->setFlashdata('error', 'Registration failed. Please try again.');
            }
        }

        return view('auth/register');
    }

    public function login()
{
    $db = \Config\Database::connect();
    $session = session();

    // If user is already logged in, redirect to dashboard
    if ($session->get('userID')) {
        return redirect()->to('/dashboard');
    }

    if ($this->request->getMethod() === 'POST') {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', ['validation' => $this->validator]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Check if user exists
        $builder = $db->table('users');
        $user = $builder->where('email', $email)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            // Set session data
            $session->set([
                'userID' => $user['id'],
                'name'   => $user['name'],
                'email'  => $user['email'],
                'role'   => $user['role'],
                'isLoggedIn' => true
            ]);

            $session->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Invalid email or password.');
        }
    }

    return view('auth/login');
}


    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!$this->session->get('userID')) {
            $this->session->setFlashdata('error', 'Please login to access the dashboard.');
            return redirect()->to('/login');
        }

        $data = [
            'user' => [
                'id' => $this->session->get('userID'),
                'name' => $this->session->get('name'),
                'email' => $this->session->get('email'),
                'role' => $this->session->get('role')
            ]
        ];

        return view('auth/dashboard', $data);
    }
}
