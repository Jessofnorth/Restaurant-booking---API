<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Mail
{
    // properties
    private $email;
    private $message;
    private $name;
    private $db;


    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // send email
    public function sendMail(string $name, string $email, string $message) : bool
    {
        // set propertys
        $to = "jeej2100@student.miun.se";
        if (!$this->setEmail($email)) return false;
        if (!$this->setMessage($message)) return false;
        if (!$this->setName($name)) return false;
        // add header to know who to respond
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $this->email . "\r\n" .
            'Reply-To: ' . $this->email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        // send email, return tru if sent, false if not 
        if (mail($to, $this->name, $this->message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    // set methods
    // set email, phone and message and check these inputs
    public function setEmail(string $email): bool
    {
        $email = trim($email);
        if ($email != "") {
            $email = $this->db->real_escape_string($email);
            $email = strip_tags($email);
            filter_var($email, FILTER_VALIDATE_EMAIL);
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    public function setName(string $name): bool
    {
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
    public function setMessage(string $message): bool
    {
        $message = trim($message);
        if ($message != "") {
            $message = $this->db->real_escape_string($message);
            $message = strip_tags($message);
            $this->message = $message;
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
