<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/custom.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <script type="text/javascript" src="dist/js/bootstrap.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="dist/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="dist/js/npm.js"></script>
    </head>
    <body>

       
        <div class="container text-center ">
           
            <h1><?php echo $tresc ?></h1>
            </br>
            </br>
            
            <div class="container ">
                <?php
                $dane = array('class' => 'form-group ');
                echo form_open('index.php/Sprawdzenie/index', $dane);

                $dane = array('class' => 'input-lagrge input-sm text-center', 'name' => 'login', 'placeholder' => 'Login', 'value' => set_value('login'));
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('login') . '</br></br>'; ?></span>

                <?php $dane = array('class' => 'input-lagrge input-sm text-center', 'name' => 'password', 'placeholder' => 'Hasło', 'value' => set_value('password'));
                echo form_password($dane);
                ?><span class="text-danger"><?php echo form_error('password') . '</br></br>'; ?></span>
<?php $dane = array('class' => 'btn btn-primary', 'name' => 'submit', 'type' => 'submit', 'value' => 'Zaloguj', 'content' => 'Zaloguj');
?>
                </br>
                </br>
                <a href="<?php echo base_url('index.php/Page1/index'); ?>">Dodaj nowego użytkownika</a>
                </br>
                <hr>
                <?php
                echo form_button($dane);
                echo form_close();
                ?>
            </div>
           