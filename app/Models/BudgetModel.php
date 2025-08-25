<?php
namespace App\Models;
use CodeIgniter\Model;

class BudgetModel extends Model
{
    protected $table = 'budget';
    protected $primaryKey = 'act_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'plan_id',
        'obj_id',
        'src_id',
        'particulars',
        'amount',
        'type_of_expense'
    ];
    protected $returnType = 'array';

    public function getBudgetItems()
    {
        return $this->select('budget.*, object_of_expense.object_name, source_of_fund.source_name, plan.activity as gad_activity, CONCAT("GAD", LPAD(plan.plan_id, 3, "0")) as gad_activity_id')
                    ->join('object_of_expense', 'object_of_expense.obj_id = budget.obj_id', 'left')
                    ->join('source_of_fund', 'source_of_fund.src_id = budget.src_id', 'left')
                    ->join('plan', 'plan.plan_id = budget.plan_id', 'left')
                    ->findAll();
    }
}