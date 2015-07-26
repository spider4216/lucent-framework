<?php
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo $model->name; ?>"
                   class="form-control name" placeholder="Введите имя"/>
            <small>Наименование блока должно состоять из латинских букв и/или знаков подчеркивания</small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <br/>
            <textarea name="content" id="content" class="form-control" placeholder="Введите содержимое"
                      rows="8"><?php echo $model->content; ?></textarea>
        </div>
        <br/>

        <hr/>

        <?php if (!empty($regions)): ?>
            <div class="m-row">
                <label for="region_id"><?php echo $model->getLabel('region_id'); ?></label>
                <br/>
                <select name="region_id" id="region" class="form-control">
                    <option value="none">не выбран</option>
                    <?php foreach($regions as $region): ?>
                        <option value="<?php echo $region->id; ?>" <?php echo ($region->id == $regionSelected) ?
                            'selected' : '' ?>><?php echo $region->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br/>
        <?php endif; ?>

        <div class="m-row">
            <label for="weight"><?php echo $model->getLabel('weight'); ?></label>
            <br/>
            <input type="number" class="form-control" name="weight" placeholder="Вес" min="0" max="99"
                   maxlength="99" value="<?php echo $model->weight; ?>" />
        </div>
        <br/>

        <div class="m-row">
            <input type="hidden" name="id" value="<?php echo $model->id; ?>"/>
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
            <?php
            echo SysWidget::build('WBtnAsk', $model, [
                'link' => '/blocks/general/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>