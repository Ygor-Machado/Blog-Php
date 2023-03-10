<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;


class AdminCategorias extends AdminControlador
{
    public function listar():void
    {
        echo $this->template->renderizar('categorias/listar.html', [
            'categorias' => (new CategoriaModelo())->busca()->ordem('id DESC')->resultado(true),
            'total' => [
                'total' => (New CategoriaModelo())->total(),
                'ativo' => (New CategoriaModelo())->total('status = 1'),
                'inativo' => (New CategoriaModelo())->total('status = 0')

            ]
        ]);
    }
    
     public function cadastrar():void
    {
         $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         if(isset($dados)){
             (new CategoriaModelo())->armazenar($dados);
             Helpers::redirecionar('admin/categorias/listar');
         }
         
        echo $this->template->renderizar('categorias/formulario.html', []);
    }
    
     public function editar(int $id):void
    {
        $categoria = (new CategoriaModelo())->buscaPorId($id);
        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         if(isset($dados)){
             (new CategoriaModelo())->atualizar($dados, $id);
             Helpers::redirecionar('admin/categorias/listar');
         }
        
        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $categoria
        ]);
    }

    public function deletar(int $id):void
    {
        (new CategoriaModelo())->deletar($id);
        Helpers::redirecionar('admin/categorias/listar');
    }
}
