<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Menu
{
    // properties
    private $db;
    private $name;
    private $price;
    private $category;
    private $info;
    private $id;

    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }
    // get menu
    public function getMenu(): array
    {
        // sql query
        $sql = "SELECT * FROM johans_menu ORDER BY category";
        $result = mysqli_query($this->db, $sql);
        // return array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    // get menu by its ID
    public function getMenuById(int $id): array
    { // sql query
        $id = intval($id);
        $sql = "SELECT * FROM johans_menu WHERE menu_id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    // get menu by category
    public function getMenuByCategory(string $category): array
    { // sql query
        $sql = "SELECT * FROM johans_menu WHERE category='$category';";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // set method with ID
    public function setDishWithID(int $id, string $name, int $price, string $info): bool
    {
        if (!$this->setName($name)) return false;
        if (!$this->setPrice($price)) return false;
        if (!$this->setInfo($info)) return false;
        // set ID and check input
        if ($id = intval($id)) {
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    // set methods
    public function setName(string $name): bool
    { // set NAME and check input
        $name = trim($name);
        if ($name != "") {
            $name = $this->db->real_escape_string($name);
            $name = strip_tags($name);
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }
    public function setPrice(int $price): bool
    { // set PRICE and check input
        $price = trim($price);
        if ($price != "") {
            $price = $this->db->real_escape_string($price);
            $price = strip_tags($price);
            $this->price = $price;
            return true;
        } else {
            return false;
        }
    }
    public function setCategory(string $category): bool
    { // set CATEGORY and check input 
        $category = trim($category);
        if ($category != "") {
            $category = $this->db->real_escape_string($category);
            $category = strip_tags($category);
            $this->category = $category;
            return true;
        } else {
            return false;
        }
    }
    public function setInfo(string $info): bool
    { // Set INFO and check input 
        $info = trim($info);
        if ($info != "") {
            $info = $this->db->real_escape_string($info);
            $info = strip_tags($info);
            $this->info = $info;
            return true;
        } else {
            return false;
        }
    }

    // save dish
    public function createDish(): bool
    {
        // sql query
        $sql = "INSERT INTO johans_menu (name, price, category, info)VALUES('" . $this->name . "', '" . $this->price . "', '" . $this->category . "',  '" . $this->info . "');";
        return mysqli_query($this->db, $sql);
    }

    // update dish
    public function updateDish(): bool
    {
        // sql query
        $sql = "UPDATE johans_menu SET name='$this->name', price='$this->price', info='$this->info' WHERE menu_id='$this->id';";
        return mysqli_query($this->db, $sql);
    }

    // delete dish
    public function deleteDish(int $id): bool
    { // sql query
        $id = intval($id);
        $sql = "DELETE FROM johans_menu WHERE menu_id=$id;";
        return mysqli_query($this->db, $sql);
    }

    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
