<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;

class Menupage
{
   private $request;
   private $response;

   public function __constructor(Request $request, Response $response)
   {
      $this->request = $request;
      $this->response = $response;
   }

   public function showAllMenuItems()
   {

   }

   public function showMenuItemById($routeParams)
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