<?php
namespace App\Models;
use CodeIgniter\Model;
class SourceOfFundModel extends Model
{
    protected $table = 'source_of_fund';
    protected $primaryKey = 'src_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['source_name','fund_cluster'];
}