<?php
/**
 * Boutique Voucher
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

class VoucherCodes extends \cms_core\models\Base {

	protected $_meta = [
		'source' => 'ecommerce_voucher_codes'
	];

	protected static $_actsAs = [
		'cms_core\extensions\data\behavior\Timestamp'
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

	public function type($entity) {
		return Vouchers::find('first', [
			'conditions' => ['id' => $entity->type]
		]);
	}

	public static function generateCode() {
		return (new CouponCode(['parts' => 3, 'partLength' => 4]))->generate();
	}
}

VoucherCodes::applyFilter('create', function($self, $params, $chain) {
	if ($params['options']['defaults'] && empty($params['data']['code'])) {
		$params['data']['code'] = VoucherCodes::generateCode();
	}
	return $chain->next($self, $params, $chain);
});


?>