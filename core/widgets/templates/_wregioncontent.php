<div class="region-<?php echo $data['regionName']; ?>">
	<?php foreach ($data['items'] as $blocks): ?>
		<?php foreach ($blocks as $block): ?>
			<?php $isMenu = $block instanceof \core\modules\menu\models\Menu ? true : false; ?>

			<div class="block block-<?= $block->id; ?> thumbnail <?= $isMenu ? 'block-menu' : ''; ?>">
				<?php if ('admin' == \core\classes\SysAuth::getCurrentRole()): ?>
					<?php if (!$isMenu): ?>
						<div class="edit pull-right">
							<a href="/blocks/general/update/?id=<?php echo $block->id; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
						</div>
					<?php else: ?>
						<div class="edit pull-right">
							<a href="/menu/general/manage/?id=<?php echo $block->id; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="caption">
					<div class="title">
						<h3><?php echo $block->name; ?></h3>
					</div>

					<div class="content">
						<?php if (!$isMenu): ?>
							<?php echo $block->content; ?>
						<?php endif; ?>

						<?php if ($isMenu): ?>
							<?php
							$nestedSet = new \core\extensions\ExtNestedset($block->machine_name);
							$data = $nestedSet->findAllNodes();
							?>

							<?php if (!empty($data)): ?>
								<ul>
									<?php foreach ($data as $link): ?>
										<li><a href="<?= $link->link; ?>"><?= $link->value; ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>