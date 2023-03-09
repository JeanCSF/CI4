<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\Controller;

class Userscontroller extends BaseController
{

    public function signUp()
    {
        $email = \Config\Services::email();
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
                $mensagem['mensagem'] = 'Usuário ou email já cadastrado!';
                $mensagem['tipo'] = 'alert-danger';
                $this->session->setFlashdata('mensagem', $mensagem);
                return view('users/signup', $data);
            } else if ($users->signUpCreateAccount($post)) {
                $key = password_hash($post['txtPass'] . date('Y-m-d H:i:s'), PASSWORD_BCRYPT);
                $email = \Config\Services::email();

                $config = [
                    'protocol'      => 'smtp',
                    'SMTPHost'      => 'sandbox.smtp.mailtrap.io',
                    'SMTPUser'      => '6a29d381cdc759',
                    'SMTPPass'      => '60e1758b41e608',
                    'SMTPPort'      => '2525',
                ];
                
                $email->initialize($config);

                $email->setFrom('jean.carlos16@livecom', 'Jean');
                $email->setTo($post['txtEmail']);

                $email->setSubject($post['txtName'] . 'Confirme seu E-mail para continuar');
                $email->setMessage("Olá, ".$post['txtName'] .
                                   "\n\nAgradecemos o seu cadastro, para ter acesso a sua conta por favor confirme o seu e-mail através do link abaixo.
                                   \n\n". (base_url('userscontroller/emailconfirm/'. $key)));

                if($email->send()){
                $mensagem['mensagem'] = 'Cadastro criado com sucesso, acesse seu email para confirmar a conta!';
                $mensagem['tipo'] = 'alert-success';
                $this->session->setFlashdata('mensagem', $mensagem);
                return redirect()->to(base_url('/'));
                }
            }
        }
        echo view('users/signup');
    }

    public function emailConfirm($key){
        $users = new Users();
        if(!empty($key)){
            if($users->getUserKey($key)){
                
            }
        }
        echo view('users/confirmation');
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
                if ($row->ACTIVATION == 0) {
                    $mensagem = [
                        'mensagem' => 'Por favor ative sua conta para acessar!',
                        'tipo' => 'alert-danger',
                    ];
                    $this->session->setFlashdata('mensagem', $mensagem);
                    return view('users/login');
                } else {
                    $data = [
                        'USER_ID'       => $row->USER_ID,
                        'USER'          => $row->USER,
                        'EMAIL'         => $row->EMAIL,
                        'NAME'          => $row->NAME,
                        'SU'            => $row->SU,
                    ];
                    $this->session->set($data);
                    $mensagem = [
                        'mensagem' => 'Bem vindo',
                        'tipo' => 'alert-success',
                    ];
                    $mensagem['mensagem'] = 'Bem vindo ' . $_SESSION['NAME'] . '!';
                    $this->session->setFlashdata('mensagem', $mensagem);
                    return redirect()->to(base_url('/'));
                }
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
