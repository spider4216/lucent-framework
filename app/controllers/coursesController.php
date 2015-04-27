<?php
namespace app\controllers;

use app\models\Courses;

class CoursesController
{
    public function actionIndex()
    {
        echo 'Hello I am index action';
    }

    public function actionDemo()
    {
        $model = Courses::findAll();
        var_dump($model);
        echo "Hello. A am demo action";
    }
}

?>