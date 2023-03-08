<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\Controller;


class Userscontroller extends BaseController
{

    public function signUp()
    {
        $users = new Users();
        $post = $this->request->getPost();
        if (!empty($post)) {
            if ($this->checkPass($post)) {
                $data['userData']  = $post;
                $mensagem['mensagem'] = 'Senhas digitadas não conferem!';
                $mensagem['tipo'] = 'alert-danger';
                $this->session->setFlashdata('mensagem', $mensagem);
                return view('users/signup', $data);
            }
            if ($users->signUpCheckUser($post)) {
                $data['userData']  = $post;
                $mensagem['mensagem'] = 'Usuário já cadastrado!';
                $mensagem['tipo'] = 'alert-danger';
                $this->session->setFlashdata('mensagem', $mensagem);
                return view('users/signup', $data);
            } else if ($users->signUpCreateAccount($post)) {
                $mensagem['mensagem'] = 'Faça login para continuar!';
                $mensagem['tipo'] = 'alert-success';
                $this->session->setFlashdata('mensagem', $mensagem);
                return redirect()->to(base_url('/'));
            }
        }
        echo view('users/signup');
    }

    public function checkPass($post)
    {
        $pass1 = $post['txtPass'];
        $pass2 = $post['txtPass2'];

        return $pass1 != $pass2 ? true : false;
    }

    public function login()
    {
        $users = new Users();

        $post = $this->request->getPost();
        if (!empty($post)) {
            if ($users->checkLogin($post)) {
                $row = $users->getUserData($post['txtUser']);
                $data = [
                    'USER_ID'       => $row->USER_ID,
                    'USER'          => $row->USER,
                    'EMAIL'         => $row->EMAIL,
                    'NAME'          => $row->NAME,
                    'SU'            => $row->SU
                ];
                $this->session->set($data);
                $mensagem = [
                    'mensagem' => 'Bem vindo',
                    'tipo' => 'alert-success',
                ];
                $mensagem['mensagem'] = 'Bem vindo ' . $_SESSION['NAME'] . '!';
                $this->session->setFlashdata('mensagem', $mensagem);
                return redirect()->to(base_url('/'));
            } else {
                $mensagem['mensagem'] = 'Usuário ou senha inválido';
                $mensagem['tipo'] = 'alert-danger';
                $this->session->setFlashdata('mensagem', $mensagem);
            }
        }
        echo view('users/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
