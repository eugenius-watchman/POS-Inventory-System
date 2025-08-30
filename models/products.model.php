<?php

require_once 'connection.php';

/**
 *
 */
class ModelProducts
{
    /*=======================================
    SHOW PRODUCTS
    ====================================*/
    /**
     *
     *
     * @param $table
     * @param $item
     * @param $value
     * @param $order
     * @return
     */
    static public function mdlShowProducts($table, $item, $value, $order)
    {
        if ($item !== null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE $item = :$item ORDER BY $order DESC");

            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();
            $stmt = null;
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            ORDER BY $order DESC");

            $stmt->execute();

            $result = $stmt->fetchAll();
            $stmt = null;
            return $result;
        }
    }

    /*=======================================
    ADD PRODUCTS
    ====================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlAddProduct($table, $data)
{
    try {
        $db = Connection::connect();
        
        // Verify connection works
        if (!$db->query("SELECT 1")) {
            throw new Exception("Database connection failed");
        }

        // Check if category exists
        $categoryCheck = $db->prepare("SELECT id FROM categories WHERE id = ?");
        $categoryCheck->execute([$data['id_category']]);
        if (!$categoryCheck->fetch()) {
            throw new Exception("Category does not exist");
        }

        // Check for duplicate product code
        $codeCheck = $db->prepare("SELECT id FROM products WHERE code = ?");
        $codeCheck->execute([$data['code']]);
        if ($codeCheck->fetch()) {
            throw new Exception("Product code already exists");
        }

        $sql = "INSERT INTO $table 
               (id_category, code, description, image, stock, buying_price, sale_price, sales) 
               VALUES 
               (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price, 0)";

        error_log("Attempting to execute: " . $sql);
        error_log("With data: " . print_r($data, true));

        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':id_category', (int)$data['id_category'], PDO::PARAM_INT);
        $stmt->bindValue(':code', substr($data['code'], 0, 50), PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':image', $data['image'], PDO::PARAM_STR);
        $stmt->bindValue(':stock', (int)$data['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':buying_price', round($data['buying_price'], 2), PDO::PARAM_STR);
        $stmt->bindValue(':sale_price', round($data['sale_price'], 2), PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            $error = $stmt->errorInfo();
            throw new Exception($error[2]); // Return the actual SQL error message
        }
    } catch (Exception $e) {
        error_log("Database Error: " . $e->getMessage());
        return 'error: ' . $e->getMessage();
    }
}

//     static public function mdlAddProduct($table, $data)
// {
//     try {
//         $db = Connection::connect();
        
//         // Test connection first
//         if (!$db->query("SELECT 1")) {
//             throw new Exception("Database connection failed");
//         }

//         $sql = "INSERT INTO $table 
//                (id_category, code, description, image, stock, buying_price, sale_price) 
//                VALUES 
//                (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)";

//         // Log the SQL and data for debugging
//         error_log("SQL: $sql");
//         error_log("Data: " . print_r($data, true));

//         $stmt = $db->prepare($sql);
        
//         // Explicit type binding
//         $stmt->bindValue(':id_category', (int)$data['id_category'], PDO::PARAM_INT);
//         $stmt->bindValue(':code', substr($data['code'], 0, 50), PDO::PARAM_STR);
//         $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
//         $stmt->bindValue(':image', $data['image'], PDO::PARAM_STR);
//         $stmt->bindValue(':stock', (int)$data['stock'], PDO::PARAM_INT);
//         $stmt->bindValue(':buying_price', round($data['buying_price'], 2));
//         $stmt->bindValue(':sale_price', round($data['sale_price'], 2));

//         if ($stmt->execute()) {
//             return 'ok';
//         } else {
//             $error = $stmt->errorInfo();
//             throw new Exception("Database error: " . $error[2]);
//         }
//     } catch (Exception $e) {
//         error_log("Product Insert Error: " . $e->getMessage());
//         return $e->getMessage(); // Return the actual error message
//     }
// }
//     static public function mdlAddProduct($table, $data)
// {
//     try {
//         $db = Connection::connect();
        
//         // Verify connection works
//         $test = $db->query("SELECT 1");
//         if (!$test) {
//             error_log("Database connection test failed");
//             return 'connection_error';
//         }

//         // Prepare SQL with backticks for table/column names
//         $sql = "INSERT INTO `$table` 
//                 (`id_category`, `code`, `description`, `image`, `stock`, `buying_price`, `sale_price`) 
//                 VALUES 
//                 (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)";
        
//         $stmt = $db->prepare($sql);
        
//         // Bind parameters with explicit types
//         $stmt->bindParam(':id_category', $data['id_category'], PDO::PARAM_INT);
//         $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
//         $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
//         $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
//         $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
//         $stmt->bindParam(':buying_price', $data['buying_price'], PDO::PARAM_STR);
//         $stmt->bindParam(':sale_price', $data['sale_price'], PDO::PARAM_STR);
        
//         if ($stmt->execute()) {
//             return 'ok';
//         } else {
//             $error = $stmt->errorInfo();
//             error_log("Database error: ".print_r($error, true));
//             return 'error: '.$error[2]; // Return the actual error message
//         }
//     } catch (PDOException $e) {
//         error_log("PDO Exception: ".$e->getMessage());
//         return 'exception: '.$e->getMessage();
//     }
// }
// static public function mdlAddProduct($table, $data)
// {
//     try {
//         error_log("Attempting database connection...");
//         $db = Connection::connect();
        
//         // Test connection
//         $test = $db->query("SELECT 1");
//         if (!$test) {
//             error_log("Database connection test failed");
//             return 'connection_error';
//         }
//         error_log("Database connection successful");
        
//         $sql = "INSERT INTO $table (id_category, code, description, image, stock, buying_price, sale_price) 
//                 VALUES (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)";
        
//         error_log("Preparing SQL: ".$sql);
        
//         $stmt = $db->prepare($sql);
        
//         // Bind parameters with explicit types
//         $stmt->bindValue(':id_category', (int)$data['id_category'], PDO::PARAM_INT);
//         $stmt->bindValue(':code', $data['code'], PDO::PARAM_STR);
//         $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
//         $stmt->bindValue(':image', $data['image'], PDO::PARAM_STR);
//         $stmt->bindValue(':stock', (int)$data['stock'], PDO::PARAM_INT);
//         $stmt->bindValue(':buying_price', (float)$data['buying_price']);
//         $stmt->bindValue(':sale_price', (float)$data['sale_price']);
        
//         error_log("Executing query...");
//         if ($stmt->execute()) {
//             error_log("Insert successful");
//             return 'ok';
//         } else {
//             $error = $stmt->errorInfo();
//             error_log("Database error: ".print_r($error, true));
//             return 'error';
//         }
//     } catch (PDOException $e) {
//         error_log("PDO Exception: ".$e->getMessage());
//         return 'exception';
//     }
// }


//     static public function mdlAddProduct($table, $data){
//     try {
//         $stmt = Connection::connect()->prepare("INSERT INTO $table 
//             (id_category, code, description, image, stock, buying_price, sale_price) 
//             VALUES (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)");

//         // Convert numeric values to proper types
//         $id_category = (int)$data['id_category'];
//         $stock = (int)$data['stock'];
//         $buying_price = (float)$data['buying_price'];
//         $sale_price = (float)$data['sale_price'];

//         $stmt->bindParam(':id_category', $id_category, PDO::PARAM_INT);
//         $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
//         $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
//         $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
//         $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
//         $stmt->bindParam(':buying_price', $buying_price);
//         $stmt->bindParam(':sale_price', $sale_price);


//         // $stmt->bindParam(':id_category', $data['id_category'], PDO::PARAM_INT);
//         // $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
//         // $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
//         // $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
//         // $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_STR);
//         // $stmt->bindParam(':buying_price', $data['buying_price'], PDO::PARAM_STR);
//         // $stmt->bindParam(':sale_price', $data['sale_price'], PDO::PARAM_STR);

//         if ($stmt->execute()) {
//             return 'ok';
//         } else {
//             // Log the error for debugging
//             error_log("Database error: " . implode(" ", $stmt->errorInfo()));
//             return 'error';
//         }
//     } catch (PDOException $e) {
//         error_log("PDO Exception: " . $e->getMessage());
//         return 'error';
//     } finally {
//         $stmt = null;
//     }
// }


    // static public function mdlAddProduct($table, $data)
    // {
    //     $stmt = Connection::connect()->prepare("INSERT INTO $table (id_category, code, description, image, stock, buying_price, sale_price)
    //     VALUES (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)");

    //     $stmt->bindParam(':id_category', $data['id_category'], PDO::PARAM_INT);
    //     $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
    //     $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
    //     $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
    //     $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_STR);
    //     $stmt->bindParam(':buying_price', $data['buying_price'], PDO::PARAM_STR);
    //     $stmt->bindParam(':sale_price', $data['sale_price'], PDO::PARAM_STR);

    //     if ($stmt->execute()) {
    //         $stmt = null; // Properly close the statement
    //         return 'ok';
    //     } else {
    //         $stmt = null; // Properly close the statement
    //         return 'error';
    //     }
    // }

    /*=======================================
    EDIT PRODUCTS
    ====================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlEditProduct($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table SET id_category = :id_category, description = :description,
            image = :image, stock = :stock, buying_price = :buying_price,
        sale_price = :sale_price WHERE code = :code");

        $stmt->bindParam(':id_category', $data['id_category'], PDO::PARAM_INT);
        $stmt->bindParam(':code', $data['code'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_STR);
        $stmt->bindParam(':buying_price', $data['buying_price'], PDO::PARAM_STR);
        $stmt->bindParam(':sale_price', $data['sale_price'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*==================================
    DELETE PRODUCTS
    ====================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlDeleteProduct($table, $data)
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

    /*======================
    UPDATE PRODUCT
    =======================*/
    /**
     *
     *
     * @param $table
     * @param $item1
     * @param $value1
     * @param $value
     * @return
     */
    static public function mdlUpdateProducts($table, $item1, $value1, $value)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table
        SET $item1 = :$item1 WHERE id = :id");

        $stmt->bindParam(":{$item1}", $value1, PDO::PARAM_STR);
        $stmt->bindParam(':id', $value, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*=============================================
    SHOW ADDING OF THE SALES
    =============================================*/
    /**
     *
     *
     * @param $table
     * @return
     */
    static public function mdlShowAddingOfTheSales($table)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(sales) as total
        FROM $table");

        $stmt->execute();

        $result = $stmt->fetch();
        $stmt = null;
        return $result;
    }
}