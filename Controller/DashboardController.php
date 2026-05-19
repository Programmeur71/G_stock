<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Dashboarddb.php';

class DashboardController extends Controller {
    public function __construct() { parent::__construct(new Dashboarddb()); }

    public function getStatsAction() {
        $stats = $this->model->getStats();
        $this->sendJson($stats);
    }
}
