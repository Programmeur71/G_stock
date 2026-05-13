<?php
require_once 'BaseController.php';
require_once '../Model/Produitdb.php';

class ProduitController extends Controller {
    public function __construct() { parent::__construct(new Produitdb()); }
}
