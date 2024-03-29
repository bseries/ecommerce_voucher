<?php
/**
 * eCommerce Voucher
 *
 * Copyright (c) 2014 David Persson - All rights reserved.
 * Copyright (c) 2016 Atelier Disko - All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace ecommerce_voucher\models;

use lithium\util\Collection;

class VoucherTypes extends \base_core\models\Base {

	protected $_meta = [
		'connection' => false
	];

	protected $_actsAs = [
		'base_core\extensions\data\behavior\Access'
	];

	protected static $_data = [];

	public static function register($name, array $data) {
		trigger_error('Deprecated in favor of ecommerce\voucher\Types.', E_USER_DEPRECATED);

		$data += [
			'id' => $name,
			'name' => $name,
			'title' => null,
			'worth' => null,
			'access' => ['user.role:admin'],
			'info' => function($context, $format) {
				// Dependent on $format return either HTML or plaintext.
			},
			'redeem' => function($user) {
				// Do sth. with cart or invoice.
				// FIXME Pass in cart - if needed.
			}
		];
		$data['access'] = (array) $data['access'];
		static::$_data[$name] = static::create($data);
	}

	public static function find($type, array $options = []) {
		trigger_error('Deprecated in favor of ecommerce\voucher\Types.', E_USER_DEPRECATED);

		if ($type == 'all') {
			return new Collection(['data' => static::$_data]);
		} elseif ($type == 'first') {
			return static::$_data[$options['conditions']['id']];
		} elseif ($type == 'list') {
			$results = [];

			foreach (static::$_data as $item) {
				$results[$item->id] = $item->title();
			}
			return $results;
		}
	}

	public function title($entity) {
		trigger_error('Deprecated in favor of ecommerce\voucher\Types.', E_USER_DEPRECATED);
		return $entity->title;
	}

	public function info($entity, $context, $format) {
		trigger_error('Deprecated in favor of ecommerce\voucher\Types.', E_USER_DEPRECATED);
		$handler = $entity->data('info');
		return $handler($context, $format);
	}

	public function redeem($entity, $user) {
		trigger_error('Deprecated in favor of ecommerce\voucher\Types.', E_USER_DEPRECATED);
		$handler = $entity->data('redeem');
		return $handler($user);
	}
}

?>