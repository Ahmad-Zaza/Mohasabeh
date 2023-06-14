<?php

return [
    'AppName' => 'نظام المحاسبة',
    '_SITE' => 'http://localhost:8000/',
    'PREF' => "/accounting_system/",
    'Public_Folder' => "public/",
    'LANG'=> 'ar',
    'MOHASABEH_EMAIL'=>'info@cloudsellpos.com',
    'PAGINATIOM_LIMITATION' => '20',
    'MANAGERS_ROLES_IDS' => '1,2', //Super Admin, Manager
    'DELEGATES_ROLES_IDS' => '3,4,6', //Sales Manager , Delegate , Factory Delegate
    'ROLES_IDS_HAS_VOUCHER_PERMISSION' => '3,4,7', //Sales Manager , Delegate , Factory Cashier
    'DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES' => '4,6' ,//Delegate , Factory Delegate
    'Roles_IDS_HAS_VIEW_ALL_REPORTS_PERMISSION'=> '1,2,5' //superAdmin, Manager, Just View
];