<?php
require_once 'BaseController.php';
require_once '../Model/Fournisseurdb.php';

class FournisseurController extends Controller {
    public function __construct() { parent::__construct(new Fournisseurdb()); }
}
