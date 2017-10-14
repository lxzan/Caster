<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/15
 * Time: 15:56
 */
namespace App\Model;
use App\Lib\Paginator;
use App\Lib\Util;

class Db
{
    public $client;
    public $redis;
    public function __construct()
    {
        $this->redis = new \Predis\Client();
        $dbConf = Util::getConfig('database', 'mysql');
        $this->client = new \mysqli($dbConf['host'], $dbConf['user'], $dbConf['password'], $dbConf['database']);
    }

    public function query($sql, $data = []) {
        foreach ($data as $key => $value) {
            $value = "'" . addslashes($value) . "'";
            $sql = str_replace($key, $value, $sql);
        }
        return $this->client->query($sql);
    }

    public function fetchAll($sql, $data = []) {
        return $this->query($sql, $data)->fetch_all(MYSQLI_ASSOC);
    }

    public function insertOnUpdate($table, $data, $uniqueKeys) {
        $keys = [];
        foreach ($keys as $key) {
            $keys[$key] = true;
        }

        $columns = array_keys($data);
        $values = [];
        foreach ($data as $key => $value) $values[] = addslashes($value);

        $updates = [];
        foreach ($data as $key => $value) {
            if ( !isset($keys[$key]) ) {
                $updates[] = "$key = '" . addslashes($value) . "'";
            }
        }
        $updatesStr = implode(', ', $updates);

        $columnsStr = implode(", ", $columns);
        $valuesStr = "'" . implode("', '", $values) . "'";
        $sql = "INSERT INTO $table ($columnsStr) VALUES ($valuesStr) ON DUPLICATE KEY UPDATE $updatesStr";
        return $this->query($sql);
    }

    public function insert($table, $data) {
        $columns = array_keys($data);
        $values = [];
        foreach ($data as $key => $value) $values[] = addslashes($value);

        $columnsStr = implode(", ", $columns);
        $valuesStr = "'" . implode("', '", $values) . "'";
        $sql = "INSERT INTO $table ($columnsStr) VALUES ($valuesStr)";
        return $this->query($sql);
    }

    public function update($table, $data, $condition) {
        $updates = [];
        foreach ($data as $key => $value) {
            if ( !isset($keys[$key]) ) {
                $updates[] = "$key = '" . addslashes($value) . "'";
            }
        }
        $updatesStr = implode(', ', $updates);
        $sql = "UPDATE $table SET $updatesStr WHERE " . self::where($condition);
        return $this->query($sql);
    }

    public function delete($table, $condition) {
        $sql = "DELETE FROM $table WHERE " . self::where($condition);
        return $this->query($sql);
    }

    public function paginate($sql, $per = 20) {
        $currentPage = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $get = $_GET;
        unset($get['page']);
        $urlPattern = '?page=(:num)';
        if(!empty($get)) $urlPattern .= ('&' . http_build_query($get));
        $sql1 = preg_replace('/FROM/i', ', COUNT(*) AS `!count` FROM', $sql, 1);
        $total = intval($this->fetchAll($sql1)[0]['!count']);
        $render = new Paginator($total, $per, $currentPage, $urlPattern);

        $start = $per * ($currentPage - 1);
        $sql .= " LIMIT $start, $per";
        $data = $this->fetchAll($sql);
        return [
            'render' => $render,
            'data' => $data
        ];
    }

    /**
     * eg. $condition =[ ['name', 'caster'], ['age', '18', '>'] ]
     * @param $condition
     * @return string
     */
    public static function where($condition) {
        $where = [];
        foreach ($condition as $item) {
            $item[1] = addslashes($item[1]);
            if(count($item) == 2) $item[] = '=';
            $item[1] = addslashes($item[1]);
            $where[] = "{$item[0]} {$item[2]} '{$item[1]}'";
        }
        return implode(' AND ', $where);
    }

    public function getInsertID() {
        return $this->client->insert_id;
    }

    public static function prepare($sql, $data = []) {
        $keys = array_keys($data);
        usort($keys, function ($a, $b) {
            return strlen($a) < strlen($b);
        });
        foreach ($keys as $key) {
            $value = "'" . addslashes($data[$key]) . "'";
            $sql = str_replace($key, $value, $sql);
        }
        return $sql;
    }
}