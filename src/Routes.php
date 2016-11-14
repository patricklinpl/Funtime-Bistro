<?php declare(strict_types = 1);

// can remove param from route for POST
return [

// home
    ['GET', '/', ['ProjectFunTime\Controllers\Homepage', 'show']],
    ['POST', '/signout', ['ProjectFunTime\Controllers\Homepage', 'signout']],

// login page
    ['GET', '/login', ['ProjectFunTime\Controllers\Loginpage', 'show']],
    ['POST', '/login', ['ProjectFunTime\Controllers\Loginpage', 'login']],
    ['POST', '/account/customer/create', ['ProjectFunTime\Controllers\Loginpage', 'createAccount']],

// menu page
    ['GET', '/menuItems', ['ProjectFunTime\Controllers\Menupage', 'showAllMenuItems']],
    ['POST', '/menuItem/create', ['ProjectFunTime\Controllers\Menupage', 'create']],
    ['POST', '/menuItem/update', ['ProjectFunTime\Controllers\Menupage', 'update']],
    ['POST', '/menuItem/delete', ['ProjectFunTime\Controllers\Menupage', 'delete']],

// ingredient page
    ['GET', '/ingredients', ['ProjectFunTime\Controllers\Ingredientpage', 'show']],
    ['POST', '/ingredient/create', ['ProjectFunTime\Controllers\Ingredientpage', 'create']],
    ['POST', '/ingredient/update', ['ProjectFunTime\Controllers\Ingredientpage', 'update']],
    ['POST', '/ingredient/delete', ['ProjectFunTime\Controllers\Ingredientpage', 'delete']],

// order page
    ['GET', '/orders', ['ProjectFunTime\Controllers\Orderpage', 'show']],
    ['POST', '/order/create', ['ProjectFunTime\Controllers\Orderpage', 'create']],
    ['POST', '/order/{id:\d+}/addMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'addMenuItem']],
    ['POST', '/order/{id:\d+}/updateMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'updateMenuItemQuantity']],
    ['POST', '/order/{id:\d+}/removeMenuItem{menuItemId:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'removeMenuItem']],
    ['POST', '/purchase/order/{id:\d+}', ['ProjectFunTime\Controllers\Orderpage', 'purchase']],

// account page
    ['GET', '/account', ['ProjectFunTime\Controllers\Accountpage', 'show']],
    ['POST', '/account/update', ['ProjectFunTime\Controllers\Accountpage', 'update']],
    ['GET', '/account/chef/all', ['ProjectFunTime\Controllers\Accountpage', 'showAllChefAccounts']],
    ['GET', '/account/chef/create', ['ProjectFunTime\Controllers\Accountpage', 'showCreateChefForm']],
    ['POST', '/account/chef/create', ['ProjectFunTime\Controllers\Accountpage', 'createChefAccount']],
    ['GET', '/account/chef/edit/{username}', ['ProjectFunTime\Controllers\Accountpage', 'showEditChefForm']],
    ['POST', '/account/chef/update', ['ProjectFunTime\Controllers\Accountpage', 'updateChefAccount']],
    ['POST', '/account/chef/delete', ['ProjectFunTime\Controllers\Accountpage', 'deleteChefAccount']],

];