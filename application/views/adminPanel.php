
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/custom.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery-3.2.1.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/npm.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jsFile.js'); ?>"></script>
        <style type="text/css">
            .body{
                padding: 0;
                margin: 0;

            }   

            .menu{
                float: left;
                width: 180px; 
                height:auto;
                background-color: #262626;
                margin-left:0px;
                margin-top: 0px;
                padding: 0;


            }

            .btn-group{

                margin-top: 0px;
                padding: 0;
                float: left;
                width: 180px;
                height: auto;
                background-color: #262626;


            }

            h5{
                font-size: 15px;
                color: #ccc;
            }
            h5:hover{
                color: white;
            }
            .btn {
                margin-top: 0;
                padding: 0;
                float: top;
                background-color: #262626;
                width: 180px;
                height: 100px;

            }

            .dropdown-menu{
                margin: 0;
                padding: 0;
                top:25%;
                left: 100%;
                float: left;
                background-color:#282828;

            }


            .caret {

                color: #ccc;
                text-align: right;
            }
            #button_1,#button_2,#button_3,#button_4{
                text-decoration: none; 
            }
            #exTab1{
                margin-left:350px;
            }
            

            #cont_2{
                margin-left: 700px;
               
                float: top;
            }
            #numer_1
            {
                width: 70px;
            }

            #numer_2{
                width: 70px;
            }
            
            #numer_3{
                width: 70px;

            }
            #numer_4{
                width:70px;
            }
            #numer_5{
                width:70px;

            }
            #numer_6{
                width:70px;
            }
            #numer_1a
            {
                margin-left: 550px;
                margin-top: -1000px;
            }
            #dodaj{
                width: 100px;
                height: 35px;
                float: right;
                margin-right: 550px;

            }
            #dodaj_p{
                color: white;
            }
            #usun{
                width: 100px;
                height: 35px;
                float: right;
                margin-right: 550px;

            }
            #usun_p{
                color: white;
            }
            #edycja{
                width: 100px;
                height: 35px;
                float: right;
                margin-right: 550px;
            }
            #edycja_p{
                color:white;
            }
            #edycja_panel{
                width: 100px;
                height: 35px;
                float: right;
                margin-right: 550px;
               
            }
            #edycja_panel_p{
                color: white;
            }
            #pobierz{
                width: 250px;
                height: 35px;
                float: right;
                margin-right: 850px;
                margin-top: -30px;
            }
            #pobierz_p{
                color: white;
            }

            #informacja_o_zapisie{
                color: red;
            }
            #usun_t{
                width:  70px;
            }
            #textarea_1{
                width: 400px;
                height: 250px;
            }
            #textarea_2{
                width: 400px;
                height: 250px;
            }
            #cena{
                width: 80px;
            }
            #kaucja{
                width: 80px;
            }
            #panel_1
            {
                height: 350px;
            }
            #pobierz_1{
                width: 100px;
                height: 35px;
                margin-left: 300px;
                margin-top: -40px;
            }
           
            
           
            
        </style>
        <script type='text/javascript'>
            $(document).ready(function () {
                $("#numer_5").on('click', function () {
                    $("#form_7").submit();
                });
            });
            $(document).ready(function () {
                $("#numer_6").on('click', function () {
                    $("#form_7").submit();
                });
            });
           $(document).ready(function () {
                $("#pobierz").change('click', function () {
                    var plik=$('#pobierz').val().replace(/.*(\/|\\)/, '');
                    
                    
                    $('input[name=part_12]').val(plik);
                   
                    $.cookie('plik',plik,{expires:1,path:'/'});
                   
                    
                   $('img').attr('src','../../jpg/'+plik); 
                   
                });
               
            });
           
             


        </script>

    </head>
    <body>



        <div class="container-fluid ">
            <div class ="container "id="cont_2">
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                <h2>Dodawanie/usuwanie Stron Paneli</h2>
                </br>
                </br>
                <p id="informacja_o_zapisie"><?php echo $zapisano ?></p>
                </br><!-- Panel dodawania ston i paneli -->
                <?php
                $data = array('id' => 'form_1');
                echo form_open('index.php/DodajStronePanel/index', $data);
                ?>
                </br>
                <p>Dodawanie nowej strony/nowego panelu</p>
                </br>
                <div class="form-inline">
                    <p><?php
                        $data = array('name' => 'part_1', 'type' => 'number', 'value' => 1, 'max' => 20, 'min' => 1, 'id' => 'numer_1', 'class' => 'form-control');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Ilość stron z panelami</p>
                    <?php echo form_error('part_1') . '</br></br>'; ?>
                </div>
                </br>
                <div class="form-inline">
                    <p><p><?php
                        $data = array('name' => 'part_2', 'type' => 'number', 'value' => 6, 'max' => 12, 'min' => 1, 'id' => 'numer_2', 'class' => 'form-control');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Ilość paneli na stronie
                        <?php echo form_error('part_2') . '</br></br>'; ?>
                </div>
                <hr>
                <button class="btn btn-primary"id="dodaj">
                    <a href="#"><p id="dodaj_p">Zapisz</p></a>
                </button>
                <?php echo form_close(); ?>
                </br>
                </br><!-- Usuwanie stron -->
                <?php
                $data = array('id' => 'form_2');
                echo form_open('index.php/UsunStrone/index', $data);
                ?>
                </br>
                <p>Usuwanie Strony</p>
                </br>
                <div class="form-inline">
                    <p><?php
                        $data = array('name' => 'part_3', 'type' => 'text', 'class' => 'form-control', 'id' => 'usun_t');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Numer strony</p>
                    <?php echo form_error('part_3') . '</br></br>'; ?>
                </div>
                </br>

                <hr>
                <button class="btn btn-primary"id="usun">
                    <a href="#"><p id="usun_p">Zapisz</p></a>
                </button>
                <?php echo form_close(); ?>
                </br><!-- Panel edycji ilości stron i paneli -->
                </br>
                <?php
                $data = array('id' => 'form_3');
                echo form_open('index.php/DeletePanel', $data);
                ?>
                </br>
                <p>Edycja strony ilości paneli na stronie</p>
                </br>
                
                <div class="form-inline">
                    <p><?php
                        $data = array('name' => 'part_4', 'type' => 'number', 'value' => 1, 'max' => 20, 'min' => 1, 'id' => 'numer_3', 'class' => 'form-control');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Numer strony</p>
                    <?php echo form_error('part_4') . '</br></br>'; ?>
                </div>
                </br>
                <div class="form-inline">
                    <p><p><?php
                        $data = array('name' => 'part_5', 'type' => 'number', 'value' => 6, 'max' => 12, 'min' => 1, 'id' => 'numer_4', 'class' => 'form-control');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Numer panelu na stronie
                        <?php echo form_error('part_5') . '</br></br>'; ?>
                </div>
                
                </br>
                </br>
                <button class="btn btn-primary"id="edycja">
                    <a href="#"><p id="edycja_p">Zapisz</p></a>
                </button>
                <?php echo form_close(); ?>


                </br>
                </br>
                </br>
                <h2>Edycja Panelu</h2>
                </br>
                </br><!-- edycja panelu -->
                <p>Nagłowek panelu</p>
                <?php
                $data = array('id' => 'form_4');
                echo form_open('index.php/EdytujFormularz/index', $data);
                ?>
                <?php
                $data = array('name' => 'part_6', 'type' => 'textarea', 'id' => 'textarea_1', 'class' => 'textarea', 'value' => $naglowek_zdjecia);
                echo form_textarea($data);
                ?>
                <?php echo form_error('part_6') . '</br></br>'; ?>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                <p>Opis panelu</p>
                <?php
                $data = array('name' => 'part_9', 'type' => 'textarea', 'id' => 'textarea_2', 'class' => 'textarea', 'value' => $opis);
                echo form_textarea($data);
                ?>
                <?php echo form_error('part_9') . '</br></br>'; ?>
                </br>
               
                <p>Cena za dobę</p>
                 <?php
                $data = array('name' => 'part_13', 'type' => 'text', 'id' => 'cena', 'class' => 'form-control', 'value' => $cena);
                echo form_input($data);
                ?>
                <?php echo form_error('part_13') . '</br></br>'; ?>
                </br>
               
                <p>Kaucja</p>
                 <?php
                $data = array('name' => 'part_14', 'type' => 'text', 'id' => 'kaucja', 'class' => 'form-control', 'value' => $kaucja);
                echo form_input($data);
                ?>
                <?php echo form_error('part_14') . '</br></br>'; ?>
                
                <p> Zdjęcie</p>
                </br>
                </br>
                <div class="row" id="panel_1">
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img name="img" src="<?php echo base_url('jpg/'.$photo) ?>" alt="...">
                            <div class="caption">
                                <h3><?php echo $naglowek_zdjecia ?></h3>
                                <p id="p_o"><?php echo $opis ;?></p>
                            </div>
                        </div>
                    </div>
                </div>
               
                 <?php echo form_hidden('part_12')?>
                
                <button class="btn btn-primary"id="edycja_panel">
                    <a href="#"><p id="edycja_panel_p">Zapisz</p></a>
                </button>
            </form> 
              
                <?php $dane=array('id'=>'form_5');echo form_open_multipart('index.php/EdytujFormularz/upload',$dane);
                $dane = array('name' => 'userfile', 'class' => 'file', 'id' => 'pobierz', 'mulitiple'=>TRUE,'type'=>'file' );
                echo form_input($dane) ; 
                
                ?>
           
             
             <button class="btn btn-primary"id="pobierz_1">
                    <a href="#"><p id="pobierz_p">Pobierz</p></a>
                </button>
            
            </form>       
                <?php  $dane=array('id'=>'form_7'); echo form_open('index.php/EdytujFormularz/wyswietlanie',$dane);?>
                <div class=" form-inline" id="numer_1a">
                    <p><?php
                        $data = array('name' => 'part_7', 'type' => 'number', 'value' => $input, 'max' => 20, 'min' => 1, 'id' => 'numer_5', 'class' => 'form-control');

                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Numer strony</p>
                    <?php echo form_error('part_7') . '</br></br>'; ?>
                   
                    <p><?php
                        $data = array('name' => 'part_8', 'type' => 'number', 'value' => $input_1, 'max' => 12, 'min' => 1, 'id' => 'numer_6', 'class' => 'form-control');
                        echo form_input($data);
                        ?>&nbsp;&nbsp;&nbsp;Numer panelu</p>
                    <?php echo form_error('part_8') . '</br></br>'; ?>
                </div>
            </form>
            </div>



