<?php

class Cart
{

    public function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }


    public function add($service)
    {

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = $service;

    }


    public function remove($index)
    {

        if(isset($_SESSION['cart'][$index])){

            unset($_SESSION['cart'][$index]);

            $_SESSION['cart'] = array_values($_SESSION['cart']);

        }

    }


    public function total()
    {

        $total = 0;

        foreach($this->getCart() as $item){

            $total += $item['prix'];

        }

        return $total;

    }

}