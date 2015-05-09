<?php
class Pages{
    
    public static function page($user){
            $pages=array(
           'username'=>array(
               '<a href="logout" >Logout</a>',
               ' |<a href="login" >Login</a>',
               ' |<a href="members" >Our Members</a>',
               ' |<a href="cart" >Shopping Cart</a>'
           ),
           'guest'=>array(
               '<a href="logout" >Logout</a>',
               ' |<a href="login" >Login</a>',
               ' |<a href="addmember" >Become Member</a>',
           )
       
        );
        
        return $pages[$user];

    }
    
}

?>