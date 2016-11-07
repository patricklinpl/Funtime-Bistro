<?php declare(strict_types = 1);

namespace ProjectFunTime\Menu;

class ArrayMenuReader implements MenuReader
{
   public function readMenu() : array
   {
      return [
         ['href' => '/menuItems', 'text' => 'Menu'],
         ['href' => '/ingredients', 'text' => 'Ingredients'],
         ['href' => '/orders', 'text' => 'Orders'],
         ['href' => '/account/all', 'text' => 'Accounts']
      ];
   }
}