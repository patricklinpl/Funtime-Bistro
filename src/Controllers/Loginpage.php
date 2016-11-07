<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;

class Loginpage
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
       $html = $this->renderer->render('Loginpage', $data);
       $this->response->setContent($html);
   }

   public function login()
   {

   }

   public function createAccount()
   {

   }
}