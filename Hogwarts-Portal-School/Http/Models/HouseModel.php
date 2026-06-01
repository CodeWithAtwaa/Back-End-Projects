<?php

namespace Http\Models;
use Core\Database;
use Core\App;

class HouseModel
{
    private $db ;
    public function __construct()
    {
        $this->db=  App::resolve(Database::class);
    }
    public function GetHouses()
    {
       return  $this->db->query("select * from  House ")->get();
    }
}