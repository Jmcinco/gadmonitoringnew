<?php
namespace App\Models;

use CodeIgniter\Model;

class DivisionModel extends Model
{
    protected $table = 'divisions';
    protected $primaryKey = 'div_id';
    protected $allowedFields = ['div_code', 'division'];
    protected $returnType = 'object'; // Return results as objects to match view's $division->division syntax
}