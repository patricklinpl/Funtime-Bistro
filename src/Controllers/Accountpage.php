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
      $username = $this->session->getValue('userName');
      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

      $userQueryStr = "SELECT name, phone, address FROM Users " .
                      "WHERE userName = '$username'";
      $userResult = $this->dbProvider->selectQuery($userQueryStr);
      // decorate with exception

      $data = [
         'accType' => $accType,
         'name' => $userResult["name"],
         'phone' => $userResult["phone"],
         'address' => $userResult["address"]
      ];

      if (strcasecmp($accType, 'chef') == 0) {
         $chefQueryStr = "SELECT employee_id, ssNum FROM Chef " .
                         "WHERE chef_userName = '$username'";
         $chefResult = $this->dbProvider->selectQuery($chefQueryStr);
         // decorate with exception check

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
      $name = $this->request->getParameter('account-name');
      $phone = $this->request->getParameter('account-phone');
      $address = $this->request->getParameter('account-address');

      $username = $this->session->getValue('userName');

      if (is_null($name)) {
         throw new InvalidArgumentException("required form input missing. name.");
      }

      $updateQueryStr = "UPDATE Users " .
                        "SET name = '$name', phone = '$phone', address = '$address' " .
                        "WHERE userName = '$username'";

      $updated = $this->dbProvider->updateQuery($updateQueryStr);

      if (!$updated) {
         throw new UnknownException("Failed to update User with $name, $phone, $address");
      }
   }

   public function showAllChefAccounts()
   {
      $accType = $this->session->getValue('accType');
      if (is_null($accType) || strcasecmp($accType, 'admin') != 0) {
         header('Location: /');
         exit();
      }

      $chefQueryStr = "SELECT userName, name, phone, address, employee_id, ssNum FROM Users " . 
                      "INNER JOIN Chef " .
                      "ON Users.userName = Chef.chef_userName " .
                      "WHERE type = 'chef' AND u_deleted = 'F'";
      $chefResult = $this->dbProvider->selectMultipleRowsQuery($chefQueryStr);

      $data = [
         'chefs' => $chefResult
      ];

      $html = $this->renderer->render('ManageChefpage', $data);
      $this->response->setContent($html);
   }

   public function showCreateChefForm()
   {
      $data = [];
      
      $html = $this->renderer->render('CreateChefFormpage', $data);
      $this->response->setContent($html);      
   }

   public function createChefAccount()
   {
      $name = $this->request->getParameter('chef-name');
      $username = $this->request->getParameter('chef-username');
      $password = $this->request->getParameter('chef-password');
      $phone = $this->request->getParameter('chef-phone');
      $address = $this->request->getParameter('chef-address');
      $ssNum = $this->request->getParameter('chef-ssNum');

      $currentUsername = $this->session->getValue('userName');

      $accType = $this->session->getValue('accType');
      if (strcasecmp($accType, 'admin') != 0) {
         header('Location: /');
         exit();
      }

      if (is_null($name) || is_null($username) || is_null($password)) {
         throw new InvalidArgumentException("required form input missing. Either name, username, or password.");
      }


      if ($ssNum == '') {
         $temp1 = "(chef_userName, admin_userName) ";
         $temp2 = "('$username', '$currentUsername')";
      }
      else {
         $temp1 = "(chef_userName, admin_userName, ssNum) ";
         $temp2 = "('$username', '$currentUsername', '$ssNum')";
      }

      $insertUserQueryStr = "INSERT INTO Users " .
                            "(userName, password, type, name, phone, address, createDate, u_deleted) " .
                            "VALUE " .
                            "('$username', '$password', 'chef', '$name', '$phone', '$address', now(), 'F')";

      $insertChefQueryStr = "INSERT INTO Chef " .
                            $temp1 .
                            "VALUE " .
                            $temp2;

      $queryArr = [
         1 => $insertUserQueryStr,
         2 => $insertChefQueryStr
      ];
      $queryResult = $this->dbProvider->applyQueries($queryArr);
      // may fail because of username conflict
      if (!$queryResult) {
         throw new UnknownException("Failed to insert User and Chef");
      }
   }

   public function showEditChefForm($routeParams)
   {
      $username = $routeParams["username"];

      $accType = $this->session->getValue('accType');
      if (strcasecmp($accType, 'admin') != 0) {
         header('Location: /');
         exit();
      }

      $chefQueryStr = "SELECT userName, name, phone, address, employee_id, ssNum FROM Users " .
                      "INNER JOIN Chef " .
                      "ON Users.userName = Chef.chef_userName " .
                      "WHERE userName = '$username' AND type = 'chef' AND u_deleted = 'F'";
      $chefResult = $this->dbProvider->selectQuery($chefQueryStr);
      // need to check result
      $data = [
         'name' => $chefResult["name"],
         'userName' => $chefResult["userName"],
         'phone' => $chefResult["phone"],
         'address' => $chefResult["address"],
         'employee_id' => $chefResult["employee_id"],
         'ssNum' => $chefResult["ssNum"]
      ];

      $html = $this->renderer->render('EditChefFormpage', $data);
      $this->response->setContent($html);
   }

// will fail on constrinst like uniqueness of employeeid, ssNum
   public function updateChefAccount($routeParams)
   {
      $name = $this->request->getParameter('chef-name');
      $username = $this->request->getParameter('chef-username');
      $phone = $this->request->getParameter('chef-phone');
      $address = $this->request->getParameter('chef-address');
      $employee_id = $this->request->getParameter('chef-employee-id');
      $ssNum = $this->request->getParameter('chef-ssNum');


      $currentUsername = $this->session->getValue('userName');

      $accType = $this->session->getValue('accType');
      if (strcasecmp($accType, 'admin') != 0) {
         header('Location: /');
         exit();
      }

      if (is_null($name) || is_null($username)) {
         throw new InvalidArgumentException("required form input missing. Either name, or username.");
      }

      if ($ssNum == '') {
         $temp = "SET employee_id = '$employee_id' ";
      }
      else {
         $temp = "SET employee_id = '$employee_id', ssNum = '$ssNum' ";
      }

      $updateUserQueryStr = "UPDATE Users " .
                            "SET name = '$name', phone = '$phone', address = '$address' " .
                            "WHERE userName = '$username' AND type = 'chef'";

      $updateChefQueryStr = "UPDATE Chef " .
                            $temp .
                            "WHERE chef_userName = '$username'";

      $queryArr = [
         1 => $updateUserQueryStr,
         2 => $updateChefQueryStr
      ];
      $queryResult = $this->dbProvider->applyQueries($queryArr);
      // may fail because of username conflict
      if (!$queryResult) {
         throw new UnknownException("Failed to insert User and Chef");
      }
   }

   public function deleteChefAccount($routeParams)
   {
      $username = $this->request->getParameter('chef-username');

      $accType = $this->session->getValue('accType');
      if (strcasecmp($accType, 'admin') != 0) {
         header('Location: /');
         exit();
      }

      if (is_null($username)) {
         throw new InvalidArgumentException("Username missing.");
      }

      $validateQueryStr = "SELECT type FROM Users " .
                          "WHERE userName = '$username'";

      $validateResult = $this->dbProvider->selectQuery($validateQueryStr);
                          // check type is chef, exception with dynamic message


      $softDeleteQuery = "UPDATE Users " .
                         "SET u_deleted = 'T'" .
                         "WHERE userName = '$username'";
      $softDeleteResult = $this->dbProvider->updateQuery($softDeleteQuery);

      if (!$softDeleteResult) {
         throw new UnknownException("Failed to (soft-)delete Chef account");
      }
   }
}