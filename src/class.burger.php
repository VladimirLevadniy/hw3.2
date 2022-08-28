<?php
class Burger
{

    public function getUserByEmail( $email)
    {
        $db = \base\DB::getInstance();
        $query = "SELECT * FROM users WHERE email = :email";
        return $db->fetchOne($query, __METHOD__, [':email' => $email]);
    }

    public function createUser( $email, $name)
    {
        $db = \base\DB::getInstance();
        $query = "INSERT INTO users(email, `name`) VALUES (:email, :name)";
        $result = $db->exec($query, __METHOD__, [
            ':email' => $email,
            ':name' => $name,
        ]);
        if (!$result) {
            return false;
       }
        return $db->lastInsertId();
    }

    public function addOrder(int $userId, array $data)
    {
        $db = \base\DB::getInstance();
        $query = "INSERT INTO orders(user_id, address, created_id) VALUES (:user_id, :address, :created_id)";
        $result = $db->exec(
            $query,
            __METHOD__,
            [
                ':user_id' => $userId,
                ':created_id' => date('Y-m-d H:i:s'),
                ':address' => $data['address'],
            ]
        );
        if (!$result) {
            return false;
        }
        return $db->lastInsertId();
    }
    public function incOrders(int $userId)
    {
        $db = \base\DB::getInstance();
        $query = "UPDATE users SET orders = orders +1 WHERE id = $userId";
        return $db->exec($query, __METHOD__);
    }

}