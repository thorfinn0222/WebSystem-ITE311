<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('teacher/dashboard');
    }
}