<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// default : $lang_code_list = array('id','jp','en','fr','zh');
$lang_code_list = array('id', 'en');


$route['default_controller'] = 'home';
$route['proweb'] = 'proweb/login';
$route['proweb/timeoperation'] = 'Time_operation/index';
$route['proweb/holiday_checkout'] = 'Holiday_checkout/index';
$route['proweb/login'] = 'proweb/login/process';

$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;

$connection = mysqli_connect('localhost', 'root', '', 'db_udfantasy'); //$connection = mysqli_connect('159.65.132.116', 'bayu', 'B4yU(*#!3431Sdf', 'ud_fantasy');
//$connection = mysqli_connect('localhost', 'fantasyonline_main_user', 'Z*!tX]d^d,%D', 'fantasyonline_db_front');
$product_category = mysqli_query(
    $connection,
    "SELECT products.id, products.title, products.slug, products_category.slug AS category_slug
            FROM products 
            INNER JOIN products_category ON products_category.id = products.id_products_category
            WHERE products.id_products_sub_category = 0 OR products.id_products_sub_category = NULL"
);

$product_sub_category = mysqli_query(
    $connection,
    "SELECT products.id, products.title, products.slug, products_category.slug AS category_slug, 
            products_sub_category.slug AS sub_category_slug
            FROM products 
            INNER JOIN products_category ON products_category.id = products.id_products_category
            INNER JOIN products_sub_category ON products_sub_category.id = products.id_products_sub_category
            WHERE products.id_products_sub_category != 0 OR products.id_products_sub_category != NULL"
);

$category = mysqli_query(
    $connection,
    "SELECT products_category.slug as category_slug
            FROM products_category"
);

$sub_category = mysqli_query(
    $connection,
    "SELECT products_category.slug AS category_slug, products_sub_category.slug AS sub_category_slug
            FROM products_sub_category
            INNER JOIN products_category ON products_category.id = products_sub_category.id_parent_category"
);


while ($data_category = mysqli_fetch_array($category)) {
    foreach ($lang_code_list as $code) {
        $route[$code . '/produk/' . $data_category['category_slug']] = 'products/index/' . $data_category['category_slug'];
        $route[$code . '/produk/' . $data_category['category_slug'] . '/(:num)'] = 'products/index/' . $data_category['category_slug'];
    }
}

while ($data_sub_category = mysqli_fetch_array($sub_category)) {
    foreach ($lang_code_list as $code) {
        $route[$code . '/produk/' . $data_sub_category['category_slug'] . '/' . $data_sub_category['sub_category_slug']] = 'products/index/' . $data_sub_category['category_slug'] . '/' . $data_sub_category['sub_category_slug'];
        $route[$code . '/produk/' . $data_sub_category['category_slug'] . '/' . $data_sub_category['sub_category_slug'] . '/(:num)'] = 'products/index/' . $data_sub_category['category_slug'] . '/' . $data_sub_category['sub_category_slug'];
    }
}

while ($data_category = mysqli_fetch_array($product_category)) {
    foreach ($lang_code_list as $code) {
        $route[$code . '/produk/' . $data_category['category_slug'] . '/' . $data_category['slug']] = 'products/detail/' . $data_category['slug'];
    }
}

while ($data_sub_category = mysqli_fetch_array($product_sub_category)) {
    foreach ($lang_code_list as $code) {
        $route[$code . '/produk/' . $data_sub_category['category_slug'] . '/' . $data_sub_category['sub_category_slug'] . '/' . $data_sub_category['slug']] = 'products/detail/' . $data_sub_category['slug'];
    }
}

foreach ($lang_code_list as $code) {

    $route[$code . '/tidak-ditemukan'] = 'not_found';

    $route[$code . '/tentang-kami'] = 'about_us';
    //    $route['daftar-harga'] = 'price_list';
    $route[$code . '/frequently-asked-question'] = 'faq';
    $route[$code . '/syarat-ketentuan'] = 'terms_condition';
    $route[$code . '/contact-us'] = 'contact_us';
    $route[$code . '/contact-us/send'] = 'contact_us/send';
    $route[$code . '/about-us'] = 'about_us';

    /**
     * Shop
     */
    $route[$code . '/produk'] = 'products/index';
    $route[$code . '/produk/(:num)'] = 'products/index';
    $route[$code . '/produk/review/(:any)'] = 'products/review/$1';
    $route[$code . '/produk/cart/(:any)/(:any)'] = 'cart/addto_cart/$1/$2';
    $route[$code . '/produk/cart-update'] = 'cart/cart_update';
    $route[$code . '/produk/cart-list'] = 'cart/index';
    $route[$code . '/produk/cart-remove-row/(:any)'] = 'cart/remove_row/$1';
    $route[$code . '/produk/cart-remove-all-row'] = 'cart/remove_all_row';
    $route[$code . '/produk/cart-total-price'] = 'cart/cart_total_price';
    $route[$code . '/produk/cart-get-item/(:num)'] = 'cart/get_item/$1';
    $route[$code . '/produk/checkout'] = 'checkout/index';
    $route[$code . '/produk/checkout-process'] = 'checkout/checkout_process';
    $route[$code . '/produk/checkout-payment/(:any)'] = 'checkout/checkout_payment/$1';
    $route[$code . '/produk/cancel-order/(:any)'] = 'user_transaction/cancel_order/$1';
    $route[$code . '/produk/accept-order/(:any)'] = 'user_transaction/accept_order/$1';

    $route[$code . '/cart'] = 'Cart';
    $route[$code . '/checkout'] = 'Checkout';

    $route[$code . '/login'] = 'login';
    $route[$code . '/logout'] = 'logout';
    $route[$code . '/signup'] = 'signup';
    $route[$code . '/signup/create'] = 'signup/create_member';
    $route[$code . '/signup/signup_verification'] = 'signup/verification';
    $route[$code . '/user-profile'] = 'user_profile/index/$1';
    $route[$code . '/user-profile/(:num)'] = 'user_profile/index/$1';
    $route[$code . '/user-profile/biodata/update'] = 'user_profile/biodata';
    $route[$code . '/user-profile/address/add'] = 'user_address/add_address';
    $route[$code . '/user-profile/address/edit'] = 'user_address/update_address';
    $route[$code . '/user-profile/send-reset-password/(:any)'] = 'user_reset_password/send_reset_password/$1';
    $route[$code . '/user-profile/reset-password/(:any)/(:any)'] = 'user_reset_password/form_reset_password/$1/$2';
    $route[$code . '/user-profile/process-reset-password'] = 'user_reset_password/process_reset_password';

    $route[$code . '/404_override'] = 'not_found';

    $route['^' . $code . '/(.+)$'] = "$1";
    $route['^' . $code . '$'] = $route['default_controller'];
}

function slug($string)
{
    $find = array(' ', '/', '&', '\\', '\'', ',', '(', ')');
    $replace = array('-', '-', 'and', '-', '-', '-', '', '');

    $slug = str_replace($find, $replace, strtolower($string));

    return $slug;
}
