<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="/c/libs/jquery/jquery-1.11.3.min.js"></script>

    <link href="/c/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/c/libs/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link href="/c/css/main.css" rel="stylesheet" media="screen">
    <script src="/c/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="/c/libs/jquery/jquery.validate.js"></script>
    <script src="/c/js/form.validate.js"></script>
    <script src="/c/js/jQuery.approve.js"></script>
    <script src="/c/js/app.js"></script>
    <title>Freelance task manager</title>
</head>
<body>
<div class="container" >
    <div class="row">
        <div class="col-md-12" id="header">
            <h1 class="text-center"><?php if( isset($title) ) echo $title; ?></h1>
        </div>