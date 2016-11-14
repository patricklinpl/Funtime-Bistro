<?php declare(strict_types = 1);

namespace ProjectFunTime\Menu;

class ArrayMenuReader implements MenuReader
{
   public function readMenu($accType) : array
   {
      if (is_null($accType)) {
         return [];
      }
      elseif (strcasecmp($accType, 'customer') == 0) {
         return [
            ['href' => '#', 'text' => 'Menu',
             'children' => [['href' => '/menuItems', 'text' => 'View'],
                            ['href' => '/menuItem/search', 'text' => 'Search']]],
            ['href' => '/orders', 'text' => 'Orders'],
            ['href' => '/ingredients', 'text' => 'Ingredients'],
            ['href' => '/account', 'text' => 'Account']
         ];
      }
      elseif (strcasecmp($accType, 'chef') == 0 ||
              strcasecmp($accType, 'admin') == 0) {
         return [
            ['href' => '#', 'text' => 'Menu',
             'children' => [['href' => '/menuItems', 'text' => 'View'],
                            ['href' => '/menuItem/search', 'text' => 'Search'],
                            ['href' => '/menuItem/create', 'text' => 'Create']]],
            ['href' => '/orders', 'text' => 'Orders'],
            ['href' => '/ingredients', 'text' => 'Ingredients'],
            ['href' => '/account', 'text' => 'Account']
         ];
      }
   }
}