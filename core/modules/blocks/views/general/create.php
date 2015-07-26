%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="/blocks/general/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="Введите имя"/>
            <small>Наименование блока должно состоять из латинских букв и/или знаков подчеркивания</small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <br/>
            <textarea name="content" id="content" class="form-control" placeholder="Введите содержимое"
                      rows="8"></textarea>
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
                        <option value="<?php echo $region->id; ?>"><?php echo $region->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br/>
        <?php endif; ?>

        <div class="m-row">
            <label for="weight"><?php echo $model->getLabel('weight'); ?></label>
            <br/>
            <input type="number" class="form-control" name="weight" placeholder="Вес" min="0" max="99"
                   maxlength="99" value="0" />
        </div>
        <br/>

        <div class="m-row">
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
        </div>

    </form>
</div>