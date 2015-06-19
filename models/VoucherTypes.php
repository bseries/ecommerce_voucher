<?php
/**
 * eCommerce Voucher
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace ecommerce_voucher\models;

use lithium\util\Collection;

class VoucherTypes extends \base_core\models\Base {

	protected $_meta = [
		'connection' => false
	];

	protected static $_actsAs = [
		'base_core\extensions\data\behavior\Access'
	];

	protected static $_data = [];

	public static function register($name, array $data) {
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
		return $entity->title;
	}

	public function info($entity, $context, $format) {
		$handler = $entity->data('info');
		return $handler($context, $format);
	}

	public function redeem($entity, $user) {
		$handler = $entity->data('redeem');
		return $handler($user);
	}
}

?>