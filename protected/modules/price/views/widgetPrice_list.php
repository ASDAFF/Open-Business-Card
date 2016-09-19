<?php if ($price) : ?>
	<table class="price-list-table">
		<tr>
			<th><?php echo $model->getAttributeLabel('№'); ?></th>
			<th><?php echo $model->getAttributeLabel('name'); ?></th>
			<th><?php echo $model->getAttributeLabel('cost'); ?></th>
		</tr>

		<?php $i = 0;?>
		<?php foreach ($price as $item) : ?>
			<?php if ($item->name) : ?>
				<tr>
					<td colspan="4" class="text-align-center price-field-separator">
						<strong>
							<?php echo ($item->name) ? CHtml::encode($item->name) : '-' ?>
						</strong>
					</td>
				</tr>
			<?php endif; ?>
			<?php if (isset($item->price) && count($item->price)) : ?>
				<?php foreach($item->price as $price) : ?>
					<?php
					$isBold = ($price->is_bold == 1) ? true : false;
					?>
					<tr>
						<td class="price-field-n">
							<?php if ($isBold) : ?>
							<strong>
								<?php endif; ?>

								<?php echo ++$i;?>

								<?php if ($isBold) : ?>
							</strong>
						<?php endif; ?>
						</td>
						<td class="price-field-name">
							<?php if ($isBold) : ?>
							<strong>
								<?php endif; ?>

								<?php echo ($price->name) ? CHtml::encode($price->name) : '' ?>

								<?php if ($isBold) : ?>
							</strong>
						<?php endif; ?>
						</td>
						<td class="price-field-cost">
							<?php if ($isBold) : ?>
							<strong>
								<?php endif; ?>

								<?php echo ($price->cost) ? CHtml::encode($price->cost) : '' ?>

								<?php if ($isBold) : ?>
							</strong>
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
<?php endif; ?>