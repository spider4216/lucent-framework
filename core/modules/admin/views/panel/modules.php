<?php
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

<div class="panel panel-default modules-panel">
    <div class="panel-body">
        <div class="col-xs-4">
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab"><?= locale::t("System modules"); ?></a></li>
					<li><a href="#tab2" data-toggle="tab"><?= locale::t("User modules"); ?></a></li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane active" id="tab1">
						<div class="system-list">
							<div class="list-group">
								<?php foreach ($systemModules as $module): ?>
									<a href="#" class="list-group-item disabled">
										<h4 class="list-group-item-heading"><?= $module['name']; ?></h4>
										<p class="list-group-item-text"><?= $module['description']; ?></p>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="tab2">
						<div class="system-list">
							<div class="list-group">
								<?php if (!empty($appModules)): ?>
									<?php foreach ($appModules as $module): ?>
										<a href="#" class="list-group-item disabled">
											<h4 class="list-group-item-heading"><?= $module['name']; ?></h4>
											<p class="list-group-item-text"><?= $module['description']; ?></p>
										</a>
									<?php endforeach; ?>
								<?php else: ?>
									<p><?= locale::t("Modules does not exist"); ?></p>
								<?php endif; ?>

							</div>
						</div>
					</div>

				</div>
			</div>

        </div>

        <div class="col-xs-8">
            <div class="description">
                <div class="page-header">
                    <h1>Lucent Store <small><?= locale::t("modules shop"); ?></small></h1>
                </div>

                <div class="content">
                    <p><?= locale::t("iframe here"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>