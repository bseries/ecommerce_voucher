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
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?=$this->form->create($item) ?>
		<?= $this->form->field('id', [
			'type' => 'hidden'
		]) ?>

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
			<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'button large save']) ?>
		</div>
	<?=$this->form->end() ?>
</article>