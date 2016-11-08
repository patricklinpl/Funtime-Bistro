<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;
use ProjectFunTime\Database\DatabaseProvider;

class Loginpage
{
   private $request;
   private $response;
   private $renderer;
   private $dbProvider;

   public function __construct(
      Request $request,
      Response $response,
      FrontendRenderer $renderer,
      DatabaseProvider $dbProvider)
   {
      $this->request = $request;
      $this->response = $response;
      $this->renderer = $renderer;
      $this->dbProvider = $dbProvider;
   }

   public function show()
   {
/**
      $test = $this->dbProvider->query("SELECT userName FROM Users WHERE userName = 'quanbao'");
      var_dump($test);

      $data = [];
      $data = array_merge($data, [
         'test' => 'hello world'
      ]);
*/


      $html = $this->renderer->render('Loginpage');
      $this->response->setContent($html);
   }

   public function login()
   {
      $username = $this->request->getParameter('login-username');
      $password = $this->request->getParameter('login-password');
      $accType = $this->request->getParameter('login-acc-type');

      if (!is_string($username) || !is_string($password) || !is_string($accType)) {
      // need to display error page, with layout (header + footer) and possibly link
         throw new \Exception;
      }

      // need to consider accType
      $queryStr = "SELECT * FROM Users WHERE userName = '$username' AND password = '$password' AND u_deleted = 'F'";
      $result = $this->dbProvider->query($queryStr);

      if (empty($result)) {
      // need to display error message. incorrect credentials
         throw new \Exception;
      }

      // need to remember username (fk)

       $html = $this->renderer->render('Homepage');
       $this->response->setContent($html);
   }

   public function createAccount()
   {

   }
}