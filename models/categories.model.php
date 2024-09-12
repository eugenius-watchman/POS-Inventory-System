<?php

require_once 'connection.php';

/**
 *
 */
class ModelCategories
{
    /*===========================
    CREATE CATEGORY
    =========================== */
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlCreateCategory($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $table (category)
        VALUES (:category)");

        $stmt->bindParam(':category', $data, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*===========================
    SHOW CATEGORY
    =========================== */
    /**
     *
     *
     * @param $table
     * @param $item
     * @param $value
     * @return
     */
    static public function mdlShowCategories($table, $item, $value)
    {
        if ($item !== null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE $item = :$item");
            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();

            $stmt = null; //  Properly close the statement
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table");
            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        }
    }

    /*===========================
    EDIT CATEGORY
    =========================== */
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlEditCategory($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table
        SET category = :category WHERE id = :id");

        $stmt->bindParam(':category', $data['category'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*===========================
    DELETE CATEGORY
    =========================== */
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlDeleteCategory($table, $data)
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