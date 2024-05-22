<?php
/*
 * In this file you will write all the code which uses the database.
 * This includes all the SQL statements and the form validation.
 */
function getCategories():array
{
    //$pdo is the connection to the database.
    global $pdo;
    /*
     * this will collect all the categories from the category table and makes objects from the category class.
     * check Category.php in the Classes folder.
     */
    $categories = $pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');
    //gives back all the category objects
    return $categories;
}

function getCategoryName(int $id):string
{

}
