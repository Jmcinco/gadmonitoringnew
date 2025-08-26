<?php

namespace App\Traits;

trait DivisionAccessTrait
{
    /**
     * Check if the current user can access a GAD plan based on their division
     * 
     * @param int $planAuthorsDivision The division ID of the plan's author
     * @return bool True if user can access the plan, false otherwise
     */
    protected function canAccessPlan($planAuthorsDivision)
    {
        $userDivisionId = $this->session->get('div_id');
        
        // If user doesn't have a division ID, deny access
        if (!$userDivisionId) {
            return false;
        }
        
        // User can only access plans from their own division
        return (int)$userDivisionId === (int)$planAuthorsDivision;
    }
    
    /**
     * Get the current user's division ID from session
     * 
     * @return int|null The user's division ID or null if not found
     */
    protected function getUserDivisionId()
    {
        return $this->session->get('div_id');
    }
    
    /**
     * Add division filter to a database query builder
     * 
     * @param object $builder The database query builder
     * @param string $divisionColumn The column name for division (default: 'authors_division')
     * @return object The modified query builder
     */
    protected function addDivisionFilter($builder, $divisionColumn = 'authors_division')
    {
        $userDivisionId = $this->getUserDivisionId();
        
        if ($userDivisionId) {
            $builder->where($divisionColumn, $userDivisionId);
        }
        
        return $builder;
    }
    
    /**
     * Check if user has access to view all divisions (Admin role)
     * 
     * @return bool True if user can view all divisions
     */
    protected function canViewAllDivisions()
    {
        $roleId = $this->session->get('role_id');
        
        // Admin role (role_id = 4) can view all divisions
        return (int)$roleId === 4;
    }
    
    /**
     * Apply division-based filtering to GAD plans query
     * 
     * @param object $builder The database query builder
     * @param string $planTableAlias The alias for the plan table (default: 'p')
     * @return object The modified query builder
     */
    protected function applyDivisionFilter($builder, $planTableAlias = 'p')
    {
        // Admin can see all plans
        if ($this->canViewAllDivisions()) {
            return $builder;
        }
        
        $userDivisionId = $this->getUserDivisionId();
        
        if ($userDivisionId) {
            $builder->where($planTableAlias . '.authors_division', $userDivisionId);
        }
        
        return $builder;
    }
}
