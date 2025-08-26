# Division-Based Access Control Implementation

## Overview
This document outlines the implementation of division-based access control for GAD Plans in the PGMS system. The changes ensure that users can only access GAD Plan data from their own division while retaining all existing functionalities.

## Changes Made

### 1. Created Division Access Trait (`app/Traits/DivisionAccessTrait.php`)
A reusable trait that provides division-based access control methods:

- **`canAccessPlan($planAuthorsDivision)`**: Checks if current user can access a specific plan
- **`getUserDivisionId()`**: Gets the current user's division ID from session
- **`addDivisionFilter($builder, $divisionColumn)`**: Adds division filter to query builder
- **`canViewAllDivisions()`**: Checks if user is admin (can view all divisions)
- **`applyDivisionFilter($builder, $planTableAlias)`**: Applies division filtering with admin bypass

### 2. Updated Controllers

#### GadPlanController (`app/Controllers/GadPlanController.php`)
- Added `DivisionAccessTrait`
- Modified `index()` method to filter GAD plans by user's division
- Updated `getGadPlan($id)` method to check division access before returning plan data

#### MemberController (`app/Controllers/MemberController.php`)
- Added `DivisionAccessTrait`
- Updated `dashboard()` method to filter all statistics by division:
  - Total plans count
  - Pending plans count
  - Approved plans count
  - Returned plans count
  - Recent plans list
- Modified `planReview()` method to show only plans from user's division

#### FocalController (`app/Controllers/FocalController.php`)
- Added `DivisionAccessTrait`
- Updated `dashboard()` method to filter all statistics and queries by division:
  - Total plans count
  - Plans by status counts
  - Budget calculations
  - Recent plans list
- Modified `planPreparation()` method to filter GAD plans by division
- Updated `generateReport()` method to include division filtering
- Modified `planReview()` method to filter plans by division
- Updated file attachment retrieval to respect division access
- **Budget Crafting functionality**:
  - Modified `budgetCrafting()` method to filter budget items and plans by division
  - Updated `addBudgetItem()` method to check plan division access before adding budget items
  - Modified `editBudgetItem()` method to verify both budget item and plan division access
  - Updated `deleteBudgetItem()` method to check budget item division access before deletion

### 3. Updated Models

#### FocalModel (`app/Models/FocalModel.php`)
- Modified `getGadPlansWithAmount($divisionId = null)` to accept optional division parameter
- Updated `getGadPlans($divisionId = null)` to accept optional division parameter for Budget Crafting
- Added division filtering when parameter is provided

#### MemberModel (`app/Models/MemberModel.php`)
- Modified `getGadPlansWithAmount($divisionId = null)` to accept optional division parameter
- Added division filtering when parameter is provided

#### BudgetModel (`app/Models/BudgetModel.php`)
- Modified `getBudgetItems($divisionId = null)` to accept optional division parameter
- Added `belongsToDivision($budgetId, $divisionId)` method to check budget item division ownership
- Added division filtering for budget item retrieval

### 4. Access Control Logic

#### Division-Based Filtering Rules:
1. **Regular Users**: Can only see GAD plans where `authors_division` matches their `div_id`
2. **Admin Users** (role_id = 4): Can see all GAD plans from all divisions
3. **Users without Division**: Cannot access any GAD plans

#### Session Requirements:
- User must have `div_id` in session (set during login)
- User must have `role_id` in session to determine admin status

### 5. Database Queries Modified

All database queries that retrieve GAD plan and budget data now include division filtering:
- Plan listing queries
- Dashboard statistics
- Report generation
- Individual plan retrieval
- File attachment access
- **Budget Crafting queries**:
  - Budget item listing
  - Budget item creation validation
  - Budget item editing validation
  - Budget item deletion validation

### 6. Backward Compatibility

All existing functionalities are preserved:
- ✅ Plan creation and editing
- ✅ Plan approval workflow
- ✅ Budget management and Budget Crafting
- ✅ Budget item creation, editing, and deletion
- ✅ Report generation
- ✅ File attachments
- ✅ Dashboard statistics
- ✅ User roles and permissions

### 7. Security Enhancements

- **Data Isolation**: Users can only access data from their division
- **Admin Override**: Administrators maintain full system access
- **Session Validation**: All access checks use session-based division information
- **Query-Level Filtering**: Division filters applied at database query level

## Testing

Created unit tests in `tests/unit/DivisionAccessTest.php` to verify:
- ✅ Users can access plans from their own division
- ✅ Users cannot access plans from other divisions
- ✅ Users without division cannot access any plans
- ✅ Admin users can access all divisions
- ✅ Session-based division retrieval works correctly

## Implementation Benefits

1. **Data Security**: Ensures division-level data isolation
2. **Maintainable Code**: Reusable trait for consistent access control
3. **Performance**: Query-level filtering reduces unnecessary data retrieval
4. **Flexibility**: Admin users retain full access for system management
5. **Transparency**: Clear access control logic that's easy to understand and modify

## Usage Instructions

### For Developers:
1. Use `DivisionAccessTrait` in any controller that needs division-based access control
2. Call `applyDivisionFilter($builder, $tableAlias)` on query builders
3. Use `canAccessPlan($divisionId)` for individual plan access checks

### For System Administrators:
- Admin users (role_id = 4) can access all divisions
- Regular users are automatically restricted to their division
- Division assignment is managed through the user management system

## Files Modified

1. `app/Traits/DivisionAccessTrait.php` (NEW)
2. `app/Controllers/GadPlanController.php`
3. `app/Controllers/MemberController.php`
4. `app/Controllers/FocalController.php`
5. `app/Models/FocalModel.php`
6. `app/Models/MemberModel.php`
7. `app/Models/BudgetModel.php`
8. `tests/unit/DivisionAccessTest.php` (NEW)

## Conclusion

The division-based access control has been successfully implemented across the entire GAD Plan system. Users can now only access data from their own division while maintaining all existing system functionalities. The implementation is secure, maintainable, and provides appropriate administrative overrides.
