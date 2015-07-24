%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $item->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo $item->name; ?>" class="form-control name" placeholder="Введите имя"/>
            <small>Наименование региона должно состоять из латинских букв и знаков подчеркивания</small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" name="id" value="<?php echo $item->id; ?>"/>
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
        </div>

    </form>
</div>