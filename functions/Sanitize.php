<?php

function escape($string,$type = 'string')
{

    switch ($type) {
        case 'string':
        case 'text':
            return filter_var($string,FILTER_SANITIZE_STRING);
            break;

        case 'number':
        case 'integer':
            return filter_var($string,FILTER_SANITIZE_NUMBER_INT);
            break;
            
        case 'email':
            return filter_var($string,FILTER_SANITIZE_EMAIL);
            break;
        
        
        
        default:
        return filter_var($string,FILTER_SANITIZE_SPECIAL_CHARS);
            break;
    }
    

   
}