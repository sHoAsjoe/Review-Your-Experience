<?php

/*
 * this is the class Category. You can add functions and variables for your categories.
 */
class Category
{
    //these are the variables for the category. Make sure these are the same as in your database.
    public $id;
    public $name;
    public $picture;

    //the constructor a function that will run if we make an object.
    public function __construct()
    {
        //this ensures that the id is an integer.
        settype($this->id, 'integer');
    }
}