<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

class Properties
{
    private $conn;

    private $key = 'privatekey/moussaab';

    private $db_table = 'properties';
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAll()
    {
        $headers = apache_request_headers();
        echo $headers['authorization'];
        echo $headers['Authorization'];
        if (isset($headers['authorization'])) :
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, $this->key, array('HS512'));
                $query = "SELECT * FROM " . $this->db_table . "
                ORDER BY
                    id ASC";
                $statement = $this->conn->prepare($query);
                $statement->execute();
                return $statement;
            } catch (\Exception $e) {
                return false;
            }
        else :
            return false;
        endif;
    }

    public function getOne($id)
    {
        $headers = apache_request_headers();
        if (isset($headers['authorization'])) :
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, $this->key, array('HS512'));
                $query = "SELECT * FROM " . $this->db_table . "
                WHERE
                    id= :id";
                $statement = $this->conn->prepare($query);
                $statement->bindParam(":id", $id);
                $statement->execute();
                return $statement;
            } catch (\Exception $e) {
                return false;
            }
        else :
            return false;
        endif;
    }


    public function update()
    {
        $headers = apache_request_headers();
        if (isset($headers['authorization'])) :
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, $this->key, array('HS512'));
                $query = "UPDATE " . $this->db_table . "
                SET
                    title = :title,
                    description = :description,
                    images = :images,
                    features = :features,
                    adresse = :adresse,
                    price = :price,
                    type = :type,
                    size = :size
                WHERE
                    id = :id";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":title", $this->title);
                $stmt->bindParam(":description", $this->description);
                $stmt->bindParam(":images", $this->images);
                $stmt->bindParam(":features", $this->features);
                $stmt->bindParam(":adresse", $this->adresse);
                $stmt->bindParam(":price", $this->price);
                $stmt->bindParam(":type", $this->type);
                $stmt->bindParam(":size", $this->size);
                $stmt->bindParam(":id", $this->id);

                if ($stmt->execute()) :
                    $stmt->rowCount();
                    if ($stmt->rowCount()) :
                        return true;
                    else :
                        return false;
                    endif;
                else :
                    return false;
                endif;
            } catch (\Exception $e) {
                return false;
            }
        else :
            return false;
        endif;
    }
    public function create()
    {
        $headers = apache_request_headers();
        if (isset($headers['authorization'])) :
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, $this->key, array('HS512'));
                $query = "INSERT INTO " . $this->db_table . "
                SET
                    title = :title,
                    description = :description,
                    images = :images,
                    features = :features,
                    adresse = :adresse,
                    price = :price,
                    type = :type,
                    size = :size";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":title", $this->title);
                $stmt->bindParam(":description", $this->description);
                $stmt->bindParam(":images", $this->images);
                $stmt->bindParam(":features", $this->features);
                $stmt->bindParam(":adresse", $this->adresse);
                $stmt->bindParam(":price", $this->price);
                $stmt->bindParam(":type", $this->type);
                $stmt->bindParam(":size", $this->size);

                if ($stmt->execute()) :
                    if ($stmt->rowCount()) :
                        return true;
                    else :
                        return false;
                    endif;
                else :
                    return false;
                endif;
            } catch (\Exception $e) {
                return false;
            }
        else :
            return false;
        endif;
    }
    public function delete()
    {
        $headers = apache_request_headers();
        if (isset($headers['authorization'])) :
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, $this->key, array('HS512'));
                $query = "SELECT id from " . $this->db_table . "
                WHERE
                    id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id", $this->id);
                $stmt->execute();
                if ($stmt->rowCount()) :
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                        $slug = $row['id'];
                    endwhile;
                    $query = "DELETE FROM " . $this->db_table . "
                    WHERE
                        id = :id";

                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":id", $this->id);

                    if ($stmt->execute()) :
                        if ($stmt->rowCount()) :
                            return true;
                        else :
                            return false;
                        endif;
                    else :
                        return false;
                    endif;
                else :
                    return false;
                endif;
            } catch (\Exception $e) {
                return false;
            }
        else :
            return false;
        endif;
    }
}
