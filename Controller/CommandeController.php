<?php
require_once 'BaseController.php';
require_once '../Model/Commandedb.php';

class CommandeController extends Controller {
    public function __construct() { parent::__construct(new Commandedb()); }
}
