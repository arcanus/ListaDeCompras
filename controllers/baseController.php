<?php
  namespace controllers;

  class baseController
  {

    public function indexAction()
    {
      $articulos = \entities\articulosEntity::getAll();

      renderView('indexView.html.twig', array('articulos' => $articulos));
    }

    public function deleteAction($id)
    {
      \entities\articulosEntity::deleteById($id);

      header("Location: /");
    }

    public function insertAction($params)
    {
      $articulo = new \entities\articulosEntity();

      $articulo->setNombre($params[0]);

      $articulo->insert();
      
    }

  }

?>
