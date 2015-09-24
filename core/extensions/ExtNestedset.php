<?php

namespace core\extensions;

use core\classes\SysDatabase;

class ExtNestedset
{
    public static $tableName = '';

    public function __construct($table)
    {
        self::$tableName = 'nestedset_' . $table;
    }

    //fields - ['field name type']
    public function createDummy($fields = [])
    {
        $db = SysDatabase::getObj();
        $sql = '';

        $sql .= 'CREATE TABLE ' . self::$tableName;
        $sql .= '(';
            $sql .= 'id int NOT NULL AUTO_INCREMENT, ';
            $sql .= 'left_key int NOT NULL DEFAULT 0, ';
            $sql .= 'right_key int NOT NULL DEFAULT 0, ';
            $sql .= 'level int NOT NULL DEFAULT 0, ';
            $sql .= 'value text NOT NULL, ';
            $sql .= 'tree int NOT NULL DEFAULT 0, ';

            if (!empty($fields)) {
                foreach ($fields as $field) {
                    $sql .= $field . ',';
                }
            }

            $sql .= 'PRIMARY KEY (id), ';
            $sql .= 'INDEX left_key (left_key, right_key, level) ';

        $sql .= ');';

        return $db->execute($sql);
    }

    public function deleteDummy()
    {
        $db = SysDatabase::getObj();
        $sql = 'DROP TABLE ' . self::$tableName;

        return $db->execute($sql);
    }

    //data = ['column' => 'value', ... ]
    public function createRoot($name, $data = [])
    {
        $db = SysDatabase::getObj();
        $db->beginTransaction();

        $sql = '';

        $sql .= 'INSERT INTO ' . self::$tableName . ' ';

        $sql .= '(left_key, right_key, level, value';

        $params = [
            ':q1' => '1',
            ':q2' => '2',
            ':q3' => '0',
            ':q4' => $name,
        ];
        $indexParam = 5;
        $prepareStrValues = '';

        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $sql .= ', ' . $column;
                $params[':q' . $indexParam] = $value;
                $prepareStrValues .= ', :q' . $indexParam;

                $indexParam++;
            }
        }
        $sql .= ') ';


        $sql .= 'VALUES(:q1, :q2, :q3, :q4'.$prepareStrValues.');';
        //echo $sql;

        if (!$db->execute($sql, $params)) {
            $db->rollBack();
            return false;
        }

        $sql = '';
        $sql .= 'SELECT id FROM ' . self::$tableName . ' WHERE value = :v';

        $res1 = $db->query($sql, [
            ':v' => $name,
        ]);

        if (empty($res1)) {
            $db->rollBack();
            return false;
        }

        $id = $res1[0]->id;

        $sql = '';
        $sql .= 'UPDATE ' . self::$tableName . ' SET tree = :id WHERE id = :id';

        $res2 = $db->execute($sql, [
            ':id' => $id,
        ]);

        if (!$res2) {
            $db->rollBack();
            return false;
        }

        $db->commit();

        return true;
    }

    //todo возможно нужно добавить еще один параметр глубины, для более точного поиска
    //todo Сообщения об ошибах
    //data = ['column' => 'value', ... ] - т.к. nestedSet универсален, его использовать нужно в различных модулях
    public function appendChild($parentId, $name, $data = [])
    {
        $db = SysDatabase::getObj();
        $db->beginTransaction();

        $sql = 'SELECT right_key, level, tree FROM ' . self::$tableName . ' WHERE id = :id';
        $res1 = $db->query($sql, [
            ':id' => $parentId,
        ]);

        if (empty($res1)) {
            return false;
        }

        $rightKey = $res1[0]->right_key;
        $level = $res1[0]->level;
        $tree = $res1[0]->tree;

        $sql = '';
        $sql .= 'UPDATE ' . self::$tableName . ' SET ';
        $sql .= 'right_key = right_key + 2, ';
        $sql .= 'left_key = IF(left_key > :r, left_key + 2, left_key) WHERE right_key >= :r AND tree = :tree';

        $res2 = $db->execute($sql, [
            ':r' => $rightKey,
            ':tree' => $tree,
        ]);

        if (!$res2) {
            $db->rollBack();
            return false;
        }

        $sql = '';

        $sql .= 'INSERT INTO ' . self::$tableName . ' SET left_key = :r1, right_key = :r2, level = :lvl, value = :v, tree = :tree';

        $params = [
            ':r1' => $rightKey,
            ':r2' => $rightKey + 1,
            ':lvl' => $level + 1,
            ':v' => $name,
            ':tree' => $tree,
        ];

        $indexParam = 1;
        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $sql .= ', ' . $column . '=:' . $column;
                $params[':' . $column] = $value;
            }
        }

        $res3 = $db->execute($sql, $params);

        if (!$res3) {
            $db->rollBack();
            return false;
        }

        $db->commit();
        return true;
    }

    public function deleteNode($id)
    {
        $db = SysDatabase::getObj();
        $db->beginTransaction();

        $sql = 'SELECT right_key, left_key, tree FROM ' . self::$tableName . ' WHERE id = :id';
        $res1 = $db->query($sql, [
            ':id' => $id,
        ]);

        if (empty($res1)) {
            return false;
        }

        $rightKey = $res1[0]->right_key;
        $leftKey = $res1[0]->left_key;
        $tree = $res1[0]->tree;

        //DELETE FROM my_tree WHERE left_key >= $left_key AND right_ key <= $right_key

        $sql = 'DELETE FROM ' . self::$tableName . ' WHERE left_key >= :l AND right_key <= :r AND tree = :tree';
        $res2 = $db->execute($sql, [
            ':l' => $leftKey,
            ':r' => $rightKey,
            ':tree' => $tree,
        ]);

        if (!$res2) {
            $db->rollBack();
            return false;
        }

        $sql = '';
        $sql .= 'UPDATE ' . self::$tableName . ' SET left_key = IF(left_key > :l, left_key - (:r - :l + 1), '.
            'left_key), right_key = right_key - (:r - :l + 1) WHERE right_key > :r AND tree = :tree';

        $res3 = $db->execute($sql, [
            ':l' => $leftKey,
            ':r' => $rightKey,
            ':tree' => $tree,
        ]);

        if (!$res3) {
            $db->rollBack();
            return false;
        }

        $db->commit();
        return true;
    }

    public function findAllNodes()
    {
        $db = SysDatabase::getObj();

        $sql = 'SELECT id, value, level FROM ' . self::$tableName . ' ORDER BY tree, left_key';

        return $db->query($sql);
    }


}