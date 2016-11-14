<?php declare(strict_types = 1);

namespace ProjectFunTime\Controllers;

use Http\Request;
use Http\Response;
use ProjectFunTime\Template\FrontendRenderer;
use ProjectFunTime\Database\DatabaseProvider;
use ProjectFunTime\Session\SessionWrapper;
use ProjectFunTime\Exceptions\PermissionException;
use ProjectFunTime\Exceptions\MissingEntityException;
use ProjectFunTime\Exceptions\EntityExistsException;
use ProjectFunTime\Exceptions\SQLException;
use \InvalidArgumentException;

class Menupage
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

   public function showAllMenuItems()
   {
      $accType = $this->session->getValue('accType');

      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

      $menuQueryStr = "SELECT name, price, category, description, quantity FROM MenuItem WHERE m_deleted = 'F'";

      $menuResult = $this->dbProvider->selectMultipleRowsQuery($menuQueryStr);

      $data = [
      'menu' => $menuResult
      ];

      $html = $this->renderer->render($page, $data);
      $this->response->setContent($html);
   }

   public function create()
   {

      $menuName = trim($this->request->getParameter('menu-name'));
      $menuPrice = trim($this->request->getParameter('menu-price'));
      $menuCat = trim($this->request->getParameter('menu-category'));
      $menuDesc = trim($this->request->getParameter('menu-description'));
      $menuQty = trim($this->request->getParameter('menu-quantity'));

      $accType = $this->session->getValue('accType');

      if (is_null($accType) ||
          (strcasecmp($accType, 'chef') != 0 &&
          strcasecmp($accType, 'admin') != 0)) {
         throw new PermissionException("Must be admin or chef in order to create menu item");
      }

      if (is_null($menuName) || strlen($menuName) == 0 ||
          is_null($menuPrice) || strlen($menuPrice) == 0 ||
          !ctype_digit($menuPrice) || 
          is_null($menuCat) || strlen($menuCat) == 0 ||
          is_null($menuQty) || strlen($menuQty) == 0 || 
          !ctype_digit($menuQty)
          ) {
         throw new InvalidArgumentException("required form input missing. Ingredient name or type.");
      }

      $menuQueryStr = "SELECT * FROM MenuItem WHERE m_deleted = 'F' AND name = '$menuName' ";
      $menuQueryResult = $this->dbProvider->selectQuery($menuQueryStr);

      if (!empty($menuQueryResult)) {
         throw new EntityExistsException("Ingredient exists with name $menuName");
      }

      $deletedMenuQueryStr = "SELECT * FROM MenuItem " .
                             "WHERE name = '$menuName' AND m_deleted = 'T'";
      $deletedMenuQueryResult = $this->dbProvider->selectQuery($deletedMenuQueryStr);

      if (!empty($deletedIngredQueryResult)) {
         $createIngredQueryStr = "UPDATE MenuItem SET price = '$menuPrice', category = '$menuCat', description = '$menuDesc', quantity = '$menuQty', m_deleted = 'F' WHERE name = '$menuName'";
      }
      else {
         $createIngredQueryStr = "INSERT INTO MenuItem (name, price, category, description, quantity, m_deleted) VALUES('$menuName', '$menuPrice', '$menuCat', '$menuDesc', '$menuQty', 'F' )";
      }

      $created = $this->dbProvider->insertQuery($createIngredQueryStr);
      
      if (!$created) { 
         throw new SQLException("Failed to create Ingredient with $ingredName");
      }


   }

   public function update()
   {

   }

   public function delete()
   {

   }
}