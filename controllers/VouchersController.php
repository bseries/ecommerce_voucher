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

namespace ecommerce_voucher\controllers;

use ecommerce_voucher\ecommerce\voucher\Types as VoucherTypes;
use li3_access\security\Access;

class VouchersController extends \base_core\controllers\BaseController {

	use \base_core\controllers\AdminIndexTrait;
	use \base_core\controllers\AdminAddTrait;
	use \base_core\controllers\AdminEditTrait;
	use \base_core\controllers\AdminDeleteTrait;

	protected function _selects($item = null) {
		$rules = array_combine(
			$keys = array_keys(Access::adapter('entity')->get()),
			$keys
		);
		$types = VoucherTypes::enum();

		return compact('rules', 'types');
	}
}

?>