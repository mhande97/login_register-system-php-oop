<?php

function escape($string)
{
    return filter_var($string,FILTER_SANITIZE_STRING);
   
}