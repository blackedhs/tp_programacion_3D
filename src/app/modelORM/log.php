<?php  
namespace App\Models\ORM;
 
 use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class log extends \Illuminate\Database\Eloquent\Model {  
    public $timestamps=false;
    protected $table = 'log';
}
