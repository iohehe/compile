<?php

class SimpleLexer{
    private $token_content = '';
    private $token = array();
    private $tokens = array();

    //token
    const Token_Plus = 'Plus'; // +
    const Token_Assignment = 'Assignment'; // =
    const Token_Identifier = 'Identifier'; //整型
    const Token_Int = 'Int';

    //state
    const STATE_Initial = 'Initial';
    const STATE_Plus = 'Plus';
    const STATE_IntLiteral = 'IntLiteral';
    const STATE_Assignment = 'Assignemnt';
    const STATE_Int = 'Int';
    const STATE_ID_int1 = 'Id_int1';
    const STATE_ID_int2 = 'Id_int2';
    const STATE_ID_int3 = 'Id_int3';
    const STATE_ID = 'Id';

    /**
     *
     * 有限状态机判断
     * @param $ch
     * @return string
     */
    public function initToken($ch){
        $new_state = self::STATE_Initial;
        if (is_numeric($ch))
        {
            $new_state = self::STATE_IntLiteral;
            $this->token['type'] = self::Token_Identifier;
            $this->token['content'] = $ch;
            $this->tokens[] = $this->token;
        }
        else if(preg_match('/[a-zA-Z]/' ,$ch))
        {
            if ($ch == 'i')
            {
                $new_state = self::STATE_ID_int1;
            }
            else
            {
               $new_state = self::STATE_ID;
            }
            $this->token['type'] = self::Token_Identifier;
            $this->token['content'] = $ch;
        }
        else if ($ch === '+')
        {
            $new_state = self::STATE_Plus;
            $this->token['type'] = self::Token_Plus;
            $this->token['content'] = $ch;
            $this->tokens[] = $this->token;
        }
        return $new_state;
    }


    /**
     *
     * @param $code
     */
    public function tokenize($code){
        // init
        $this->token_content = '';
        $this->token = array();
        $this->tokens = array();
        $state = self::STATE_Initial;

        $code_strings = str_split($code);

        foreach ($code_strings as $ch)
        {
            switch ($state)
            {
                case self::STATE_Initial:
                    $state = $this->initToken($ch);
                    break;

                case self::STATE_ID_int1:
                    if ($ch == 'n')
                    {
                       $state = self::STATE_ID_int2;
                    }
                    else
                    {
                        $state = self::STATE_ID;
                    }
                    break;

                case self::STATE_ID_int2:
                    if ($ch == 't')
                    {
                        $state = self::STATE_ID_int3;
                    }
                    else
                    {
                        $state = self::STATE_ID;
                    }
                    break;

                case self::STATE_ID_int3:
                    if (preg_match('/\s/',$ch))
                    {
                        $state = self::STATE_Int;
                    }
                    else
                    {
                        $state = self::STATE_ID;
                    }
                    break;
            }
        }
    }

    /**
     * 入口
     * @param $str
     */
    public function main($str){
        echo "{$str}: ";
        $this->tokenize($str);
        var_dump($this->tokens);
    }
}

$lexer = new SimpleLexer();
//$lexer->main('1+2');
$lexer->main("int a");
?>
