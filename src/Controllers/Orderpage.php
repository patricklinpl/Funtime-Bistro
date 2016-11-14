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

      $data = [];
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

   }

   public function purchase()
   {
      $orderId = trim($this->request->getParameter('order-id'));
      $paymentType = trim($this->request->getParameter('payment-type'));

      $accType = $this->session->getValue('accType');
      if (is_null($accType)) {
         throw new PermissionException("Must be logged in to purchase order");
      }



   }
}