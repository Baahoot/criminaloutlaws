<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/* This links to the index page of the application, where users are redirected to either login or view their account */

class Ajax extends CI_Controller {

    public function indent($json)
    {
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;
        
        for ($i = 0; $i <= $strLen; $i++) {
            // Grab the next character in the string.
            $char = substr($json, $i, 1);
            
            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
                
                // If this character is the end of an element, 
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            
            // Add the character to the result string.
            $result .= $char;
            
            // If the last character was the beginning of an element, 
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }
                
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            
            $prevChar = $char;
        }
        
        return $result;
    }
    
    public function sync()
    {
        $this->benchmark->mark('code_start');
        $this->co->must_login();
        $this->co->allow_jail();
        $this->co->allow_hospital();
        $this->co->is_attack();
        $this->co->init();
        $ir = $this->co->whoami();
        
        header("Content-Type: text/javascript");
        
        if ($this->input->get('___sync_key___') != $this->co->get_session()) {
            echo json_encode(array(
                'result' => 'error',
                'error-msg' => 'sync-key-not-recognized'
            ));
            exit;
        }
        
        $ir = $this->co->__internal_user();
        unset($ir['exp_needed']);
        unset($ir['daysold']);
        
        $this->co->storage['me'] = $ir;
        $this->load->view('internal/ajax');
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */