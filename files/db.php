<?php

function db_select($table, $condition = null)
{

    global $conn;

    $sql = "SELECT * FROM $table ";

    if ($condition != null) {
        $sql .= $condition;
    }

    $res = $conn->query($sql);
    $rows = [];

    while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;

}