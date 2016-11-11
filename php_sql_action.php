<?php

class DB_driver {

    private $__conn;

    function connect() {
        if (!$this->__conn) {
            $this->__conn = mysqli_connect('localhost', 'root', '', 'projet_lo07') or die('Erreur de connection');
            mysqli_set_charset($this->__conn, "utf8");
            mysqli_query($this->__conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        }
    }

    function dis_connect() {
        if ($this->__conn) {
            mysqli_close($this->__conn);
        }
    }

    function insert($table, $data) {
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" .$value . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        return mysqli_query($this->__conn, $sql);
    }

    function update($table, $data, $where) {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . $value . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return mysqli_query($this->__conn, $sql);
    }

    function remove($table, $where) {
        $this->connect();
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->__conn, $sql);
    }

    function get_list($sql) {
        $this->connect();
        $result = mysqli_query($this->__conn, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai'.$sql);
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    function get_row($sql) {
        $this->connect();

        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            die('Câu truy vấn bị sai'.$sql);
        }

        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        if ($row) {
            return $row;
        }

        return false;
    }

    function nombre_row($sql) {
        $this->connect();
        $result = mysqli_query($this->__conn, $sql);
        $return = mysqli_num_rows($result);
         if (!$result) {
            die('Câu truy vấn bị sai'.$sql);
        }
        mysqli_free_result($result);

        return $return;
    }

}

?>