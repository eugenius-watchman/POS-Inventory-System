<?php

require_once 'connection.php';

/**
 *
 */
class ModelUsers
{
    /*======================
    SHOW USERS
    =======================*/
    /**
     *
     *
     * @param $table
     * @param $item
     * @param $value
     * @return
     */
    static public function mdlShowUsers($table, $item, $value)
    {
        if ($item !== null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE $item = :$item");

            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetch();
            $stmt = null;
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table");

            $stmt->execute();

            $result = $stmt->fetchAll();
            $stmt = null;
            return $result;
        }
    }

    /*===============================
    USER REGISTER/CREATE USER
    ================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlAddUser($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO
            $table (name, user, password, profile, picture)
        VALUES (:name, :user, :password, :profile, :picture)");

        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $data['user'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindParam(':profile', $data['profile'], PDO::PARAM_STR);
        $stmt->bindParam(':picture', $data['picture'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*======================
    EDIT USER
    =======================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlEditUser($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table
            SET name = :name, user = :user, password = :password,
        profile = :profile, picture = :picture WHERE user = :user");

        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindParam(':profile', $data['profile'], PDO::PARAM_STR);
        $stmt->bindParam(':picture', $data['picture'], PDO::PARAM_STR);
        $stmt->bindParam(':user', $data['user'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*======================
    UPDATE USER
    =======================*/
    /**
     *
     *
     * @param $table
     * @param $item1
     * @param $value1
     * @param $item2
     * @param $value2
     * @return
     */
    static public function mdlUpdateUser($table, $item1, $value1, $item2, $value2)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table
        SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":{$item1}", $value1, PDO::PARAM_STR);
        $stmt->bindParam(":{$item2}", $value2, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*======================
    DELETE USER
    =======================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlDeleteUser($table, $data)
    {
        $stmt = Connection::connect()->prepare("DELETE FROM $table
        WHERE id = :id");

        $stmt->bindParam(':id', $data, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }
}