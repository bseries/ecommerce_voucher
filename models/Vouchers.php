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

	/*
	public function isExpired($entity) {
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $entity->modified);
		return strtotime(Settings::read('checkout.expire'), $date->getTimestamp()) < time();
	}
	 */

	public static function check($code) {
		$coupon = new CouponCode(['parts' => 3, 'partLength' => 4]);

		if (!$coupon->validate($code)) {
			return false;
		}
		return (boolean) static::find('count', [
			'conditions' => [
				'code' => $coupon->normalize($code)
			]
		]);
	}

	public static function generateCode() {
		return (new CouponCode(['parts' => 3, 'partLength' => 4]))->generate();
	}

	public function type($entity) {
		return VoucherTypes::find('first', [
			'conditions' => ['id' => $entity->type]
		]);
	}
}

Vouchers::applyFilter('create', function($self, $params, $chain) {
	if ($params['options']['defaults'] && empty($params['data']['code'])) {
		$params['data']['code'] = Vouchers::generateCode();
	}
	return $chain->next($self, $params, $chain);
});


?>