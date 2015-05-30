<?php
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Редактирование страницы</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="Введите заголовок" value="<?php echo $item->title ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8" placeholder="Введите текст"><?php echo $item->content ?></textarea>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" name="id" value="<?php echo $item->id; ?>"/>
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
            <?php
                echo SysWidget::build('WBtnAsk', $model, [
                    'link' => '/page/basic/delete?id=' . $item->id,
                    'ok_class' => 'btn btn-danger',
                ]);
            ?>
        </div>

    </form>
</div>