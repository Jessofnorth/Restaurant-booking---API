<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Booking
{
    // properties
    private $db;
    private $name;
    private $phone;
    private $email;
    private $date;
    private $message;
    private $count;
    private $id;

    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }
    // get booking
    public function getBooking(): array
    {
        // sql query
        $sql = "SELECT * FROM johans_booking ORDER BY date";
        $result = mysqli_query($this->db, $sql);
        // return array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    // get booking by its ID
    public function getBookingById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM johans_booking WHERE booking_id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }
    // get bookings from specific date and forward
    public function getBookingFromDate(string $date): array
    {
        $sql = "SELECT * FROM johans_booking WHERE date>='$date' ORDER BY date;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // set method with ID
    public function setBookingWithID(int $id, string $name, string $phone, string $email, string $date, string $message, int $count): bool
    {
        if (!$this->setName($name)) return false;
        if (!$this->setPhone($phone)) return false;
        if (!$this->setEmail($email)) return false;
        if (!$this->setMessage($message)) return false;
        if (!$this->setDate($date)) return false;
        if (!$this->setCount($count)) return false;
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
    { // Set NAME and check input 
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
    public function setPhone(string $phone): bool
    { // Set PHONE and check input 
        $phone = trim($phone);
        if ($phone != "") {
            $phone = $this->db->real_escape_string($phone);
            $phone = strip_tags($phone);
            $this->phone = $phone;
            return true;
        } else {
            return false;
        }
    }
    public function setEmail(string $email): bool
    { // Set EMAIL and check input 
        $email = trim($email);
        if ($email != "") {
            $email = $this->db->real_escape_string($email);
            $email = strip_tags($email);
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }

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
    public function setMessage(string $message): bool
    {
        // Set MESSAGE and check input 
        $message = trim($message);
        $message = $this->db->real_escape_string($message);
        $message = strip_tags($message);
        $this->message = $message;
        return true;
    }
    public function setCount(string $count): bool
    {
        // Set COUNT and check input 
        $count = trim($count);
        if ($count != "") {
            $count = intval($count);
            $count = $this->db->real_escape_string($count);
            $count = strip_tags($count);
            $this->count = $count;
            return true;
        } else {
            return false;
        }
    }

    // save course
    public function createBooking(): bool
    {
        // sql query
        $sql = "INSERT INTO johans_booking (name, phone, email, date, message, count)VALUES('" . $this->name . "', '" . $this->phone . "', '" . $this->email . "',  '" . $this->date . "',  '" . $this->message . "',  '" . $this->count . "');";
        return mysqli_query($this->db, $sql);
    }

    // update course
    public function updateBooking(): bool
    {
        // sql query
        $sql = "UPDATE johans_booking SET name='$this->name', phone='$this->phone', email='$this->email', date='$this->date', message='$this->message', count='$this->count' WHERE booking_id='$this->id';";
        return mysqli_query($this->db, $sql);
    }

    // delete course
    public function deleteBooking($id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM johans_booking WHERE booking_id=$id;";
        return mysqli_query($this->db, $sql);
    }

    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
