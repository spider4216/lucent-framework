<h2>Список страниц</h2>

<div class="pages-list">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>
                    <span>Наименование</span>
                </th>
            </tr>
        </thead>
        <?php foreach ($content as $item) : ?>
            <tbody>
                <tr>
                    <td>
                        <span><?php echo $item->title; ?></span>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>