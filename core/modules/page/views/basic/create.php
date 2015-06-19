<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

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