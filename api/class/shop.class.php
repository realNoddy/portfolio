<?php

class Shop {
    private $products;
    private $db;

    function __construct($db){
        if ($db == null or !$db->is_connected()){ return; }
        $this->db = $db;
        $this->products = $this->get_products_from_db($this->db);
    }

    private function get_products_from_db():array{
        return $this->db->sql_execute("SELECT * FROM product WHERE `count` > 0;");
    }

    public function get_products():array{
        return $this->products;
    }

    public function buy_product($user_id, $product_id){
        // todo SQL INSERT INTO orders + UPDATE product SET count -= 1
    }
}