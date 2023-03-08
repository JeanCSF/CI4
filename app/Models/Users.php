<?php

namespace App\Models;

use App\Controllers\UsersController;
use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'login';
    protected $primaryKey       = 'USER_ID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['USER', 'PASS', 'NAME', 'EMAIL', 'SU'];



    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function signUpCreateAccount($post)
    {
        $data = [
            'USER'      => $post['txtUser'],
            'PASS'      => password_hash($post['txtPass'], PASSWORD_BCRYPT),
            'NAME'      => $post['txtName'],
            'EMAIL'     => $post['txtEmail'],
            'SU'        => 0

        ];

        return $this->insert($data)? true : false;
    }

    public function signUpCheckUser($post)
    {
        $user = $post['txtUser'];
        $email = $post['txtEmail'];
        $where = "USER = {$user} OR EMAIL = {$email}";
        $query = $this->select('login')
            ->where($where)
            ->countAll();


        return $query ? true : false;
    }

    public function checkLogin($post)
    {

        $user = $post['txtUser'];
        $pass = $post['txtPass'];
        $query = $this->select('*')
            ->where('USER', $user)->get();
        $row = $query->getRow();
        $hash = $row->PASS;

        return (password_verify($pass, $hash)) ? true : false;
    }

    public function getUserData($user)
    {
        $data = $this->where('USER', $user)->get();
        $userData = $data->getRow();
        return $userData;
    }
}
