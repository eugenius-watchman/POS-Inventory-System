<?php

/**
 *
 */
class Connection
{
    /**
     *
     */
    static public function connect()
    {
        // securing with PDO
        $link = new PDO('mysql:host=localhost;dbname=pos', 'root', '');

        //taking all characters
        $link->exec('set names utf8');

        return $link;
    }
}