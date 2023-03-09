<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PostModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;


class AdminPosts extends AdminControlador
{
    public function listar():void
    {
        echo $this->template->renderizar('posts/listar.html', [
            'posts' => (new PostModelo())->busca(),
            'total' => [
                'total' => (New PostModelo())->total(),
                'ativo' => (New PostModelo())->total('status = 1'),
                'inativo' => (New PostModelo())->total('status = 0')

            ]
        ]);
    }
    
     public function cadastrar():void
    {
         $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         if(isset($dados)){
            (new PostModelo())->armazenar($dados);
            $this->mensagem->sucesso('Post cadastrado com sucesso')-> flash();
            Helpers::redirecionar('admin/posts/listar');
         }
         
        echo $this->template->renderizar('posts/formulario.html', [
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }
    
    public function editar(int $id):void
    {
        $post = (new PostModelo())->buscaPorId($id);
        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         if(isset($dados)){
              (new PostModelo())->atualizar($dados, $id);
              $this->mensagem->sucesso('Post atualizado com sucesso')-> flash();
              Helpers::redirecionar('admin/posts/listar');
         }
        
        echo $this->template->renderizar('posts/formulario.html', [
            'post' => $post,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function deletar(int $id):void
    {
        (new PostModelo())->deletar($id);
        $this->mensagem->erro('Post Deletado')-> flash();
        Helpers::redirecionar('admin/posts/listar');
    }
}
