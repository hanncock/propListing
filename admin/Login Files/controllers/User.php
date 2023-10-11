<?php
    require_once(__DIR__ .'/../Db.php');

    class User extends Db
    {
        protected $dbstmt;

        public function __construct()
        {
            parent::__construct();
        }

        function checkUser($user) 
        {
            $query = "SELECT * FROM users WHERE `username` = :user";
            
            $this->dbstmt = $this->dbhandler->prepare($query);
            $this->dbstmt->bindParam(':user', $user);
            $this->dbstmt->execute();

            $results = $this->dbstmt->fetch(PDO::FETCH_ASSOC);
            
            if($results)
            {
                return $response = array(
                    'status' => true,
                    'data' => $results
                );
            }
            else
            {
                return $response = array(
                    'status' => false,
                    'data' => 'No record found!'
                );
            }
        }

        public function register($arg1, $arg2) 
        {
            // add user
            $username = htmlspecialchars(stripcslashes($arg1));
            $pass = password_hash((htmlspecialchars(stripcslashes($arg2))), PASSWORD_BCRYPT);
            
            $isExisting = $this->checkUser($username);
            if($isExisting['status'] === true) 
            {
                return $response = array(
                    'status' => false,
                    'message' => "This username is already taken!"
                );
            }

            $query = "INSERT INTO users(`username`, `password`) VALUES(:username, :password)";
            $this->dbstmt = $this->dbhandler->prepare($query);
            $this->dbstmt->bindParam(':username', $username);
            $this->dbstmt->bindParam(':password', $pass);

            if($this->dbstmt->execute())
            {
                $response = array(
                    'status' => true,
                    'message' => "user created successfully."
                );

                return $response;
            }
            else
            {
                $response = array(
                    'status' => false,
                    'message' => "Unable to create user."
                );

                return $response;
            }
        }

        public function login($arg1, $arg2) {
            // login and token generation
            $username = htmlspecialchars(stripcslashes($arg1));
            $pass = htmlspecialchars(stripcslashes($arg2));

            $isExisting = $this->checkUser($username);
            $verify_pass = password_verify($pass, $isExisting['data']['password']);

            if($isExisting['status'] === true &&  $verify_pass === true)
            {
                $generated_token = bin2hex(random_bytes(10));
                return $response = array(
                    'status' => true,
                    'user' => $isExisting['data']['username'],
                    'token' => $generated_token,
                    'message' => "Logged in successfully!"
                 );
            }
            else 
            {
                return $response = array (
                    'status' => false,
                    'message' => "Invalid username or password!"
                );
            }
            
        }
    }
    
?>