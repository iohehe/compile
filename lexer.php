<?php

class SimpleLexer{
    private $token_content = '';
    private $token = array();
    private $tokens = array();

    //token
    const Token_Plus = 'Plus'; // +
    const Token_Identifier = 'Identifier'; //整型

    //state
    const STATE_Initial = 'Initial';
    const STATE_Plus = 'Plus';
    const STATE_IntLiteral = 'IntLiteral';

    /**
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
                    $this->initToken($ch);
                    break;
            }
        }
    }

    /**
     * @param $str
     */
    public function main($str){
        echo "{$str}: ";
        $this->tokenize($str);
        var_dump($this->tokens);
    }
}

$lexer = new SimpleLexer();
$lexer->main('1+2');
?>
