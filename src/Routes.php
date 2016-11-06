<?php declare(strict_types = 1);

// can remove param from route for POST
return [

// home
    ['GET', '/', ['ProjectFunTime\Controllers\Homepage', 'show']],

// login page
    ['GET', '/login', ['ProjectFunTime\Controllers\Loginpage', 'show']],
    ['POST', '/login', ['ProjectFunTime\Controllers\Loginpage', 'login']],
    ['POST', '/account/customer/create', ['ProjectFunTime\Controllers\Loginpage', 'createAccount']],

// menu page
    ['GET', '/menuItems', ['ProjectFunTime\Controllers\Menupage', 'showAllMenuItems']],
    ['GET', '/menuItem/{id:\d+}', ['ProjectFunTime\Controllers\Menupage', 'showMenuItemById']],
    ['POST', '/menuItem/create', ['ProjectFunTime\Controllers\Menupage', 'create']],
    ['POST', '/menuItem/{id:\d+}/update', ['ProjectFunTime\Controllers\Menupage', 'update']],
    ['POST', '/menuItem/{id:\d+}/delete', ['ProjectFunTime\Controllers\Menupage', 'delete']],

// ingredient page
    ['GET', '/ingredients', ['ProjectFunTime\Controllers\Ingredientpage', 'show']],
    ['POST', '/ingredient/{id:\d+}/update', ['ProjectFunTime\Controllers\Ingredientpage', 'update']],
    ['POST', '/ingredient/{id:\d+}/delete', ['ProjectFunTime\Controllers\Ingredientpage', 'delete']],

// order page
    ['GET', '/orders', ['ProjectFunTime\Controllers\Orderpage', 'show']],
    ['POST', '/order/create', ['ProjectFunTime\Controllers\Orderpage', 'create']],
    ['POST', '/order/{id:\d+}/addMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'addMenuItem']],
    ['POST', '/order/{id:\d+}/updateMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'updateMenuItemQuantity']],
    ['POST', '/order/{id:\d+}/removeMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'removeMenuItem']],
    ['POST', '/purchase/order/{id:\d+}', ['ProjectFunTime\Controllers\Homepage', 'purchase']],

// account page
    ['GET', '/account/all', ['ProjectFunTime\Controllers\Accountpage', 'show']],
    ['POST', '/account/chef/create', ['ProjectFunTime\Controllers\Accountpage', 'create']],
    ['POST', '/account/{id:\d+}/chef/update', ['ProjectFunTime\Controllers\Accountpage', 'update']],
    ['POST', '/account/{id:\d+}/chef/delete', ['ProjectFunTime\Controllers\Accountpage', 'delete']],

];