<?php
use  Plugin_Name_Dir\Includes\Functions\Tsb_Telegram;
$input = file_get_contents('php://input');
if ($input)
{
    $telegram_input_handler=new Tsb_Telegram($input);

}