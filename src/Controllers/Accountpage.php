<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;
use ProjectFunTime\Database\DatabaseProvider;
use ProjectFunTime\Session\SessionWrapper;
use ProjectFunTime\Exceptions\UnknownException;
use \InvalidArgumentException;

class Accountpage
{
   private $request;
   private $response;
   private $renderer;
   private $dbProvider;
   private $session;

   public function __construct(
      Request $request,
      Response $response,
      FrontendRenderer $renderer,
      DatabaseProvider $dbProvider,
      SessionWrapper $session)
   {
      $this->request = $request;
      $this->response = $response;
      $this->renderer = $renderer;
      $this->dbProvider = $dbProvider;
      $this->session = $session;
   }
   
   public function show()
   {
      $accType = $this->session->getValue('accType');
      $userName = $this->session->getValue('userName');
      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

      $userQueryStr = "SELECT name, phone, address FROM Users " .
                  "WHERE userName = '$userName'";
      $userResult = $this->dbProvider->selectQuery($userQueryStr);
      $this->session->setValue('name', $userResult["name"]);

      $data = [
         'accType' => $accType,
         'name' => $userResult["name"],
         'phone' => $userResult["phone"],
         'address' => $userResult["address"]
      ];

      if (strcasecmp($accType, 'chef') == 0) {
         $chefQueryStr = "SELECT employee_id, ssNum FROM Chef " .
                         "WHERE chef_userName = '$userName'";
         $chefResult = $this->dbProvider->selectQuery($chefQueryStr);

         $data = array_merge($data, [
         'employeeId' => $chefResult["employee_id"],
         'ssNum' => $chefResult["ssNum"]
         ]);
      }

      $html = $this->renderer->render('Accountpage', $data);
      $this->response->setContent($html);
   }

   public function update()
   {
      $name = $this->request->getParameter('name');
      $phone = $this->request->getParameter('phone');
      $address = $this->request->getParameter('address');

      $userName = $this->session->getValue('userName');

      if (is_null($name)) {
         throw new InvalidArgumentException("required form input missing. name.");
      }

      $updateQueryStr = "UPDATE Users " .
                        "SET name = '$name', phone = '$phone', address = '$address' " .
                        "WHERE userName = '$userName'";

      $updated = $this->dbProvider->updateQuery($updateQueryStr);

      if (!$updated) {
         throw new UnknownException("Failed to update User with $name, $phone, $address");
      }
   }

   public function showAllAccounts()
   {

   }

   public function create()
   {

   }

   public function updateChefAccount($routeParams)
   {
   
   }

   public function deleteChefAccount($routeParams)
   {

   }
}