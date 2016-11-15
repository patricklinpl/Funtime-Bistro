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

class Orderpage {
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

   public function show() {
      $accType = $this->session->getValue('accType');

      if (is_null($accType)) {
         header('Location: /');
         exit();
      }

      $user = $this->session->getValue('userName');


      $openOrder_sql = "SELECT o.order_id, SUM(Case When c.qty >= 2 " .
                       "Then m.price * c.qty * 0.9 ELSE m.price * c.qty END) " .
                       "as price, o.customer_userName " .
                       "FROM orders o, contains c, menuitem m " .
                       "WHERE o.order_id = c.order_id " .
                       "AND c.name = m.name " .
                       "AND o.paymentStatus != 'paid' " .
                       "AND o.customer_userName = '$user' " .
                       "GROUP BY o.order_id";

      $closedOrder_sql = "SELECT o.order_id, SUM(Case When c.qty >= 2 " .
                         "Then m.price * c.qty * 0.9 ELSE m.price * c.qty END) " .
                         "as price, o.customer_userName " .
                         "FROM orders o, contains c, menuitem m " .
                         "WHERE o.order_id = c.order_id " .
                         "AND c.name = m.name " .
                         "AND o.paymentStatus = 'paid' " .
                         "AND o.customer_userName = '$user' " .
                         "GROUP BY o.order_id";

      $openOrderResult = $this->dbProvider->selectMultipleRowsQuery($openOrder_sql);
      $closedOrderResult = $this->dbProvider->selectMultipleRowsQuery($closedOrder_sql);

      $data = [
         'order' => $openOrderResult,
         'order2' => $closedOrderResult
      ];

      $html = $this->renderer->render('Orderpage', $data);
      $this->response->setContent($html);
   }

   public function create() {

      $user = $this->session->getValue('userName');

      $accType = $this->session->getValue('accType');

      $accType = $this->session->getValue('accType');
      if (is_null($accType)) {
         throw new PermissionException("Must be logged in to create order");
      }

   $newOrderQueryStr = "INSERT INTO Orders (customer_userName, chef_userName, orderdate, cookeddate, paymentStatus, cookedStatus) VALUES('$user ', 'chef1', now(), NULL, 'open', 'open')";
   $newOrderQueryResult = $this->dbProvider->insertQuery($newOrderQueryStr);

   if (!$newOrderQueryResult) { 
      throw new SQLException("Failed to create order");
   }

}

public function addMenuItem() {
   $menuName = trim($this->request->getParameter('menu-name'));
   $orderid = trim($this->request->getParameter('order-id'));

   $accType = $this->session->getValue('accType');
   if (is_null($accType)) {
      throw new PermissionException("Must be logged in to add menuitem to order");
   }

   if (is_null($menuName) || strlen($menuName) == 0 || is_null($orderid) || strlen($orderid) == 0 ||
      !ctype_digit($orderid)) {
      throw new InvalidArgumentException("required form input missing. Invalid menu item name or order Id.");
}

$validateQueryStr = "SELECT * FROM Contains WHERE name = '$menuName' AND order_id = '$orderid'";   
$validateResult = $this->dbProvider->selectQuery($validateQueryStr);

if (empty($validateResult)) {
   $addQueryStr = "INSERT INTO Contains (order_id, name, qty) VALUES('$orderid', '$menuName', '1')"; 
   $addResult = $this->dbProvider->insertQuery($addQueryStr);

   if (!$addResult) {
      throw new SQLException("Failed to add item into order ");
   }
} 
else {
   throw new MissingEntityException("Item already in Order!");
}
}

public function updateMenuItemQuantity() {
   $menuName = trim($this->request->getParameter('menu-name'));
   $orderid = trim($this->request->getParameter('order-id'));

   $accType = $this->session->getValue('accType');
   if (is_null($accType)) {
      throw new PermissionException("Must be logged in to update menuitem in order");
   }

   if (is_null($menuName) || strlen($menuName) == 0 || is_null($orderid) || strlen($orderid) == 0 ||
      !ctype_digit($orderid)) {
      throw new InvalidArgumentException("required form input missing. Invalid menu item name or order Id.");
}

$validateQueryStr = "SELECT * FROM Contains WHERE name = '$menuName' AND order_id = '$orderid'";   
$validateResult = $this->dbProvider->selectQuery($validateQueryStr);

if (!empty($validateResult)) {
   $updateQueryStr = "UPDATE Contains SET qty = '$newItemQuantity' WHERE order_id = '$orderid' AND name = '$menuName'";
   $updated = $this->dbProvider->updateQuery($updateQueryStr);

   if (!$updated) {
      throw new SQLException("Failed to update item $menuName in order $orderid with quantity of $newItemQuantity ");
   }
} else {
   throw new MissingEntityException("Item not in Order, quantity cannot be changed!");
}
}

public function removeMenuItem() {
   $menuName = trim($this->request->getParameter('menu-name'));
   $orderid = trim($this->request->getParameter('order-id'));

   $accType = $this->session->getValue('accType');
   if (is_null($accType)) {
      throw new PermissionException("Must be logged in to remove menuitem from order");
   }

   if (is_null($menuName) || strlen($menuName) == 0 ||
      is_null($orderid) || strlen($orderid) == 0 ||
      !ctype_digit($orderid)) {
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
} else {
   throw new MissingEntityException("Unable to find item $menuName in Order $orderid to delete");
}
}

public function purchase()
{
   $orderId = trim($this->request->getParameter('order-id'));
   $paymentType = trim($this->request->getParameter('payment-type'));

   $accType = $this->session->getValue('accType');
   if (is_null($accType)) {
      throw new PermissionException("Must be logged in to purchase order");
   }

   $userName = $this->session->getValue('userName');
   if (is_null($userName)) {
      throw new PermissionException("Must be logged in to purchase order");
   }

   //retrieves price of order by $orderId and gives price 10% discount of customer ordered the same item more than once
   $priceQuery = "SELECT SUM(Case When c.qty >= 2 Then m.price * c.qty * 0.9 ELSE m.price * c.qty END) as price 
   FROM orders o, contains c, menuitem m WHERE o.order_id = '".$orderId."' 
   AND o.order_id = c.order_id AND c.name = m.name AND o.paymentStatus != 'paid' AND o.customer_userName = '".$userName."'";
   $price = $this->dbProvider->selectQuery($priceQuery);

   //check if there are enough qty in menuitems for purchase
   $check_avai = $this->dbProvider->selectQuery("SELECT m.name FROM menuitem m, contains c WHERE m.name = c.name AND c.order_id = '".$orderId."' AND m.quantity - c.qty >= 0");

   //updates qty in menuitems
   $del_qty_sql = ("UPDATE menuitem m, contains c SET m.quantity= m.quantity - c.qty WHERE m.name = c.name AND c.order_id = '".$orderId."' AND m.quantity - c.qty >= 0");

   //create invoice
   $create_invoice_sql = "INSERT INTO Invoice VALUES ('".$orderId."', '".$userName."', '".$price."', now(), '".$paymentType."')";

   //soft deletes order from order table
   $del_order_sql = "UPDATE Orders SET status = 'paid' WHERE order_id = '".$orderId."'";

   if($check_avai->num_rows > 0) {
      $del_order_query = $this->dbProvider->updateQuery($del_order_sql);
      if ($del_order_query){
         $create_invoice_query = $this->dbProvider->insertQuery($create_invoice_sql);
         if ($create_invoice_query){
            $del_qty_query = $this->dbProvider->updateQuery($del_qty_sql);
            $del_order_query = $this->dbProvider->updateQuery($del_order_sql);

            if (!$del_qty_query){
               throw new SQLException("Order was not paid for");
            }
         }
         else {
            throw new SQLException("Error creating invoice");
         }  
      }
      else throw new SQLException("Error deleting order");
   }
   else throw new SQLException("Not enough quantity, please change your order");
   
}

}