<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;

class Accountpage
{
   private $request;
   private $response;

   public function __constructor(Request $request, Response $response)
   {
      $this->request = $request;
      $this->response = $response;
   }
   
   public function show()
   {

   }   

   public function create()
   {

   }

   public function update($routeParams)
   {
   
   }

   public function delete($routeParams)
   {

   }
}