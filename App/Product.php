<?php

namespace App;

use PDO;


class Product
{
    private int $id;
    private string $name;
    private float $price;

    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    // get functions

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getPrice(): float
    {
        return $this->price;
    }


    // to creat new product

    public static function creat(PDO $pdo,string $name ,float $price) : ?Product {

        $query=$pdo->prepare("INSERT INTo products(name,price) VALUS (?,?)");
        $order=$query->execute([$name,$price]);

        if($order){
            $id =(int)$pdo->lastInsertId();
            return new self($id,$name,$price);
        }

        return null;

        
    }

    // get all store products

    public static function getAllPrducts(PDO $pdo,):array
    {
        $query=$pdo->prepare("SELECT * FROM products");
        $rows=$query->fetchAll(PDO::FETCH_ASSOC);
        $products=[];
        foreach($rows as $row){
            // array to add new object in new index and prevent override
            $products[]=new Product($row['id'],$row['name'],$row['price']);
        }

        return $products;


    }
    public static function FindById(PDO $pdo,int $id):?Product
    {
        $query=$pdo->prepare("SELECT * FROM products where id=?");
        $query->execute([$id]);
        $row=$query->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            return new Product($row['id'],$row['name'],$row['price']);
        }

        return null;

    }
}
