<?php

namespace App\Controllers;

use App\Models\Todo;
use CodeIgniter\Controller;

class Main extends Controller
{

    public function index()
    {
        $session = session();
        $job = new Todo();
        if ($session->has('USER_ID')) {
        if ($this->request->getGet('search')) {
            $searchInput = $this->request->getGet('search');
            $data = [
                'jobs'      => $job->like('JOB', $searchInput)
                                   ->orLike('DATETIME_CREATED', $searchInput)
                                   ->orderBy('ID_JOB')
                                   ->paginate(10),
                'pager'     => $job->pager,
                'alljobs'   => $job->like('JOB', $searchInput)
                                   ->orLike('DATETIME_CREATED', $searchInput)
                                   ->countAllResults(),
                'search'     => true,
              
            ];
            return view('home', $data);
        }
        
        $data = [
            'jobs'  => $job->orderBy('ID_JOB')->paginate(10),
            'alljobs'   => $job->select()->countAll(),
            'pager'     => $job->pager,
            
        ];

        echo view('home', $data);
    } else {
        $this->home();
    }
    }

    public function home()
    {
        $session = session();
        if ($session->has('USER_ID')) {
            redirect()->to(base_url('/'));
        } else {
            echo view('main');
        }
    }

    public function done(){
        $job = new Todo();
        $searchInput = $this->request->getGet('search'); 
        if ($searchInput) {
            $data = [
                'jobs'      => $job
                                   ->like('JOB', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->orLike('DATETIME_CREATED', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->orLike('DATETIME_FINISHED', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->orderBy('ID_JOB')
                                   ->paginate(10),
                'pager'     => $job->pager,
                'alljobs'   => $job->like('JOB', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->orLike('DATETIME_CREATED', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->orLike('DATETIME_FINISHED', $searchInput)->where('DATETIME_FINISHED !=', NULL)
                                   ->countAllResults(),
                'done'      => true,
                'search'    => true,
            ];
            return view('home', $data);
        }
        $data = [
            'jobs'    => $job->where('DATETIME_FINISHED !=', NULL)->paginate(10),
            'pager'   => $job->pager,
            'alljobs' => $job->where('DATETIME_FINISHED !=', NULL)->countAllResults(),
            'done'    => true,
        ];
        return view('home', $data);
    }

    public function newJobSubmit()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $job = new Todo();
        $post = $this->request->getPost();

        if (!empty($post)) {
            $data = [
                'ID_JOB'            => $post['id_job'],
                'JOB'               => $post['job_name'],
                'DATETIME_CREATED'  => date('Y-m-d H:i:s'),
            ];

            if (isset($post['id_job'])) {
                $dados['id_job'] = $post['id_job'];
                $job->save($data);
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
