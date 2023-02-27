<?php

namespace App\Models;

use CodeIgniter\Model;

class Todo extends Model
{
    protected $table            = 'jobs';
    protected $primaryKey       = 'ID_JOB';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['JOB','DATETIME_CREATED', 'DATETIME_UPDATED', 'DATETIME_FINISHED'];



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

    public function getAll()
    {
        $result = $this->orderBy('ID_JOB')->findAll();
        return $result;
    }
    
    public function getJob($id_job)
    {
        $result = $this->find($id_job);
        return $result;
    }

    
}
