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

use base_core\extensions\cms\Panes;
use lithium\g11n\Message;

extract(Message::aliases());

Panes::register('ecommerce.vouchers', [
	'title' => $t('Vouchers', ['scope' => 'ecommerce_voucher']),
	'url' => ['controller' => 'Vouchers', 'action' => 'index', 'library' => 'ecommerce_voucher', 'admin' => true],
	'weight' => 5
]);

?>