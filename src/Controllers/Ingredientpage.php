<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;

class Ingredientpage
{
   private $request;
   private $response;
   private $renderer;

   public function __construct(Request $request, Response $response, FrontendRenderer $renderer)
   {
      $this->request = $request;
      $this->response = $response;
      $this->renderer = $renderer;
   }

   public function show()
   {
      $data = [];
      $html = $this->renderer->render('Ingredientpage', $data);
      $this->response->setContent($html);
   }

   public function update($routeParams)
   {

   }

   public function delete($routeParams)
   {

   }
}