<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #dc3545; }
        p { color: #333; }
    </style>
</head>
<body>
    <h1>Oops! Something Went Wrong</h1>
    <p><?php echo $message; ?></p>
    <?php if (ENVIRONMENT !== 'production'): ?>
        <details>
            <summary>Debug Information</summary>
            <pre><?php echo $exception; ?></pre>
        </details>
    <?php endif; ?>
</body>
</html>