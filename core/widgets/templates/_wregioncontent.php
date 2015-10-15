<div class="region-<?php echo $data['regionName']; ?>">
	<?php foreach ($data['items'] as $type => $blocks): ?>
		<?php foreach ($blocks as $block): ?>
			<div class="block block-<?= $type; ?> thumbnail">
				<?php if ('admin' == \core\classes\SysAuth::getCurrentRole()): ?>

					<?php if ($type == 'content_block'): ?>
						<div class="edit pull-right">
							<a href="/blocks/general/update/?id=<?= $block['id']; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
						</div>
					<?php endif; ?>

					<?php if ($type == 'menu_block'): ?>
						<div class="edit pull-right">
							<a href="/menu/general/manage/?id=<?= $block['id']; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
						</div>
					<?php endif; ?>

					<?php if ($type == 'collection_block'): ?>
						<div class="edit pull-right">
							<a href="/page/collection/update/?id=<?= $block['id']; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
						</div>
					<?php endif; ?>

				<?php endif; ?>

				<div class="caption">
					<?php if (isset($block['title'])): ?>
						<div class="title">
							<h3><?= $block['title'] ?></h3>
						</div>
					<?php endif; ?>

					<div class="content">

						<?php if ($type == 'content_block'): ?>
							<?php echo $block['content']; ?>
						<?php endif; ?>

						<?php if ($type == 'menu_block'): ?>
							<?php if (!empty($block['content'])): ?>
								<ul>
									<?php foreach ($block['content'] as $link): ?>
										<li><a href="<?= $link->link; ?>"><?= $link->value; ?></a></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ($type == 'collection_block'): ?>
							<?php foreach ($block['content'] as $content): ?>
								<div class="panel panel-default">
									<div class="panel-heading"><?= $content['title'] ?></div>
									<div class="panel-body">
										<?= $content['content'] ?>
									</div>
									<div class="panel-footer">
										<a href="/page/basic/view?id=<?= $content['id'] ?>"><?= _("more") ?></a>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>

					</div>

				</div>

			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>