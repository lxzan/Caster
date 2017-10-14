<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/18
 * Time: 22:48
 */

namespace App\Model;
use App\Lib\Util;

abstract class Model extends Db
{
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = CONF['database']['prefix'] . strtolower( class_basename(get_called_class()) );
    }

    public function getCount() {
        return $this->table;
        $sql = "SELECT COUNT(*) AS count FROM {$this->table}";
        $result = $this->fetchAll($sql);
        return intval($result[0]['count']);
    }
}