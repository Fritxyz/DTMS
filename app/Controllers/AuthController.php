<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $session = session();

        if($session->get('is_logged_in') && $session->get('role') == 'researcher'){
            return redirect()->to('/researcher-dashboard');
        }

        if($session->get('is_logged_in') && $session->get('role') == 'admin'){
            return redirect()->to('/admin-dashboard');
        }

        return view('Auth/login');
    }

    public function login()
    {
        helper(['form', 'url']);

        if($this->request->getMethod() == 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->getUserByUsername($username);

            if($user && password_verify($password, $user['password'])) {
                $session = session();

                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'is_logged_in' => true,
                ]);

                if(session()->get('role' === 'admin')) {
                    return redirect()->to('/admin-dashboard');
                }
            
                return redirect()->to('/researcher-dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid credentials');
            }
        }
    }

    public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function registerForm()
    {
        $session = session();

        if($session->get('is_logged_in') && $session->get('role') == 'researcher'){
            return redirect()->to('/researcher-dashboard');
        }

        if($session->get('is_logged_in') && $session->get('role') == 'admin'){
            return redirect()->to('/admin-dashboard');
        }


        helper('form');
        return view('Auth/register');
    }

    public function register()
    {
        helper('form');

        if($this->request->getMethod() === 'POST') {
            $validationRules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'username' => 'required|min_length[5]|max_length[50]|is_unique[users.username]',
                'password' => 'required|min_length[5]'
            ];

            if($this->validate($validationRules)) {

                $this->userModel->save([
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => $this->request->getPost('role')
                ]);

                session()->setFlashdata('success', 'Registration successful! You can now log in.');
                return redirect()->to('/');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return view('auth/register');
    }
}