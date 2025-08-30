<?php

require_once 'connection.php';
error_log("Test PHP log entry");

/**
 *
 */
class ModelClients
{
    /*======================================
    UPDATE CLIENT
    ========================================*/
    /**
     * Updates a specific field of a client in the database.
     *
     * @param string $table The name of the database table.
     * @param string $item The column to be updated.
     * @param mixed $value The new value for the specified column.
     * @param int $value_client The ID of the client to be updated.
     * @return string 'ok' if the update was successful, otherwise 'error'.
     */
    static public function mdlUpdateClients($table, $item, $value, $value_client)
    {
        // Ensure $table is a safe value if switching between tables
        if (!in_array($table, ['clients'])) {
            error_log("Invalid table name: $table");
            return 'error';
        }

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
            error_log("Update Error: " . implode(", ", $stmt->errorInfo()));
            return 'error';
        }
    }

    /*======================================
    CREATE/ADD CLIENT
    ========================================*/
    /**
     * Inserts a new client into the database.
     *
     * @param string $table The name of the database table.
     * @param array $data An associative array containing client data.
     * @return string 'ok' if the insertion was successful, otherwise 'error'.
     */
    static public function mdlAddClient($table, $data)
    {
        if (!in_array($table, ['clients'])) {
            error_log("Invalid table name: $table");
            return 'error';
        }

        error_log("Starting mdlAddClient function");  // Log function start

        // Assign values to variables
        $name = $data['name'];
        $document = $data['document'];
        $email = $data['email'] ?? null;
        $telephone = $data['telephone'] ?? null;
        $address = $data['address'] ?? null;
        $birthday = $data['birthday'] ?? null;

        // Prepare the SQL statement with placeholders
        $stmt = Connection::connect()->prepare("INSERT INTO $table
            (name, document, email, telephone, address, birthday)
        VALUES (:name, :document, :email, :telephone, :address, :birthday)");

        // Bind each variable, handling null values
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':document', $document, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, $email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, $telephone === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, $address === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, $birthday === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        if ($stmt->execute()) {
            error_log("Client added successfully");  // Log success
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            error_log("Insert Error: " . implode(", ", $stmt->errorInfo()));
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*=========================================
    SHOW CLIENTS
    ==========================================*/
    /**
     * Retrieves one or all clients from the database.
     *
     * @param string $table The name of the database table.
     * @param string|null $item The column name to filter by, or null for all records.
     * @param mixed|null $value The value to filter by, if $item is provided.
     * @return array|false Client data as an associative array or false on failure.
     */
    static public function mdlShowClients($table, $item, $value)
    {
        if (!in_array($table, ['clients'])) {
            error_log("Invalid table name: $table");
            return false;
        }

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
     * Edits an existing client record in the database.
     *
     * @param string $table The name of the database table.
     * @param array $data An associative array containing updated client data.
     * @return string 'ok' if the update was successful, otherwise 'error'.
     */
    static public function mdlEditClient($table, $data)
    {
        if (!in_array($table, ['clients'])) {
            error_log("Invalid table name: $table");
            return 'error';
        }

        error_log("Starting mdlEditClient function");

        $stmt = Connection::connect()->prepare("UPDATE $table SET 
            name = :name,
            document = :document, 
            email = :email, 
            telephone = :telephone,
            address = :address, 
            birthday = :birthday 
            WHERE id = :id");

        // Assign values to variables
        $name = $data['name'];
        $document = $data['document'];
        $email = $data['email'] ?? null;
        $telephone = $data['telephone'] ?? null;
        $address = $data['address'] ?? null;
        $birthday = $data['birthday'] ?? null;
        $id = $data['id'];

        // Bind each variable to the statement, handling null values
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':document', $document, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, $email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, $telephone === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, $address === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, $birthday === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            error_log("Client edited successfully");
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            error_log("Edit Error: " . implode(", ", $stmt->errorInfo()));
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*==================================
    DELETE CLIENT
    ====================================*/
    /**
     * Deletes a client record from the database.
     *
     * @param string $table The name of the database table.
     * @param int $data The ID of the client to delete.
     * @return string 'ok' if the deletion was successful, otherwise 'error'.
     */
    static public function mdlDeleteClient($table, $data)
    {
        if (!in_array($table, ['clients'])) {
            error_log("Invalid table name: $table");
            return 'error';
        }

        $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

        $stmt->bindParam(':id', $data, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            error_log("Delete Error: " . implode(", ", $stmt->errorInfo()));
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }
}


// require_once 'connection.php';
// error_log("Test PHP log entry");

// /**
//  *
//  */
// class ModelClients
//     {/*======================================
//     UPDATE CLIENT
//     ========================================*/
//     /**
//      * Updates a specific field of a client in the database.
//      *
//      * @param string $table The name of the database table.
//      * @param string $item The column to be updated.
//      * @param mixed $value The new value for the specified column.
//      * @param int $value_client The ID of the client to be updated.
//      * @return string 'ok' if the update was successful, otherwise 'error'.
//      */
//     static public function mdlUpdateClients($table, $item, $value, $value_client)
//     {
//         // Prepare the SQL statement for updating client data
//         $stmt = Connection::connect()->prepare("UPDATE $table
//         SET $item = :$item WHERE id = :id");

//         // Bind parameters to the statement
//         $stmt->bindParam(":$item", $value, PDO::PARAM_STR);
//         $stmt->bindParam(':id', $value_client, PDO::PARAM_INT);

//         // Execute the statement
//         if ($stmt->execute()) {
//             return 'ok';
//         } else {
//             return 'error';
//         }
//     }

//     /*======================================
//     CREATE/ADD CLIENT
//     ========================================*/
//      /**
//      * Inserts a new client into the database.
//      *
//      * @param string $table The name of the database table.
//      * @param array $data An associative array containing client data.
//      * @return string 'ok' if the insertion was successful, otherwise 'error'.
//      */
//     static public function mdlAddClient($table, $data)
//     {
//         error_log("Starting mdlAddClient function");  // Log function start
//         error_log("Test PHP log entry in mdlAddClient");

//         // Assign values to variables
//         $name = $data['name'];
//         $document = $data['document'];
//         $email = $data['email'] ?? null;
//         $telephone = $data['telephone'] ?? null;
//         $address = $data['address'] ?? null;
//         $birthday = $data['birthday'] ?? null;

//         // Log variables to check values
//         error_log("Name: " . $name);
//         error_log("Document: " . $document);
//         error_log("Email: " . print_r($email, true));
//         error_log("Telephone: " . print_r($telephone, true));
//         error_log("Address: " . print_r($address, true));
//         error_log("Birthday: " . print_r($birthday, true));

//         $stmt = Connection::connect()->prepare("INSERT INTO $table
//             (name, document, email, telephone, address, birthday)
//         VALUES (:name, :document, :email, :telephone, :address, :birthday)");

//         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//         $stmt->bindParam(':document', $document, PDO::PARAM_INT);
//         $stmt->bindParam(':email', $email, PDO::PARAM_STR);
//         $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
//         $stmt->bindParam(':address', $address, PDO::PARAM_STR);
//         $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);

//         if ($stmt->execute()) {
//             error_log("Client added successfully");  // Log success
//             error_log("Test PHP log entry - Insert Successful");
//             $stmt = null; // Properly close the statement
//             return 'ok';
//         } else {
//             error_log("Test PHP log entry - Insert Failed");
//             error_log("PDO Error: " . implode(", ", $stmt->errorInfo()));  // Log error details
//             $stmt = null; // Properly close the statement
//             return 'error';
//         }
//     }

    // static public function mdlAddClient($table, $data)
    // {
        
    //     error_log("Starting mdlAddClient function"); // log function start

    //     $stmt = Connection::connect()->prepare("INSERT INTO $table
    //         (name, document, email, telephone, address, birthday)
    //     VALUES (:name, :document, :email, :telephone, :address, :birthday)");

    //     // $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
    //     // $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':telephone', $data['telephone'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);

    //     // $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
    //     // $stmt->bindParam(':email', $data['email'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':telephone', $data['telephone'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':address', $data['address'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':birthday', $data['birthday'] ?? null, PDO::PARAM_STR);

    //     // Assign values to variables to avoid passing expressions directly
    //     $name = $data['name'];
    //     $document = $data['document'];
    //     $email = $data['email'] ?? null;
    //     $telephone = $data['telephone'] ?? null;
    //     $address = $data['address'] ?? null;
    //     $birthday = $data['birthday'] ?? null;

    //     // Log variable values
    //     error_log("Variable values: " . print_r($data, true));


    //     // Bind each variable to the statement
    //     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    //     $stmt->bindParam(':document', $document, PDO::PARAM_INT);
    //     $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    //     $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    //     $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    //     $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);

    //     if ($stmt->execute()) {
    //         error_log("Client added successfully");
    //         $stmt = null; // Properly close the statement
    //         return 'ok';
    //     } else {
    //         error_log("PDO Error: " . implode(", ", $stmt->errorInfo()));
    //         $stmt = null; // Properly close the statement
    //         return 'error';
    //     }
    // }

    // /*=========================================
    // SHOW CLIENTS
    // ==========================================*/
    //  /**
    //  * Retrieves one or all clients from the database.
    //  *
    //  * @param string $table The name of the database table.
    //  * @param string|null $item The column name to filter by, or null for all records.
    //  * @param mixed|null $value The value to filter by, if $item is provided.
    //  * @return array|false Client data as an associative array or false on failure.
    //  */
    // static public function mdlShowClients($table, $item, $value)
    // {
    //     if ($item !== null) {
    //         $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

    //         $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);

    //         $stmt->execute();

    //         $result = $stmt->fetch();

    //         $stmt = null; // Properly close the statement
    //         return $result;
    //     } else {
    //         $stmt = Connection::connect()->prepare("SELECT * FROM $table");

    //         $stmt->execute();

    //         $result = $stmt->fetchAll();

    //         $stmt = null; // Properly close the statement
    //         return $result;
    //     }
    // }

    // /*======================================
    // EDIT CLIENT
    // ========================================*/
    // /**
    //  * Edits an existing client record in the database.
    //  *
    //  * @param string $table The name of the database table.
    //  * @param array $data An associative array containing updated client data.
    //  * @return string 'ok' if the update was successful, otherwise 'error'.
    //  */
    // static public function mdlEditClient($table, $data)
    // {   
    //     error_log("Starting mdlEditClient function");

    //     $stmt = Connection::connect()->prepare("UPDATE $table SET 
    //         name = :name,
    //         document = :document, 
    //         email = :email, 
    //         telephone = :telephone,
    //         address = :address, 
    //         birthday = :birthday 
    //         WHERE id = :id");

    //     // $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    //     // $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
    //     // $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':telephone', $data['telephone'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);

    //     // Assign values to variables before binding
    //     $name = $data['name'];
    //     $document = $data['document'];
    //     $email = $data['email'] ?? null;
    //     $telephone = $data['telephone'] ?? null;
    //     $address = $data['address'] ?? null;
    //     $birthday = $data['birthday'] ?? null;
    //     $id = $data['id'];

    //     // $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
    //     // $stmt->bindParam(':document', $data['document'], PDO::PARAM_INT);
    //     // $stmt->bindParam(':email', $data['email'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':telephone', $data['telephone'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':address', $data['address'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':birthday', $data['birthday'] ?? null, PDO::PARAM_STR);
    //     // $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

    //     // Log variable values
    //     error_log("Variable values: " . print_r($data, true));

    //     // Bind each variable to the statement
    //     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    //     $stmt->bindParam(':document', $document, PDO::PARAM_INT);
    //     $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    //     $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    //     $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    //     $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //     if ($stmt->execute()) {
    //         error_log("Client edited successfully");
    //         $stmt = null; // Properly close the statement
    //         return 'ok';
    //     } else {
    //         error_log("PDO Error: " . implode(", ", $stmt->errorInfo()));
    //         $stmt = null; // Properly close the statement
    //         return 'error';
    //     }
    // }

//     /*==================================
//     DELETE CLIENT
//     ====================================*/
//     /**
//      * Deletes a client record from the database.
//      *
//      * @param string $table The name of the database table.
//      * @param int $data The ID of the client to delete.
//      * @return string 'ok' if the deletion was successful, otherwise 'error'.
//      */
//     static public function mdlDeleteClient($table, $data)
//     {
//         $stmt = Connection::connect()->prepare("DELETE FROM $table
//         WHERE id = :id");

//         $stmt->bindParam(':id', $data, PDO::PARAM_INT);
//         if ($stmt->execute()) {
//             $stmt = null; // Properly close the statement
//             return 'ok';
//         } else {
//             error_log("PDO Error: " . implode(", ", $stmt->errorInfo()));
//             $stmt = null; // Properly close the statement
//             return 'error';
//         }
//     }
// }