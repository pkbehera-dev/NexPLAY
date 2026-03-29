<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexPlay - Premium Game Hub</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/NexPLAY/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- jQuery (for convenience) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Dynamic Favicon -->
    <?php
    $fav_local = dirname(__DIR__) . '/assets/favicon.png';
    $fav_url = '/NexPLAY/assets/favicon.png';
    $fav_time = file_exists($fav_local) ? filemtime($fav_local) : '1';
    ?>
    <link rel="icon" type="image/png" href="<?php echo $fav_url . '?v=' . $fav_time; ?>">
</head>
<body>
