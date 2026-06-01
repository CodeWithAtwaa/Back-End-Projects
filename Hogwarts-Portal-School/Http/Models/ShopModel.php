<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class ShopModel
{
    private $db;
    public function __construct()
    {

        $this->db =  App::resolve(Database::class);
    }

    public function getAllItems()
    {
       return  $this->db->query( "SELECT * FROM DiagonAlleyShop
        ")->get();
    }
    public function  findItem($itemId)
    {
        return  $this->db->query( "SELECT * FROM DiagonAlleyShop
         where item_id = :item_id ", [
            'item_id' => $itemId
         ])->find();

    }
}
