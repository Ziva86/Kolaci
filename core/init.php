<?php
session_start();

//globalne promenljive
$GLOBALS['config']=array(
        'mysql'=>array(
                'host'=>'',
                'username'=>'',
                'password'=>'',
                'db'=>''
        ),
        'remember'=>array(
                'cookie_name'=>'hash',
                'cookie_expire'=>604800,
                'cart_expire'=>100
        ),
        'session'=>array(
                'session_name'=>'user',
                'token_name'=>'token',
                'cart_name'=>'cart'
        )
    );

//automatsko inicijalizacija klasa
spl_autoload_register(function($class){require_once('Model/'.$class.'.php');});


if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash=Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck=DB::getInstance()->get('users_session',array('hash','=',$hash));
    if($hashCheck->count()){
        $user=new User($hashCheck->first()->user_id);
        $user->login();
    }
    
    
}

function callback_rand() { 
  
  return rand() > rand();
  
}

?>