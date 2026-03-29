<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexPlay Admin Dashboard</title>
    <!-- Bootstrap 5 CSS - Default Light Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            color: #212529; /* High-contrast text */
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        .admin-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* Increased contrast for links and buttons */
        a { color: #0056b3; text-decoration: underline; }
        a:hover { color: #003d82; }
        .btn { border-radius: 4px; font-weight: 500; }
        .btn-primary { background-color: #0056b3; border-color: #0056b3; }
        .btn-primary:hover { background-color: #004085; border-color: #003875; }
        .table { background-color: #fff; }
    </style>
    <!-- Dynamic Favicon -->
    <?php
    $fav_local = dirname(__DIR__, 2) . '/assets/favicon.png';
    $fav_url = '/NexPLAY/assets/favicon.png';
    $fav_time = file_exists($fav_local) ? filemtime($fav_local) : '1';
    ?>
    <link rel="icon" type="image/png" href="<?php echo $fav_url . '?v=' . $fav_time; ?>">
</head>
<body>
