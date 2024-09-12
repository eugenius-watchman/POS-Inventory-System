<?php

require_once 'connection.php';

/**
 *
 */
class ModelClients
    {/*======================================
    UPDATE CLIENT
    ========================================*/
    static public function mdlUpdateClients($table, $item, $value, $value_client)
    {
        // Prepare the SQL statement for updating client data
        $stmt = Connection::connect()->prepare("UPDATE $table
        SET $item = :$item WHERE id = :id");

        // Bind parameters to the statement
        $stmt->bindParam(":$item", $value, PDO::PARAM_STR);
        $stmt->bindParam(':id', $value_client, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    /*======================================
    CREATE/ADD CLIENT
    ========================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlAddClient($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $table
            (name, document, email, telephone, address, birthday)
        VALUES (:name, :document, :email, :telephone, :address, :birthday)");

        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);

        $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $data['telephone'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);

        $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*=========================================
    SHOW CLIENTS
    ==========================================*/
    /**
     *
     *
     * @param $table
     * @param $item
     * @param $value
     * @return
     */
    static public function mdlShowClients($table, $item, $value)
    {
        if ($item !== null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetch();

            $stmt = null; // Properly close the statement
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table");

            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        }
    }

    /*======================================
    EDIT CLIENT
    ========================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlEditClient($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table SET name = :name,
            document = :document, email = :email, telephone = :telephone,
        address = :address, birthday = :birthday WHERE id = :id");

        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $data['telephone'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*==================================
    DELETE CLIENT
    ====================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlDeleteClient($table, $data)
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