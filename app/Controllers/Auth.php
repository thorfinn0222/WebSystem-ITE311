<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    public function register()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'middle_initial' => 'permit_empty|max_length[5]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            // Get form data
            $firstName = $this->request->getPost('first_name');
            $middleInitial = $this->request->getPost('middle_initial');
            $lastName = $this->request->getPost('last_name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role') ?? 'student';

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $data = [
                'first_name' => $firstName,
                'middle_initial' => $middleInitial,
                'last_name' => $lastName,
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
        // If user is already logged in, redirect to dashboard
        if ($this->session->get('userID')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
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
            $builder = $this->db->table('users');
            $user = $builder->where('email', $email)->get()->getRowArray();

            if ($user && password_verify($password, $user['password'])) {
                // Create full name with middle initial
                $fullName = $user['first_name'];
                if (!empty($user['middle_initial'])) {
                    $fullName .= ' ' . $user['middle_initial'];
                }
                $fullName .= ' ' . $user['last_name'];

                // Set session data
                $sessionData = [
                    'userID' => $user['id'],
                    'first_name' => $user['first_name'],
                    'middle_initial' => $user['middle_initial'],
                    'last_name' => $user['last_name'],
                    'full_name' => $fullName,
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                $this->session->set($sessionData);

                $this->session->setFlashdata('success', 'Welcome back, ' . $user['first_name'] . '!');
                return redirect()->to('/dashboard');
            } else {
                $this->session->setFlashdata('error', 'Invalid email or password.');
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
                'first_name' => $this->session->get('first_name'),
                'middle_initial' => $this->session->get('middle_initial'),
                'last_name' => $this->session->get('last_name'),
                'full_name' => $this->session->get('full_name'),
                'email' => $this->session->get('email'),
                'role' => $this->session->get('role')
            ]
        ];

        return view('auth/dashboard', $data);
    }
}
