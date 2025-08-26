<?php
session_start();

echo "<h2>Session Debug Information</h2>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Session Data:\n";
print_r($_SESSION);
echo "</pre>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=pgms', 'root', '');
    echo "<h3>Database Connection: SUCCESS</h3>";
    
    // Check user data
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT emp_id, role_id, div_id FROM employees WHERE emp_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>User Database Data:</h3>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        // Check plans
        $stmt = $pdo->prepare("SELECT plan_id, activity, authors_division FROM plan WHERE status != 'deleted' ORDER BY plan_id DESC LIMIT 5");
        $stmt->execute();
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Recent Plans:</h3>";
        echo "<pre>";
        print_r($plans);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<h3>Database Error: " . $e->getMessage() . "</h3>";
}
?>
