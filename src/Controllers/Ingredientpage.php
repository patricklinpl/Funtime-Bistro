<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;
use ProjectFunTime\Session\SessionWrapper;

class Ingredientpage
{
   private $request;
   private $response;
   private $renderer;
   private $session;

   public function __construct(
      Request $request,
      Response $response,
      FrontendRenderer $renderer,
      SessionWrapper $session)
   {
      $this->request = $request;
      $this->response = $response;
      $this->renderer = $renderer;
      $this->session = $session;
   }

   public function show()
   {
      $accType = $this->session->getValue('accType');

      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

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