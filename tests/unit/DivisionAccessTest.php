<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Traits\DivisionAccessTrait;

class DivisionAccessTest extends CIUnitTestCase
{
    use DivisionAccessTrait;
    
    protected $session;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->session = \Config\Services::session();
    }
    
    public function testCanAccessPlanWithSameDivision()
    {
        // Set user division in session
        $this->session->set('div_id', 1);
        
        // Test access to plan from same division
        $result = $this->canAccessPlan(1);
        
        $this->assertTrue($result, 'User should be able to access plan from their own division');
    }
    
    public function testCannotAccessPlanFromDifferentDivision()
    {
        // Set user division in session
        $this->session->set('div_id', 1);
        
        // Test access to plan from different division
        $result = $this->canAccessPlan(2);
        
        $this->assertFalse($result, 'User should not be able to access plan from different division');
    }
    
    public function testCannotAccessPlanWithoutDivision()
    {
        // Clear division from session
        $this->session->remove('div_id');
        
        // Test access to any plan
        $result = $this->canAccessPlan(1);
        
        $this->assertFalse($result, 'User without division should not be able to access any plan');
    }
    
    public function testGetUserDivisionId()
    {
        // Set user division in session
        $this->session->set('div_id', 5);
        
        $result = $this->getUserDivisionId();
        
        $this->assertEquals(5, $result, 'Should return correct user division ID');
    }
    
    public function testCanViewAllDivisionsAsAdmin()
    {
        // Set admin role in session
        $this->session->set('role_id', 4);
        
        $result = $this->canViewAllDivisions();
        
        $this->assertTrue($result, 'Admin should be able to view all divisions');
    }
    
    public function testCannotViewAllDivisionsAsNonAdmin()
    {
        // Set non-admin role in session
        $this->session->set('role_id', 1);
        
        $result = $this->canViewAllDivisions();
        
        $this->assertFalse($result, 'Non-admin should not be able to view all divisions');
    }
    
    protected function tearDown(): void
    {
        // Clean up session
        $this->session->destroy();
        parent::tearDown();
    }
}
