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

	public static function generateCode() {
		return (new CouponCode(['parts' => 3, 'partLength' => 4]))->generate();
	}
}

VoucherCodess::applyFilter('create', function($self, $params, $chain) {
	if (empty($params['data']['code'])) {
		$params['data']['code'] = VoucherCodess::generateCode();
	}
	return $chain->next($self, $params, $chain);
});


?>