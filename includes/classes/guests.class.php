<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Guests
{
    // properties
    private $db;
    private $date;


    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // count number of guests on specific date
    public function countGuests(string $date): array
    {
        $sql = "SELECT sum(count) AS guests FROM johans_booking WHERE date='$date';";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }
    // set date
    public function setDate(string $date): bool
    {
        // Set DATE and check input 
        $date = trim($date);
        if ($date != "") {
            $date = $this->db->real_escape_string($date);
            $date = strip_tags($date);
            $this->date = $date;
            return true;
        } else {
            return false;
        }
    }


    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
