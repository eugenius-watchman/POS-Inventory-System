<?php

require_once '../../controllers/sales.controller.php';
require_once '../../models/sales.model.php';
require_once '../../controllers/clients.controller.php';
require_once '../../models/clients.model.php';
require_once '../../controllers/users.controller.php';
require_once '../../models/users.model.php';

$report = new ControlSales();
$report->ctrDownloadReport();