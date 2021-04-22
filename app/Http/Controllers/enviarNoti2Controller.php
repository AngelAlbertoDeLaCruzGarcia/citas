<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
final class enviarNoti2Controller extends Controller
{
    private $sender;
    public function __construct( Sender $sender)
    {
        $this->sender = $sender;
    }
    public function send()
    {
        $message = 'Click en el sig link: '.route('enviarNoti2',['code'=> Str::random(8)]);
        try{

        }catch(Exception $e){
            dd($e->getMessage());
        }

    }
}
