<?php

$this->set([
	'page' => [
		'type' => 'single',
		'title' => $item->token,
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
				<div class="compound-users">
					<?php
						$user = $item->exists() ? $item->user() : false;
					?>
					<?= $this->form->field('user_id', [
						'type' => 'select',
						'label' => $t('User'),
						'list' => $users,
						'class' => !$user || !$user->isVirtual() ? null : 'hide'
					]) ?>
					<?= $this->form->field('virtual_user_id', [
						'type' => 'select',
						'label' => false,
						'list' => $virtualUsers,
						'class' => $user && $user->isVirtual() ? null : 'hide'
					]) ?>
					<?= $this->form->field('user.is_real', [
						'type' => 'checkbox',
						'label' => $t('real user'),
						'checked' => $user ? !$user->isVirtual() : true
					]) ?>
				</div>
			</div>
		</div>

		<div class="grid-row grid-row-last">
			<div class="grid-column-left">
				<?= $this->form->field('token', [
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
			</div>
		</div>

		<div class="bottom-actions">
			<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'button large save']) ?>
		</div>
	<?=$this->form->end() ?>
</article>