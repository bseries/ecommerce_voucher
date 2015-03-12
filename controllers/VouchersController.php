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

namespace ecommerce_voucher\controllers;

use ecommerce_voucher\models\VoucherTypes;
use li3_access\security\Access;

class VouchersController extends \base_core\controllers\BaseController {

	use \base_core\controllers\AdminIndexTrait;
	use \base_core\controllers\AdminAddTrait;
	use \base_core\controllers\AdminEditTrait;
	use \base_core\controllers\AdminDeleteTrait;

	protected function _selects($item = null) {
		$data = array_keys(Access::adapter('entity')->get());
		$skip = ['allowAll', 'denyAll', 'allowAnyUser', 'allowIp'];
		$rules = [];

		foreach ($data as $item) {
			if (in_array($item, $skip)) {
				continue;
			}
			$rules[$item] = $item;
		}
		$types = VoucherTypes::find('list');

		return compact('rules', 'types');
	}
}

?>