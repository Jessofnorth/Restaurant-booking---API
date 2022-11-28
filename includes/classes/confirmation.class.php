<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Confirmation
{
    // properties
    private $db;
    private $name;
    private $email;
    private $date;
    private $count;


    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // send email
    public function sendMail(string $name, string $email, int $count,  string $date): bool
    {
         // set propertys
     if (!$this->setEmail($email)) return false;
     if (!$this->setDate($date)) return false;
     if (!$this->setName($name)) return false;
     if (!$this->setCount($count)) return false;
        // create subject and content from variables
        $subject = "Tack för din bokning hos Johans Kök!";
        $content = "Välkommen till oss " . $this->name . "! Du har bokat plats för " . $this->count . " personer den " . $this->date . ". Dörrarna öppnar kl 17:30, välkommen! ";
        $to = $this->email;
        // add header to know who to respond
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: jeej2100@student.miun.se' . "\r\n" .
            'Reply-To: ' . $this->email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        // send email, return tru if sent, false if not 
        if (mail($to, $subject, $content, $headers)) {
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
    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
