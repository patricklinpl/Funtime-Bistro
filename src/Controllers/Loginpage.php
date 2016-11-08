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

      if (is_null($username) || is_null($password) || is_null($accType)) {
      // error message handled by frontend, need to pass error message and extend Exception for
      // more specific cases like nullparameter exception etc
         throw new \Exception;
      }

      $queryStr = "SELECT * FROM Users " .
                  "WHERE userName = '$username' AND " .
                  "password = '$password' AND " .
                  "type = '$accType' AND " .
                  "u_deleted = 'F'";
      $result = $this->dbProvider->selectQuery($queryStr);

      if (empty($result)) {
      // need to display error message. incorrect credentials
         throw new \Exception;
      }

      // need to remember username (fk)
   }

   public function createAccount()
   {
      // need frontend validation on password and repeat password
      // needs disclaimer about password being saved as plaintext
      $name = $this->request->getParameter('reg-name');
      $username = $this->request->getParameter('reg-username');
      $password = $this->request->getParameter('reg-password');
      $phone = $this->request->getParameter('reg-phone');
      $address = $this->request->getParameter('reg-address');

      if (!is_string($name) || !is_string($username) || !is_string($password)) {
      // similar to above
         throw new \Exception;
      }

      $usernameQueryStr = "SELECT * FROM Users WHERE userName = '$username'";
      $usernameQueryResult = $this->dbProvider->selectQuery($usernameQueryStr);

      if (!empty($usernameQueryResult)) {
      // similar to above
         throw new \Exception;
      }

      $registerQueryStr = "INSERT INTO Users " .
                          "(userName, password, type, name, phone, address, createDate, u_deleted) " .
                          "VALUE " .
                          "('$username', '$password', 'customer', '$name', '$phone', '$address', now(), 'F')";

      $created = $this->dbProvider->insertQuery($registerQueryStr);
      
      if (!$created) {
      // display error
         throw new \Exception;
      }
   }
}