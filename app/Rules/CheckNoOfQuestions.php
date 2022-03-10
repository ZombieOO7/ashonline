<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckNoOfQuestions implements Rule
{
    protected $rows,$a,$col,$temp1,$temp2;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($rows,$a)
    {
        $this->rows = $rows;
        $this->a = $a;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rowCol = explode('.',$attribute);
        $row = $rowCol[0];
        $col = $rowCol[1];
        $this->col = $col;
        $this->temp1 = $attribute; $this->temp2 = $value;
        for($i = 1; $i <= count($this->rows); $i++ ){
            if($this->a== $row){
                if(!isset($this->rows[$this->a][3]) || $this->rows[$this->a][3] == null || is_int($this->rows[$this->a][1])==false){
                    return false;
                }else{
                    $this->a = $this->a + $this->rows[$this->a][1];
                    return true;
                }
            }else{
                return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $rowCol = explode('.',$this->temp1);
        $row = $rowCol[0];
        $col = $rowCol[1];
        return 'The no of sub question field was invalid in row '.$row.' and column '.$col.'.';
    }
}
