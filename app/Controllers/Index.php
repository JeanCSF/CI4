<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Index extends Controller
{
    public function index()
    {
        $session = session();
        $checksess = $session->USER_ID;
        if ($checksess) {
            redirect('/');
        } else {
            $this->home();
        }
    }
    public function home()
    {
        $session = session();
        $checksess = $session->USER_ID;
        if ($checksess) {
            redirect('/');
        } else {
            echo view('main');
        }
    }
}
