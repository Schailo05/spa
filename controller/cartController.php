<?php

class CartController
{

    private $cart;


    public function __construct()
    {
        $this->cart = new Cart();
    }



    public function index()
    {

        $services = $this->cart->getCart();

        $total = $this->cart->total();


        require_once __DIR__.'/../views/cart/index.php';

    }



   public function add()
{

    if(!isset($_SESSION['user'])){

        header("Location: index.php?action=login");
        exit();

    }


    $_SESSION['cart'][] = [

        "id" => $_POST['service_id'],
        "nom" => $_POST['nom'],
        "prix" => $_POST['prix'],
        "image" => $_POST['image']

    ];


    header("Location:index.php?action=cart");
    exit();

}



    public function remove()
    {

        $id = $_GET['id'];


        $this->cart->remove($id);


        header("Location:index.php?action=cart");

        exit;

    }

}