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
        $stmt = Connection::connect()->prepare("INSERT INTO $table (id_category, code, description, image, stock, buying_price, sale_price)
        VALUES (:id_category, :code, :description, :image, :stock, :buying_price, :sale_price)");

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