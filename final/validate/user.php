<?php
namespace validate;

require_once __DIR__. DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR. "vendor" . DIRECTORY_SEPARATOR ."autoload.php";

use think\Validate;

class User extends Validate
{
    protected $rule =   [
        'email'    => 'email',
        'password' => 'require|max:20|min:5',  
    ];
    
    protected $message  =   [
        'email'            => 'Mailbox format error',  
        'password.require' => 'Password required',
        'password.max'     => 'Password cannot exceed 20 characters',
        'password.min'     => 'Password is less than 5 characters', 
    ];
    
}