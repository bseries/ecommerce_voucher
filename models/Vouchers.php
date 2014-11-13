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

use CouponCode\CouponCode;
use ecommerce_voucher\models\VoucherTypes;

class Vouchers extends \base_core\models\Base {

	protected $_meta = [
		'source' => 'ecommerce_vouchers'
	];

	protected static $_actsAs = [
		'base_core\extensions\data\behavior\Timestamp'
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
		return VoucherTypes::find('first', [
			'conditions' => ['id' => $entity->type]
		]);
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