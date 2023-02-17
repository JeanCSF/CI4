<?php 

namespace App\Controllers;
use CodeIgniter\Controller;

class Main extends Controller
{

    public function index()
    {

        $db = \Config\Database::connect();
        $dados = $db->query("SELECT * FROM CLIENTES")->getResultArray();
        $db->close();

        echo view('templates/header');
        echo '<div class="card p-4 col-4 offset-4 mt-5 text-center">';
        echo '<table class="table table-striped">';
        echo '<thead class="table-dark">';
                    echo '<tr>';
                        echo '<th>';
                            echo 'ID';
                        echo '</th>';
                        echo '<th>';
                            echo 'Nome';
                        echo '</th>';
                        echo '<th>';
                            echo 'Email';
                        echo '</th>';
                    echo '</tr>';
                echo '</thead>';
        foreach($dados as $row){
                    echo '<tr>';
                        echo '<td>';
                            echo $row['ID_CLIENTE'];
                        echo '</td>';
                        echo '<td>';
                            echo $row['NOME'];
                        echo '</td>';
                        echo '<td>';
                            echo $row['EMAIL'];
                        echo '</td>';
                    echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
        echo view('templates/footer');
    }

}
