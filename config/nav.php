<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.*',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'new',
        'active' => 'categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'products.index',
        'title' => 'Orders',
        'active' => 'orders.*',
        'ability' => 'orders.view',
    ],
    [
        'icon' => 'far fa-receipt nav-icon',
        'route' => 'products.index',
        'title' => 'Products',
        'active' => 'Products.*',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'far fa-shield nav-icon',
        'route' => 'roles.index',
        'title' => 'roles',
        'active' => 'roles.*',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'far fa-user nav-icon',
        'route' => 'users.index',
        'title' => 'users',
        'active' => 'users.*',
        'ability' => 'users.view',
    ],
    [
        'icon' => 'far fa-user nav-icon',
        'route' => 'admins.index',
        'title' => 'admins',
        'active' => 'admins.*',
        'ability' => 'admins.view',
    ],

];
