<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Создание страницы</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<div class="form-group">

    %system_notifications%

    <form action="/page/basic/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="Введите заголовок"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8" placeholder="Введите текст"></textarea>
            <br/>
        </div>

        <div class="m-row">
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
        </div>

    </form>
</div>