<?php

use Illuminate\Support\Facades\Input;
use App\User;

Route::get('/', function () {
    return view('welcome');
});
//aa
Route::get('aa', 'PayPalController@aa')->name('aa');
Route::get('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');

// Execute

Route::any('execute', 'PayPalController@execute');

// search 
Route::any('producutsearch', 'Searchcontroller@producutsearch');



Route::any('/search', function () {
   $q = Input::get('q');
  
   if($q != ""){
   
     $user =User::where('name','Like', "%" . $q . "%")
                    ->orwhere('email','Like', "%" . $q . "%")
                    ->get();
    
                    if(count($user)>0){
                              
                        return view('producutsearch')->withDetails($user)->withQuery($q);
                    }
                   
                   
   }
   return view('producutsearch')->withMessage("no user data");
});
