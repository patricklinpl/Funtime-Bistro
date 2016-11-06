<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;

class Loginpage
{
   private $request;
   private $response;

   public function __construct(Request $request, Response $response)
   {
      $this->request = $request;
      $this->response = $response;
   }

   public function show()
   {
       $data = [];
//       $html = $this->renderer->render('Homepage', $data);
       $this->response->setContent($html);
   }

   public function login()
   {

   }

   public function createAccount()
   {

   }
}