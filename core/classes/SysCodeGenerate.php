<?php
namespace core\classes;


class SysCodeGenerate
{
    //of course I have to keep that sort of data in json or something like that. Need to rewrite
    public static function dbFile($db_name, $db_username, $db_password, $db_host = 'localhost')
    {
        $tpl = "<?php";
            $tpl .= " return [";
                $tpl .= "'db_name' => '" . $db_name . "',";
                $tpl .= "'db_username' => '" . $db_username . "',";
                $tpl .= "'db_password' => '" . $db_password . "',";
                $tpl .= "'db_host' => '" . $db_host . "',";
            $tpl .= "];";
        $tpl .= "?>";

        return $tpl;
    }

    public static function configMain($projectName, $lang = 'en')
    {
        $tpl = "<?php";
            $tpl .= " return [";
                $tpl .= "'project_name' => '".$projectName."',";
                $tpl .= "'project_system_name' => 'lucent',";
                $tpl .= "'lang' => '".$lang."',";
                $tpl .= "'default_controller' => 'home',";
                $tpl .= "'default_action' => 'index',";

                $tpl .= "'system_tables' => [";
                    $tpl .= "'users' => 'users',";
                    $tpl .= "'roles' => 'roles'";
                $tpl .= "],";


                $tpl .= "'path' => [";
                    $tpl .= "'migration_directory' => 'app/migrations',";
                $tpl .= "],";

            $tpl .= "];";
        $tpl .= "?>";

        return $tpl;
    }


}