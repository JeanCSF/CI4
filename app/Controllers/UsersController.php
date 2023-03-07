<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\Controller;


class UsersController extends BaseController
{
    public function signUp()
    {
        echo view('users/signup');
    }

    public function signUpSubmit()
    {
        $users = new Users();
        $post = $this->request->getPost();
        $users->signUpCreateAccount($post);
    }

    public function login()
    {
        $users = new Users();
        
        $post = $this->request->getPost();
        if (!empty($post)) {
            if ($users->checkLogin($post)) {
                $row = $users->getUser($post['txtUser']);
                $data = [
                    'USER_ID'       => $row->USER_ID,
                    'USER'          => $row->USER,
                    'EMAIL'         => $row->EMAIL,
                    'NAME'          => $row->NAME,
                    'SU'            => $row->SU
                ];
                $this->session->set($data);
                $mensagem['mensagem'] = 'Bem vindo !';
                $this->session->setFlashdata('mensagem', $mensagem);
                return redirect()->to(base_url('/'));
            } else {
                $mensagem['mensagem'] = 'Usuário ou senha inválido';
                $mensagem['tipo'] = 'alert-danger';
                $this->session->setFlashdata('mensagem', $mensagem);
                return redirect()->to(base_url('/users/login'));
            }
        }
        echo view('users/login');
    }
}
