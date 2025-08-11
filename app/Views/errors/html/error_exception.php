<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h1 class="alert-heading">An Error Occurred</h1>
            <p><strong>Error:</strong> <?php echo $message; ?></p>
            <p><strong>File:</strong> <?php echo $file; ?> (Line: <?php echo $line; ?>)</p>
            <p>Please contact the administrator or try again later.</p>
            <a href="<?php echo base_url(); ?>" class="btn btn-primary">Return to Home</a>
        </div>
        <?php if (ENVIRONMENT === 'development'): ?>
            <h3>Stack Trace</h3>
            <pre><?php echo $trace; ?></pre>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>