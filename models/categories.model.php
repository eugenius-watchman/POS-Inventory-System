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
    // Connect to database with error handling
    $db = Connection::connect();
    if (!$db->query("SELECT 1")) {
        error_log("Database connection failed");
        return false;
    }

    try {
        if ($item !== null && $value !== null) {
            $stmt = $db->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);
            $stmt->execute();

            // Get result as associative array
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug: Log the retrieved data
            error_log("Retrieved category data: " . print_r($result, true));
        } else {
            $stmt = $db->prepare("SELECT * FROM $table");
            $stmt->execute();

            // Get all results as associative arrays
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = null; // Properly close the statement
        return $result;

    } catch (PDOException $e) {
        error_log("Database error in mdlShowCategories: " . $e->getMessage());
        return false;
    }
}
    // static public function mdlShowCategories($table, $item, $value)
    // {
    //     if ($item !== null) {
    //         $stmt = Connection::connect()->prepare("SELECT * FROM $table
    //         WHERE $item = :$item");
    //         $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);
    //         $stmt->execute();

    //         $result = $stmt->fetch();

    //         $stmt = null; //  Properly close the statement
    //         return $result;
    //     } else {
    //         $stmt = Connection::connect()->prepare("SELECT * FROM $table");
    //         $stmt->execute();

    //         $result = $stmt->fetchAll();

    //         $stmt = null; // Properly close the statement
    //         return $result;
    //     }
    // }

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
        // Add database connection check here
        $db = Connection::connect();
        if (!$db->query("SELECT 1")) {
            error_log("Database connection failed in mdlEditCategory");
            return 'error';
        }

        $stmt = $db->prepare("UPDATE $table
        SET category = :category WHERE id = :id");

        $stmt->bindParam(':category', $data['category'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            error_log("Category update failed: " . print_r($stmt->errorInfo(), true));
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }
    // static public function mdlEditCategory($table, $data)
    // {
    //     $stmt = Connection::connect()->prepare("UPDATE $table
    //     SET category = :category WHERE id = :id");

    //     $stmt->bindParam(':category', $data['category'], PDO::PARAM_STR);
    //     $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

    //     if ($stmt->execute()) {
    //         $stmt = null; // Properly close the statement
    //         return 'ok';
    //     } else {
    //         $stmt = null; // Properly close the statement
    //         return 'error';
    //     }
    // }

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
//     static public function mdlDeleteCategory($table, $data) {
//     $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
//     $stmt->bindParam(':id', $data, PDO::PARAM_INT);
    
//     if ($stmt->execute()) {
//         return 'ok';
//     } else {
//         $error = $stmt->errorInfo();
//         error_log("Database error: " . $error[2]);
//         return 'error';
//     }
// }
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