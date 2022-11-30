<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProfessorRepository;

class ProfessorController extends AbstractController
{
    // public const REPOSITORY = new ProfessorRepository();

    public function listar(): void
    {
        $this->checkLogin();
        $rep = new ProfessorRepository();
        $professores = $rep->buscarTodos();

        $this->render("professor/listar", [
            'professores' => $professores,
        ]);
    }

    public function cadastrar(): void
    {
        $rep = new ProfessorRepository();
        $professores = $rep->buscarTodos();
        $this->render("professor/cadastrar", [
            'professores' => $professores,
        ]);
    }

    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $rep->excluir($id);
        $this->redirect("/professores/listar");
    }

    public function editar(): void
    {
        
    }
}