<?php 

namespace App\Controllers;

use App\Models\Todo;
use CodeIgniter\Controller;

class Main extends Controller
{

    public function index()
    {

        $job = new Todo();

        $data = [
            'jobs'  => $job->orderBy('ID_JOB')->paginate(10),
            'pager' => $job->pager
        ];

        // $dados['jobs'] = $this->getJobs();
        // $data = [
        //     'jobs' => $dados['jobs']->paginate(10),
        //     'pager' => $dados['jobs']->pager
        // ];
         echo view('home', $data);
    }

    private function getJobs(){
        $db = db_connect();
        $dados = $db->query("SELECT * FROM jobs")->getResultObject();
        $db->close();

        return $dados;
    }

    public function new_job(){

        return view('jobform');

    }

    public function newJobSubmit(){

        if(!$_SERVER['REQUEST_METHOD'] == 'POST') {
            return redirect()->to(site_url('/'));
        }

        

        $params = [
            'JOB' => $this->request->getPost('job_name'),
        ];
        $db = db_connect();
        $db->query("
            INSERT INTO jobs(JOB, DATETIME_CREATED)
            VALUES(
                    :JOB:,
                    NOW()
                  )", $params);
        $db->close();

        return redirect()->to(site_url('/'));
    }

    public function jobDone($id_job){

        $params = [
            'ID_JOB' =>$id_job,
        ];
        $db = db_connect();
        $db->query("
            UPDATE jobs 
            SET DATETIME_FINISHED = NOW(),
            DATETIME_UPDATED = NOW()
            WHERE ID_JOB = :ID_JOB:
        ", $params);
        $db->close();

        return redirect()->to(site_url('/'));
    }

    public function editJob($id_job = -1){
        $db = db_connect();
        $params = [
            'ID_JOB' => $id_job,
        ];
        $dados = $db->query("SELECT * FROM jobs WHERE ID_JOB = :ID_JOB:", $params)->getResultObject();
        $db->close();
        $data['job'] = $dados[0];
        $editar = [
            'editar' => true,
            'job' => $data['job']
        ];

        return view('jobform', $editar);
    }

    public function editJobSubmit(){
        
        // if(!$_SERVER['REQUEST_METHOD'] == 'UPDATE') {
        //     return redirect()->to(site_url('/'));
        // }

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

        return redirect()->to(site_url('/'));
    }

    public function deleteJob($id_job = -1){
        $params = [
            'ID_JOB' => $id_job,
        ];
        $db = db_connect();
        $data = $db->query("select * FROM jobs WHERE ID_JOB = :ID_JOB:", $params)->getResultObject()[0];
        $db->close();

        return $data;
    }

    public function deletar($id_job = -1){
        $params = [
            'ID_JOB' => $id_job,
        ];
        $db = db_connect();
        $db->query("DELETE FROM jobs WHERE ID_JOB = :ID_JOB:", $params);
        $db->close();

        return redirect()->to(site_url('main'));
    }

}
