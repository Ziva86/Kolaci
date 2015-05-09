<?php

class Validation
{
    
    //Validation nambers
    public function onlyNambers($namber)
    {
        if(!preg_match('/^[0-9]+$/',$namber))
	{
	    return '<b class="error"> &nbsp;Only numbers.</b>';
	}
    }
    
    
    //Validate email
    public function onlyEmail($mail)
    {
        if(!preg_match('/^[a-z][a-z0-9._-]+@(\w+\.)+[a-z]{2,6}$/i',$mail))
	{
	   return '<b class="error"> &nbsp;Invalid email address</b>';
	}

    }
     
     //Validation Nambers and Strings
    public function onlyNambersAndStrings($data)
    {
        if(!preg_match('/^[a-z0-9,. ]+$/i',$data))
	{
	    return '<b class="error"> &nbsp;Name should only contain letters, numbers, spaces "," or "."</b>';
	}
    }


}


?>