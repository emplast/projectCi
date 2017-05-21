<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/custom.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery-3.2.1.min.js') ?>"/></script>
         <script type="text/javascript" src="<?php echo base_url('dist/js/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/pagination.js') ?>"></script>

    <style type="text/css">

    </style>


</head>
<body>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#li_1a").on('click', function () {
                var all = <?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                var panel = <?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;

                for (i = -1; i <= all; i++) {
                    $('#A_' + i).css('display', 'none');

                }
                for (i = 0; i <= panel - 1; i++) {
                    $('#A_' + i).show();

                }

            });
        });



        $(document).ready(function () {
            $("#li_4a").on('click', function () {
                var all = <?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                var panel = <?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;


                $('#li_4a').addClass('active');

                for (i = 0; i <= all; i++) {
                    $('#A_' + i).css('display', 'none');

                }
                for (i = 0; i <= panel - 1; i++) {
                    $('#A_' + i).show();

                }
            });
        });
        $(document).ready(function () {
            $("#li_5a").on('click', function () {
                var all =<?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;
                var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;

                $('#li_5a').addClass('active');

                for (i = 0; i <= all; i++) {
                    $('#A_' + i).css('display', 'none');

                }
                for (i = panel; i <= panel_1 - 1; i++) {
                    $('#A_' + i).show();

                }
            });
        });

        $(document).ready(function () {
            $("#li_6a").on('click', function () {

                var all =<?php $formularz = new PanelAplikacja_model();
echo (int) $formularz->iloscPaneli();
?>;
                var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;
                var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2)) + ($formularz->iloscPaneliNaStronie(3));
?>;


                $('#li_6a').addClass('active');

                for (i = 0; i <= all; i++) {
                    $('#A_' + i).css('display', 'none');

                }
                for (i = panel; i <= panel_1 - 1; i++) {
                    $('#A_' + i).show();

                }

            });
        });

        $(document).ready(function () {
            if ($('#li_4a').is('.active')) {
                var all = <?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                var panel = <?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;

                for (i = 0; i <= all; i++) {
                    $('#A_' + i).css('display', 'none');

                }
                for (i = 0; i <= panel - 1; i++) {
                    $('#A_' + i).show();

                }
            }
        });

        $(document).ready(function () {
            $("#li_25a").on('click', function () {
                if ($('#li_5a').hasClass('active')) {
                    var all =<?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                    var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;
                    var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;

                    for (i = 0; i <= all; i++) {
                        $('#A_' + i).css('display', 'none');

                    }
                    for (i = panel; i <= panel_1 - 1; i++) {
                        $('#A_' + i).show();

                    }
                }
            });
        });

        $(document).ready(function () {
            $("#li_25a").on('click', function () {
                if ($('#li_6a').hasClass('active')) {
                    var all =<?php $formularz = new PanelAplikacja_model();
echo (int) $formularz->iloscPaneli();
?>;
                    var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;
                    var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2)) + ($formularz->iloscPaneliNaStronie(3));
?>;

                    for (i = 0; i <= all; i++) {
                        $('#A_' + i).css('display', 'none');

                    }
                    for (i = panel; i <= panel_1 - 1; i++) {
                        $('#A_' + i).show();

                    }
                }
            });
        });

        $(document).ready(function () {
            $("#li_2a").on('click', function () {
                if ($('#li_4a').hasClass('active')) {
                    var all = <?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                    var panel = <?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;

                    for (i = 0; i <= all; i++) {
                        $('#A_' + i).css('display', 'none');

                    }
                    for (i = 0; i <= panel - 1; i++) {
                        $('#A_' + i).show();

                    }
                }
            });
        });

        $(document).ready(function () {
            $("#li_2a").on('click', function () {
                if ($('#li_5a').hasClass('active')) {
                    var all =<?php $formularz = new PanelAplikacja_model();
echo $formularz->iloscPaneli();
?>;
                    var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1));
?>;
                    var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;

                    for (i = 0; i <= all; i++) {
                        $('#A_' + i).css('display', 'none');

                    }
                    for (i = panel; i <= panel_1 - 1; i++) {
                        $('#A_' + i).show();

                    }
                }
            });
        });

        $(document).ready(function () {
            $("#li_2a").on('click', function () {
                if ($('#li_6a').hasClass('active')) {
                    var all =<?php $formularz = new PanelAplikacja_model();
echo (int) $formularz->iloscPaneli();
?>;
                    var panel =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2));
?>;
                    var panel_1 =<?php $formularz = new PanelAplikacja_model();
echo $ilosc_paneli = ($formularz->iloscPaneliNaStronie(1)) + ($formularz->iloscPaneliNaStronie(2)) + ($formularz->iloscPaneliNaStronie(3));
?>;

                    for (i = 0; i <= all; i++) {
                        $('#A_' + i).css('display', 'none');

                    }
                    for (i = panel; i <= panel_1 - 1; i++) {
                        $('#A_' + i).show();

                    }
                }
            });
        });


    </script>
    <div class="container">



