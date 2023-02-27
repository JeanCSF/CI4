<?php

namespace App\Controllers;

use App\Models\Todo;
use CodeIgniter\Controller;

class Main extends Controller
{

    public function index()
    {
        $job = new Todo();
        if ($this->request->getGet('search')) {
            $searchInput = $this->request->getGet('search');
            $data = [
                'jobs'  => $job->like('JOB', $searchInput)
                               ->orLike('DATETIME_CREATED', $searchInput)
                               ->orderBy('ID_JOB')
                               ->paginate(10),
                'pager' => $job->pager,
            ];
            return view('home', $data);
        }
        $data = [
            'jobs'  => $job->orderBy('ID_JOB')->paginate(10),
            'pager' => $job->pager,
        ];

        echo view('home', $data);
    }

    public function done(){
        $job = new Todo();
        $data = [
            'jobs'    => $job->where('DATETIME_FINISHED !=', NULL)->paginate(10),
            'pager'   => $job->pager,
            'alljobs' => $job->where('DATETIME_FINISHED !=', NULL)->countAllResults(),
        ];
        return view('home', $data);
    }

    public function newJobSubmit()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $job = new Todo();
        $post = $this->request->getPost();

        if (!empty($post)) {
            $dados = [
                'ID_JOB'            => $post['id_job'],
                'JOB'               => $post['job_name'],
                'DATETIME_CREATED'  => date('Y-m-d H:i:s'),
            ];

            if (isset($post['id_job'])) {
                $dados['id_job'] = $post['id_job'];
                $job->save($dados);
            }
        }
        return redirect()->to(base_url('/'));
    }

    public function jobDone($id_job)
    {

        $params = [
            'ID_JOB' => $id_job,
        ];
        $db = db_connect();
        $db->query("
            UPDATE jobs 
            SET DATETIME_FINISHED = NOW(),
            DATETIME_UPDATED = NOW()
            WHERE ID_JOB = :ID_JOB:
        ", $params);
        $db->close();

        return redirect()->to(base_url('/'));
    }

    public function editJobSubmit()
    {
        $params = [
            'ID_JOB' => $this->request->getPost('id_job'),
            'JOB' => $this->request->getPost('job_name'),
        ];
        $db = db_connect();
        $db->query("
            UPDATE jobs
            SET DATETIME_UPDATED = NOW(),
            JOB = :JOB:
            WHERE ID_JOB = :ID_JOB:
        ", $params);
        $db->close();

        return redirect()->to(base_url('/'));
    }

    public function deletar($id_job = -1)
    {
        $params = [
            'ID_JOB' => $id_job,
        ];
        $db = db_connect();
        $db->query("DELETE FROM jobs WHERE ID_JOB = :ID_JOB:", $params);
        $db->close();

        return redirect()->to(base_url('/'));
    }

}
