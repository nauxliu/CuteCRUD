<?php  namespace App\Http\FormComponents; 

use Exception;
use \Illuminate\Validation\Validator;

class ValidationFailException extends Exception{
    /**
     * The failed Validator
     * @var Validator;
     */
    private $validator = NULL;

    /**
     * Set a Validator
     *
     * @author Xuan
     * @param Validator $v
     */
    public function setValidator(Validator $v){
        $this->validator = $v;
    }

    /**
     * Get The Failed Validator
     *
     * @author Xuan
     * @return Validator
     */
    public function getValidator(){
        return $this->validator;
    }
}