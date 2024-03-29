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

use CouponCode\CouponCode;
use ecommerce_voucher\ecommerce\voucher\Types;

class Vouchers extends \base_core\models\Base {

	protected $_meta = [
		'source' => 'ecommerce_vouchers'
	];

	protected $_actsAs = [
		'base_core\extensions\data\behavior\Timestamp',
		'base_core\extensions\data\behavior\Searchable' => [
			'fields' => [
				'code',
				'type',
				'uses_left'
			]
		]
	];

	public static function check($code) {
		$coupon = new CouponCode(['parts' => 3, 'partLength' => 4]);

		if (!$coupon->validate($code)) {
			return false;
		}
		$item = static::find('first', [
			'conditions' => [
				'code' => $coupon->normalize($code)
			]
		]);
		return $item && $item->uses_left > 0;
	}

	public static function generateCode() {
		return (new CouponCode(['parts' => 3, 'partLength' => 4]))->generate();
	}

	public function type($entity) {
		return Types::registry($entity->type);
	}

	// Redeems this voucher. Assumes that one voucher redeem counts one "use".
	public function redeem($entity, $user) {
		if ($entity->uses_left < 1) {
			return false;
		}
		if (!$entity->type()->redeem($user)) {
			return false;
		}
		return $entity->save([
			'uses_left' => $entity->uses_left - 1
		], ['whitelist' => ['uses_left']]);
	}
}

Vouchers::applyFilter('create', function($self, $params, $chain) {
	if ($params['options']['defaults'] && empty($params['data']['code'])) {
		$params['data']['code'] = Vouchers::generateCode();
	}
	return $chain->next($self, $params, $chain);
});


?>