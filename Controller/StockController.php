<?php
require_once 'BaseController.php';
require_once '../Model/Stockdb.php';

class StockController extends Controller {
    public function __construct() { parent::__construct(new Stockdb()); }
}
