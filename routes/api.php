<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Use App\Project;
 
Route::get('projects', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Project::all();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login' , 'Api\UserCon@ApiLogin');
Route::post('/register' , 'Api\UserCon@ApiRegister');


/*                  Category
get  >>>   http://127.0.0.1:8000/api/category
*/
Route::resource('category' , 'Api\CategoryController');
Route::post('category/{id}' , 'Api\CategoryController@update');
/*                           */


/*            Product
get  >>> http://127.0.0.1:8000/api/product  [show all product]
post >>> http://127.0.0.1:8000/api/product  [add product]
get  >>> http://127.0.0.1:8000/api/product/11  [show product data]

  */
Route::middleware('auth:api')->resource('product' , 'Api\ProductController');
Route::middleware('auth:api')->post('product/{id}' , 'Api\ProductController@update');
Route::middleware('auth:api')->post('productImages' , 'Api\ProductController@addProductImages');
Route::middleware('auth:api')->delete('productImages/{product_id}' , 'Api\ProductController@destroyProductImage');
/*                           */

/*               ticket
get  >>> http://127.0.0.1:8000/api/ticket [show all countTicket groub by product_id]
post >>> http://127.0.0.1:8000/api/ticket [add ticket ] // data [user_id , product_id]
get >>> http://127.0.0.1:8000/api/ticket/12 [get ticket for specfic product_id]
get >>> http://127.0.0.1:8000/api/countTicket [show all countTicket groub by product_id foe user who is login]
  */
Route::middleware('auth:api')->resource('ticket' , 'Api\TicketController');
Route::middleware('auth:api')->get('countTicket' , 'Api\TicketController@countTickets');
/*                            */

/*             Following products
post   >>> http://127.0.0.1:8000/api/followProduct [add follow for product] // data [product_id]
delete >>> http://127.0.0.1:8000/api/followProduct/12 [un follow for product]
*/
Route::middleware('auth:api')->resource('followProduct' , 'Api\FollowingProdcutController');
/*                          */


/*             Following seller
post   >>> http://127.0.0.1:8000/api/followSeller  [follow user] // data [seller_id]
delete >>> http://127.0.0.1:8000/api/followSeller/14 [un follow user]

        */
Route::middleware('auth:api')->resource('followSeller' , 'Api\FollowingSellerController');
/*                          */


/*   Rank user */
Route::middleware('auth:api')->resource('rank' , 'Api\RankController');
/*   */












/*            Category
Route::get('category' , 'Api\CategoryController@index');
Route::post('category' , 'Api\CategoryController@store');
Route::get('category/{id}' , 'Api\CategoryController@show');
Route::post('category/{id}' , 'Api\CategoryController@update');
Route::delete('category/{id}' , 'Api\CategoryController@destroy');
*/

Route::get('test' , function(Request $request) {
return "s";
});
Route::post('sendNotify' , 'TestSend@sendNotify');