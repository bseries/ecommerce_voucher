<?php

use lithium\g11n\Message;

$t = function($message, array $options = []) {
	return Message::translate($message, $options + ['scope' => 'ecommerce_voucher', 'default' => $message]);
};

$this->set([
	'page' => [
		'type' => 'single',
		'title' => $item->code,
		'empty' => false,
		'object' => $t('voucher')
	]
]);

?>
<article>
	<?=$this->form->create($item) ?>
		<?php if ($item->exists()): ?>
			<?= $this->form->field('id', ['type' => 'hidden']) ?>
		<?php endif ?>

		<div class="grid-row">
			<div class="grid-column-left">
				<?= $this->form->field('code', [
					'type' => 'text',
					'label' => $t('Code')
				]) ?>
				<?= $this->form->field('type', [
					'type' => 'select',
					'label' => $t('Type'),
					'list' => $types
				]) ?>
			</div>
			<div class="grid-column-right">
				<?= $this->form->field('created', [
					'label' => $t('Created'),
					'disabled' => true,
					'value' => $item->exists() ? $this->date->format($item->created, 'datetime') : null
				]) ?>
				<?= $this->form->field('uses_left', [
					'type' => 'number',
					'label' => $t('Uses left')
				]) ?>
			</div>
		</div>

		<div class="bottom-actions">
			<div class="bottom-actions__left">
				<?php if ($item->exists()): ?>
					<?= $this->html->link($t('delete'), [
						'action' => 'delete', 'id' => $item->id
					], ['class' => 'button large delete']) ?>
				<?php endif ?>
			</div>
			<div class="bottom-actions__right">
				<?= $this->form->button($t('save'), [
					'type' => 'submit',
					'class' => 'button large save'
				]) ?>
			</div>
		</div>

	<?=$this->form->end() ?>
</article>