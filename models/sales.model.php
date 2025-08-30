<?php

require_once 'connection.php';

/**
 *
 */
class ModelSales
{
    /*=========================================
    SHOW SALES
    ==========================================*/
    /**
     *
     *
     * @param $table
     * @param $item
     * @param $value
     * @return
     */
    static public function mdlShowSales($table, $item, $value)
    {
        if ($item !== null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE $item = :$item ORDER BY id ASC");

            $stmt->bindParam(":{$item}", $value, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetch();

            $stmt = null; // Properly close the statement
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM
            $table ORDER BY id ASC");

            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        }
    }

    /*=========================================
    ADD SALES/ REGISTER SALE
    ==========================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlAddSale($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO
            $table (code, id_client, id_seller, products, tax, net, total, mode_payment)
        VALUES (:code, :id_client, :id_seller, :products, :tax, :net, :total, :mode_payment)");

        $stmt->bindParam(':code', $data['code'], PDO::PARAM_INT);
        $stmt->bindParam(':id_client', $data['id_client'], PDO::PARAM_INT);
        $stmt->bindParam(':id_seller', $data['id_seller'], PDO::PARAM_INT);
        $stmt->bindParam(':products', $data['products'], PDO::PARAM_STR);
        $stmt->bindParam(':tax', $data['tax'], PDO::PARAM_STR);
        $stmt->bindParam(':net', $data['net'], PDO::PARAM_STR);
        $stmt->bindParam(':total', $data['total'], PDO::PARAM_STR);
        $stmt->bindParam(':mode_payment', $data['mode_payment'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*=========================================
    EDIT SALE
    ==========================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlEditSales($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE
            $table SET id_client = :id_client, id_seller = :id_seller,
            products = :products, tax = :tax, net = :net, total = :total,
        mode_payment = :mode_payment WHERE code = :code");

        $stmt->bindParam(':code', $data['code'], PDO::PARAM_INT);
        $stmt->bindParam(':id_client', $data['id_client'], PDO::PARAM_INT);
        $stmt->bindParam(':id_seller', $data['id_seller'], PDO::PARAM_INT);
        $stmt->bindParam(':products', $data['products'], PDO::PARAM_STR);
        $stmt->bindParam(':tax', $data['tax'], PDO::PARAM_STR);
        $stmt->bindParam(':net', $data['net'], PDO::PARAM_STR);
        $stmt->bindParam(':total', $data['total'], PDO::PARAM_STR);
        $stmt->bindParam(':mode_payment', $data['mode_payment'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null; // Properly close the statement
            return 'ok';
        } else {
            $stmt = null; // Properly close the statement
            return 'error';
        }
    }

    /*=========================================
    DELETE SALE
    ==========================================*/
    /**
     *
     *
     * @param $table
     * @param $data
     * @return
     */
    static public function mdlDeleteSales($table, $data)
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

    /*=============================================
    DATES RANGE
    =============================================*/
    /**
     *
     *
     * @param $table
     * @param $initialDate
     * @param $finalDate
     * @return
     */
    static public function mdlSalesDatesRange($table, $initialDate, $finalDate)
    {
        if ($initialDate === null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            ORDER BY id ASC");

            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        } else if ($initialDate === $finalDate) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE date LIKE :date");

            $dateParam = "%$finalDate%";
            $stmt->bindParam(':date', $dateParam, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table
            WHERE date BETWEEN :initialDate AND :finalDate");

            $stmt->bindParam(':initialDate', $initialDate, PDO::PARAM_STR);
            $stmt->bindParam(':finalDate', $finalDate, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetchAll();

            $stmt = null; // Properly close the statement
            return $result;
        }
    }

    /*=============================================
    ADDING TOTAL SALES
    =============================================*/
    /**
     *
     *
     * @param $table
     * @return
     */
    static public function mdlAddingTotalSales($table)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(net) as total FROM $table");

        $stmt->execute();

        $result = $stmt->fetch();

        $stmt = null; // Properly close the statement
        return $result;
    }

     /*=============================================
    FETCHING SALES ID
    =============================================*/
    public static function mdlGetLastSaleDetails() {
    $stmt = Connection::connect()->prepare(
        "SELECT id, total FROM sales ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public static function mdlGetSaleItems($saleId) {
        $stmt = Connection::connect()->prepare(
            "SELECT description as name, quantity as qty, price 
            FROM sale_items WHERE sale_id = :sale_id"
        );
        $stmt->bindParam(":sale_id", $saleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public static function mdlGetLastSaleId() {
    // $stmt = Connection::connect()->prepare("SELECT id FROM sales ORDER BY id DESC LIMIT 1");
    // $stmt->execute();
    // return $stmt->fetchColumn();
}
