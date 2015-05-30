<?php

namespace core\classes;

/**
 * Class Cfile_manager
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Класс для работы с файлами
 */
class SysFileManager {

    /**
     * @param $path
     * @return array
     * Сканирует директорию и возвращает содержимое
     */
    public function scanDir($path)
    {
        $items = scandir($path);

        $list = [];
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $list[] = $item;
            }
        }

        return $list;
    }

    /**
     * @param $src - откуда
     * @param $dst - куда
     * @return bool
     * Рекурсивное копиование указанной директории
     */
    public function recurse_copy($src,$dst)
    {
        if (file_exists($dst)) {
            return false;
        }

        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
        return true;
    }
}