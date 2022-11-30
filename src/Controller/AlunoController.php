<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Aluno;
use App\Notification\WebNotification;
use App\Repository\AlunoRepository;
use Dompdf\Dompdf;
use Exception;

class AlunoController extends AbstractController
{
    private AlunoRepository $repository;

    public function __construct()
    {
        $this->repository = new AlunoRepository();
    }

    public function listar(): void
    {
        $this->checkLogin();
        $alunos = $this->repository->buscarTodos();
        $this->render('aluno/listar', [
            'alunos' => $alunos,
        ]);
    }

    public function cadastrar(): void
    {
        $this->checkLogin();
        if (true === empty($_POST)) {
            $this->render('aluno/cadastrar');
            return;
        }

        $aluno = new Aluno();
        $aluno->nome = $_POST['nome'];
        $aluno->dataNascimento = $_POST['nascimento'];
        $aluno->cpf = $_POST['cpf'];
        $aluno->email = $_POST['email'];
        $aluno->genero = $_POST['genero'];

        try {
            $this->repository->inserir($aluno);
        } catch (Exception $exception) {
            if (true === str_contains($exception->getMessage(), 'cpf')) {
                WebNotification::add('CPF já cadastrado', 'danger');
                $this->redirect('/alunos/cadastrar');
                return;
            }

            if (true === str_contains($exception->getMessage(), 'email')) {
                WebNotification::add('Email já cadastrado', 'danger');
                $this->redirect('/alunos/cadastrar');
                return;
            }
        }

        WebNotification::add('Aluno cadastrado com sucesso', 'success');
        $this->redirect('/alunos/listar');
    }

    public function editar(): void
    {
        $this->checkLogin();
        $id = $_GET['id'];
        $rep = new AlunoRepository();
        $aluno = $rep->buscarUm($id);
        $this->render('aluno/editar', [$aluno]);
        if (false === empty($_POST)) {
            $aluno->nome = $_POST['nome'];
            $aluno->dataNascimento = $_POST['nascimento'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];
    
            try {
                $rep->atualizar($aluno, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    WebNotification::add('CPF já cadastrado', 'danger');
                    $this->redirect('/alunos/editar?id='.$id);
                    return;
                }
    
                if (true === str_contains($exception->getMessage(), 'email')) {
                    WebNotification::add('Email já cadastrado', 'danger');
                    $this->redirect('/alunos/editar?id='.$id);
                    return;
                }
            }
            
            WebNotification::add('Dados do Aluno alterados com sucesso', 'success');
            $this->redirect('/alunos/listar');
        }
    }

    public function excluir(): void
    {

        $id = $_GET['id'];

        $this->repository->excluir($id);
        WebNotification::add('Aluno excluido com sucesso', 'success');
        $this->redirect('/alunos/listar');

    }

    public function relatorio(): void
    {
        $hoje = date('d/m/Y');
        $alunos = $this->repository->buscarTodos();

        $design = "
            <h1>Relatorio de Alunos</h1>
            <hr>
            <em>Gerado em {$hoje}</em>

            <table width='100%' style='margin-top: 30px;'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Matricula</th>
                        <th>CPF</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$alunos[0]->id}</td>
                        <td>{$alunos[0]->nome}</td>
                        <td>{$alunos[0]->matricula}</td>
                        <td>{$alunos[0]->cpf}</td>
                        <td>{$alunos[0]->email}</td>
                    </tr>

                    <tr>
                        <td>{$alunos[1]->id}</td>
                        <td>{$alunos[1]->nome}</td>
                        <td>{$alunos[1]->matricula}</td>
                        <td>{$alunos[1]->cpf}</td>
                        <td>{$alunos[1]->email}</td>
                    </tr>
                </tbody>
            </table>
        ";

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait'); // tamanho da pagina

        $dompdf->loadHtml($design); //carrega o conteudo do PDF

        $dompdf->render(); //aqui renderiza 
        $dompdf->stream('relatorio-alunos.pdf', [
            'Attachment' => 0,
        ]); //é aqui que a magica acontece
    }
}