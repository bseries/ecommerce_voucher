<?php
/**
 * eCommerce Voucher
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * Licensed under the AD General Software License v1.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *
 * You should have received a copy of the AD General Software
 * License. If not, see https://atelierdisko.de/licenses.
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