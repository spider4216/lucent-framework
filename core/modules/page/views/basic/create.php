<?php
use core\classes\cmessages;
?>

<h2>Создание страницы</h2>

<div class="form-group">
    <?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
        <div class="summary">
            <?php echo $messages; ?>
        </div>
    <?php endif; ?>

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