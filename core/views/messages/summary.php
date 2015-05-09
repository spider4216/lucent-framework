<?php if (isset($messages) && !empty($messages)): ?>
    <?php foreach ($messages as $type => $messageArr): ?>
        <?php if ('danger' == $type): ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($messageArr as $message): ?>
                    <p>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span><?php echo $message; ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ('warning' == $type): ?>
            <div class="alert alert-warning" role="alert">
                <?php foreach ($messageArr as $message): ?>
                    <p>
                        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span><?php echo $message; ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ('info' == $type): ?>
            <div class="alert alert-info" role="alert">
                <?php foreach ($messageArr as $message): ?>
                    <p>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span><?php echo $message; ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ('success' == $type): ?>
            <div class="alert alert-success" role="alert">
                <?php foreach ($messageArr as $message): ?>
                    <p>
                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span><?php echo $message; ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>