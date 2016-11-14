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

class Orderpage
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

      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

      $user = $this->session->getValue('userName');

      $openOrder_sql = "SELECT o.order_id, SUM(Case When c.qty >= 2 Then m.price * c.qty * 0.9 ELSE m.price * c.qty END) as price, o.customer_userName FROM orders o, contains c, menuitem m WHERE o.order_id = c.order_id AND c.name = m.name AND o.status != 'paid' AND o.customer_userName = '$user' GROUP BY o.order_id";

      $closedOrder_sql = "SELECT o.order_id, SUM(Case When c.qty >= 2 Then m.price * c.qty * 0.9 ELSE m.price * c.qty END) as price, o.customer_userName FROM orders o, contains c, menuitem m WHERE o.order_id = c.order_id AND c.name = m.name AND o.status = 'paid' AND o.customer_userName = '$user' GROUP BY o.order_id";

      $openOrderResult = $this->dbProvider->selectMultipleRowsQuery($openOrder_sql);
      $closedOrderResult = $this->dbProvider->selectMultipleRowsQuery($closedOrder_sql);

      $data = [
         'order' => $openOrderResult
         'order2' => $closedOrderResult
      ];

      $html = $this->renderer->render('Orderpage', $data);
      $this->response->setContent($html);
   }

   public function create()
   {

   }

   public function addMenuItem()
   {

   }

   public function updateMenuItemQuantity()
   {

   }

   public function removeMenuItem()
   {
      $menuName = $this->request->getParameter('menu-name');
      $orderid = $this->request->getParameter('order-id');

      if (is_null($menuName) || strlen($menuName) == 0 ||
         is_null($orderid) || strlen($orderid) == 0 ) {
         throw new InvalidArgumentException("Menu item name and order id missing.");
      }

      $validateQueryStr = "SELECT * FROM Contains WHERE name = '$menuName' AND order_id = '$orderid'";
      $validateResult = $this->dbProvider->selectQuery($validateQueryStr);

      if (!empty($validateResult)) {
         $deleteQueryStr = "DELETE FROM Contains WHERE name = '$menuName' AND order_id = '$orderid'";
         $deleteResult = $this->dbProvider->updateQuery($deleteQueryStr);

         if (!$deleteResult) {
            throw new SQLException("Item failed to be removed from Order!");
         }
      }
      else {
         throw new MissingEntityException("Unable to find item $menuName in Order $orderid to delete");
      }
   }

   public function purchase()
   {
      
   }
}