<?php


class Review
{
    public $id;
    public $name;
    public $date;
    public $description;
    public $stars;
    public $user_id;
    public $product_id;

    public function __construct()
    {
        settype($this->id, 'integer');
        settype($this->product_id, 'integer');
        settype($this->user_id, 'integer');
    }
}