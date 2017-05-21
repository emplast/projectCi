<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('datepicker/css/bootstrap-datepicker.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('datepicker/css/bootstrap-datepicker.min.css') ?>">
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery-3.2.1.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery.formatCurrency-1.4.0.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/npm.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jsFile.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('datepicker/js/bootstrap-datepicker.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('datepicker/js/bootstrap-datepicker.pl.min.js'); ?>"></script>

        <style type="text/css">
            #cont_1{
                height: 650px;

            }
            #cont_2{
                float: left;
                height: 370px;

            }
            #cont_3{
                display: none;
            }
            #cont_4{
                display: none;
            }
            #alert{
                color: red;
            }
            #marka{
                border:none;
                width: 250px;
                
            }
            #datepicker{
                width: 150px;

            }
            #datepicker_1{
                width: 150px;

            }
            #cena_h{
                margin-left: 25px;
                
            }
            #kaucja_h{
                margin-left: 25px;
            }
            #cena{
                width:35px; 
                border:none;
            }
            #kaucja{
                width: 35px;
                border:none;
            }
            #imie{
                width: 150px;
                margin-left: 60px;
            }
            #nazwisko{
                width: 150px;
                margin-left: 30px;
            }
            #email{
                width: 150px;
                margin-left: 50px;
            }
            #miejscowosc{
                width: 150px;
                margin-left: 10px;

            }

            #kod{
                width: 150px;
                margin-left: -2px;
            }
            #ulica{
                width: 150px;
                margin-left: 70px;
            }
            #nr_domu{
                width: 75px;
                
            }
            #nr_mieszkania{
                width: 75px;
                
            }
            
            #login{
                margin-left: 50px;
                width: 150px;
            }
            #haslo{
                margin-left: 50px;
                width: 150px;

            }
            
            #wartosc{
                width: 100px;
                color: red;
                border:none;

            }
            #dni{
                width: 50px;
                border: none;
            }

        </style>
    </head>
    <body>
        <script type="text/javascript">
            $(function () {
                $("#datepicker").datepicker({
                    format: 'dd/mm/yyyy',
                    language: "pl",
                    todayBtn: true,
                    todayHighlight: true,
                    orientation: 'auto bottom',
                    autoclose: true,

                });
             

            });

            $(function () {


                $("#datepicker_1").datepicker({
                    format: 'dd/mm/yyyy',
                    language: "pl",
                    orientation: 'auto bottom',
                    autoclose: true,

                });


                $('#datepicker_1').change('click', function () {
                    var a = $("#datepicker").datepicker('getDate').getTime(),
                            b = $("#datepicker_1").datepicker('getDate').getTime(),
                            c = 24 * 60 * 60 * 1000,
                            diffDays = Math.round(Math.abs((a - b) / (c))),
                            wartosc = diffDays *<?php echo $cena ?> +<?php echo $kaucja ?>;

                    $('#wartosc').val(wartosc);
                    
                    $('#dni').val(diffDays);
                    $.ajax({
                        type: 'post',
                        url: "page.php",
                        data: {'#wartosc':wartosc,'#dni':diffDays},
                        dataType: 'html',
                        success: function (msg) {
                            $('#warosc').html(msg);
                            $('#dni').html(msg);

                        }
                    });
                    
                   

                });

            });

            $(function () {
                $("#bez").on('click', function () {
                    $('#cont_3').fadeToggle();
                   
                    
                });
            });

        </script>
        <div class="container text-center"id="cont_1">
            <?php echo form_open('index.php/Page/'.$form,array('id'=>'form_'.$form))?>
                </br>
                </br>
                </br>
                <p id="alert"><?php echo $alert;?></p>
                <div class="form text-left">
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img src="<?php echo base_url('jpg/' . $photo) ?>" alt="...">
                            <div class="caption form-inline">

                            </div>
                        </div>
                        </br>


                        <p>Liczba dni:&nbsp<?php echo form_input(array('type'=>'value','name'=>'dni','class'=>'form-inline','id'=>'dni','value'=>$_POST['dni']));?></p>
                        <p>Cena za dobe:&nbsp<?php echo form_input(array('type'=>'value','id'=>'cena','name'=>'cena','class'=>'form-inline','readonly'=>'false','value'=>$cena)) ?>&nbspw PLN</p>
                        <p>Kaucja:&nbsp<?php echo form_input(array('type'=>'value','id'=>'kaucja','name'=>'kaucja','class'=>'form-inline','readonly'=>'false','value'=>$kaucja)) ?>&nbspw PLN</p>
                        <hr>
                        <p style="display:inline">Do zapłaty:&nbsp;<h2 style="display:inline" ><?php echo form_input(array('class'=>'form-inline text-center','type'=>'text','id'=>'wartosc','name'=>'wartosc','readonly'=>'false','value'=>$wartosc))?></h2>&nbsp;PLN</p>
                        </br>
                        </br>
                        <input type="submit" value="<?php echo $wynajem ?>" class="btn btn-danger"id="wynajem">
                    </div>

                </div>
                <div class="caption"id="cont_2">
                    <h4>Samochód marki:<span> <?php echo form_input(array('id'=>'marka' ,'class'=>'form','name'=>'marka','type'=>'text','value'=>$marka));?></span></h4>
                    </br>
                    <div class="form-group form-inline ">
                        <p>Od&nbsp;<?php echo form_input(array('type'=>'text','id'=>'datepicker','class'=>'form-control','name'=>'start'))?>&nbsp;
                            Do&nbsp;<?php echo form_input(array('type'=>'text','id'=>'datepicker_1','class'=>'form-control','name'=>'end'))?></p>
                    </div>
                    </b
                    </br></br>
                    <h4 id="cena_h"> Cena za dobę brutto&nbsp;<?php echo $cena?>&nbsp;w PLN</h4>
                    </br>
                    <h4 id="kaucja_h">Kaucja w wysokości&nbsp;<?php echo $kaucja ?>&nbsp;w PLN</h4>
                    <br>
                    <p><a href="#" id="bez"><?php echo $wynajem ?> bez rejstracji</a></p>
                    </br>

                </div>
                <div class="caption" id="cont_3" >
                    <div class="form-group form-inline">
                        <h4> Dane Osobowe</h4>
                        <p>Imię&nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'imie','name'=>'imie','placeholder'=>'Imie'))?></p>
                        <p>Nazwisko&nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'nazwisko','name'=>'nazwisko','placeholder'=>'Nazwisko'));?></p>
                        <p>E-mail:&nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'email','name'=>'email','placeholder'=>'E-mail'));?></p>
                        <p>Miejscowość &nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'miejscowosc','name'=>'miejscowosc','placeholder'=>'Miejscowość'));?></p>
                        <p>Kod pocztowy &nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'kod','name'=>'kod','placeholder'=>'00-000'));?></p>
                        <p>ul. &nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'ulica','name'=>'ulica','placeholder'=>'Ulica'));?></p>
                        <p>Nr domu &nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'nr_domu','name'=>'nr_domu','placeholder'=>'Nr domu'));?>&nbsp;
                            Nr mieszkania &nbsp;<?php echo form_input(array('class'=>'form-control','type'=>'text','id'=>'nr_mieszkania','name'=>'nr_mieszkania','placeholder'=>'Nr mieszkania'));?></p>
                        
                    </div>
                </div>


            </form>