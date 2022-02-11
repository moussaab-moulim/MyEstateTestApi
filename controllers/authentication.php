<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

class Authentication
{
    private $conn;

    private $key = 'privatekey/moussaab';

    private $db_table = 'users';
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function auth()
    {
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            'iss' => 'https://my-estate-test-api.herokuapp.com/', //issuer
            'aud' => 'https://my-estate-test-api.herokuapp.com/api/', //audience
            'iat' => $iat, //time JWT was issued
            'exp' => $exp //time JWT expires
        );
        $jwt = JWT::encode($payload, $this->key, 'HS512');
        return array(
            'token' => $jwt,
            'expires' => $exp
        );
    }

    public function signUp()
    {

        try {

            $query = "INSERT INTO " . $this->db_table . "
                    SET 
                        email = :email,
                        username = :username,
                        password = :password ;";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':username', $this->username);
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
            if ($stmt->execute()) :
                $stmt->rowCount();
                if ($stmt->rowCount()) :

                    $secret_key = $this->key;
                    $issuer_claim = "https://my-estate-test-api.herokuapp.com/"; // this can be the servername
                    $audience_claim = "https://my-estate-test-api.herokuapp.com/api/";
                    $issuedat_claim = time(); // issued at
                    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                    $expire_claim = $issuedat_claim + 60 * 60; // expire time in seconds

                    $token = array(
                        "iss" => $issuer_claim,
                        "aud" => $audience_claim,
                        "iat" => $issuedat_claim,
                        "nbf" => $notbefore_claim,
                        "exp" => $expire_claim,
                        "data" => array(
                            "username" => $this->username,
                            "password" => $password_hash
                        )
                    );
                    $jwt = JWT::encode($token, $this->key, 'HS512');
                    return array(
                        "message" => "Successful Registration.",
                        "jwt" => $jwt,
                        "username" => $this->username,
                        "email" => $this->email,
                        "expireAt" => $expire_claim
                    );
                else :
                    return false;
                endif;
            else :
                "here" . $query;
                return false;
            endif;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function signIn()
    {

        try {


            $query = "SELECT username, password FROM " . $this->db_table . " WHERE username = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->username);


            if ($stmt->execute()) :
                if ($stmt->rowCount()) :
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $password2 = $row['password'];
                    if (password_verify($this->password, $password2)) :
                        $secret_key = $this->key;
                        $issuer_claim = "https://my-estate-test-api.herokuapp.com/"; // this can be the servername
                        $audience_claim = "https://my-estate-test-api.herokuapp.com/api/";
                        $issuedat_claim = time(); // issued at
                        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                        $expire_claim = $issuedat_claim + 60 * 60; // expire time in seconds

                        $token = array(
                            "iss" => $issuer_claim,
                            "aud" => $audience_claim,
                            "iat" => $issuedat_claim,
                            "nbf" => $notbefore_claim,
                            "exp" => $expire_claim,
                            "data" => array(
                                "username" => $this->username,
                                "password" => $password2
                            )
                        );
                        $jwt = JWT::encode($token, $this->key, 'HS512');
                        return array(
                            "message" => "Successful login.",
                            "jwt" => $jwt,
                            "username" => $this->username,
                            "email" => $this->email,
                            "expireAt" => $expire_claim
                        );
                    else :
                        return array(
                            "message" => "Login failed.",
                            "reason" => "credentials",
                        );
                    endif;
                else :
                    return  array(
                        "message" => "Login failed.",
                        "reason" => "credentials",
                    );
                endif;
            else :
                return array(
                    "message" => "Login failed.",
                    "reason" => "unknown",
                );
            endif;
        } catch (\Exception $e) {
            return array(
                "message" => "Login failed.",
                "reason" => "unknown",
            );;
        }
    }
}
