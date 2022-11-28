<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se */
class Login
{
    // properties
    private $username;
    private $password;
    private $db;

    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }
    // register new user 
    public function createUser(string $username, string $password): bool
    {
        //  set username and password
        if (!$this->setUsername($username)) return false;
        if (!$this->setPassword($password)) return false;
        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        //  sql query
        $sql = "INSERT INTO johans_users (username, password)VALUES('$username', '$hashed_password');";
        return mysqli_query($this->db, $sql);
    }
    // login
    public function loginUser(string $username, string $password): bool
    {
        // set and  usename and password
        if (!$this->setUsername($username)) return false;
        if (!$this->setPassword($password)) return false;
        $sql = "SELECT * FROM johans_users WHERE username='$username';";
        $result = $this->db->query($sql);
        // check stored hashed pass against hashed entered pass
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_pass = $row['password'];
            // check password
            if (password_verify($password, $stored_pass)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    // set username
    public function setUsername(string $username): bool
    {
        // checkinput - security
        $username = $this->db->real_escape_string($username);
        $username = strip_tags($username);
        $username = trim($username);
        if (strlen($username)  > 4) {
            $this->username = $username;
            return true;
        } else {
            return false;
        }
    }
    // set password
    public function setPassword(string $password): bool
    {
        // checkinput - security
        $password = $this->db->real_escape_string($password);
        $password = strip_tags($password);
        $password = trim($password);
        if (strlen($password) > 7) {
            $this->password = $password;
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
