<?php
class Validate{
    
    private $_passed=false,
            $_errors=array(),
            $_db=null;
            
    public function __construct(){
        $this->_db=DB::getInstance();
    }
    
    
    public function passed(){
        return $this->_passed;
    }
    
    
    private function addError($errors){
        foreach($errors as $error=>$key){
            $this->_errors[$error]=$key;
        }
    }
    
    
    public function errors(){
        return $this->_errors;
    }
    
    public function check($source,$itams=array()){
        
        foreach($itams as $item=>$rules){
            foreach($rules as $rule=>$rule_value){
                $value=$source[$item];
                
                if($rule==='require' && empty($value)){
                    $this->addError(array($item=>$rule));
                }elseif(!empty($value)){
                    switch($rule){
                        case 'min':
                            if(strlen($value)<$rule_value){
                                $this->addError(array($item=>"{$item} must be a minimum of {$rule_value} characters!"));
                            }
                        break;
                        case 'max':
                            if(strlen($value)>$rule_value){
                                $this->addError(array($item=>"{$item} must be a maximum of {$rule_value} characters!"));
                            }
                        break;
                        case 'valid_email':
                            if(!preg_match($rule_value,$value)){
                                $this->addError(array($item=>"{$item} is not valid!"));
                            }
                        break;
                        case 'valid_field':
                                if(!preg_match($rule_value,$value)){
                                $this->addError(array($item=>"{$item} is not valid!"));
                            }
                        break;
                        case 'equal':
                                if(strlen($value)<>$rule_value){
                                $this->addError(array($item=>"{$item} must have {$rule_value} digits!"));
                            }
                        break;
                        case 'matches':
                                if($value !=$source[$rule_value]){
                                $this->addError(array($item=>"{$item} must match {$rule_value}!"));
                            }
                        break;
                        case 'unique':
                            $check=$this->_db->get($rule_value,array($item,'=',$value));
                            if($check->count()){
                                $this->addError(array($item=>"{$item} alredy exists."));
                            }
                            
                        break;
                    

                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed=true;
        }
        
        return $this;
        
    }
    
    
}






?>