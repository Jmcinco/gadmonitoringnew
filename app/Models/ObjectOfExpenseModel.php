<?php
namespace App\Models;
use CodeIgniter\Model;
class ObjectOfExpenseModel extends Model
{
    protected $table = 'object_of_expense';
    protected $primaryKey = 'obj_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['object_name','uacs_code',];

}