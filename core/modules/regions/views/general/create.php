%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="/regions/general/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="Введите имя"/>
            <small>Наименование региона должно состоять из латинских букв и знаков подчеркивания</small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
        </div>

    </form>
</div>