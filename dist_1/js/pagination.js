/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function (event) {

    $('#li_3a').on('click', function () {

        $('#form_1').hide();
        $('#cont_1').hide();
        $('#form_2').show();
        $('#cont_2').show();






        $('#cont_2').append('<form action="#" id="form_2"></form>');

        $('<div id="div_1_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');
        $('<div id="div_2_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');
        $('<div id="div_3_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');
        $('<div id="div_4_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');
        $('<div id="div_5_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');
        $('<div id="div_6_a" class="col-sm-6 col-md-4"></div>').appendTo('#cont_2');

        $('<div class="thumbnail"id="t1_a"></div>').appendTo('#div_1_a');
        $('<div class="thumbnail" id="t2_a"></div>').appendTo('#div_2_a');
        $('<div class="thumbnail" id="t3_a"></div>').appendTo('#div_3_a');
        $('<div class="thumbnail" id="t4_a"></div>').appendTo('#div_4_a');
        $('<div class="thumbnail" id="t5_a"></div>').appendTo('#div_5_a');
        $('<div class="thumbnail"id="t6_a"></div>').appendTo('#div_6_a');

        $('<img id="zd_1_a"src="" alt="">').appendTo('#t1_a');
        $('<img id="zd_2_a"src="" alt="">').appendTo('#t2_a');
        $('<img id="zd_3_a"src="" alt="">').appendTo('#t3_a');
        $('<img id="zd_4_a"src="" alt="">').appendTo('#t4_a');
        $('<img id="zd_5_a"src="" alt="">').appendTo('#t5_a');
        $('<img id="zd_6_a"src="" alt="">').appendTo('#t6_a');

        $('<div class="caption" id="cap_1_a"></div>').appendTo('#zd_1_a');
        $('<div class="caption" id="cap_2_a"></div>').appendTo('#zd_2_a');
        $('<div class="caption" id="cap_3_a"></div>').appendTo('#zd_3_a');
        $('<div class="caption" id="cap_4_a"></div>').appendTo('#zd_4_a');
        $('<div class="caption" id="cap_5_a"></div>').appendTo('#zd_5_a');
        $('<div class="caption" id="cap_6_a"></div>').appendTo('#zd_6_a');

        $('<h3 id="ha_1_a">Thumbnail label_1a</h3>').appendTo('#cap_1_a');
        $('<h3 id="ha_2_a">Thumbnail label_2a</h3>').appendTo('#cap_2_a');
        $('<h3 id="ha_3_a">Thumbnail label_3a</h3>').appendTo('#cap_3_a');
        $('<h3 id="ha_4_a">Thumbnail label_4a</h3>').appendTo('#cap_4_a');
        $('<h3 id="ha_5_a">Thumbnail label_5a</h3>').appendTo('#cap_5_a');
        $('<h3 id="ha_6_a">Thumbnail label_6a</h3>').appendTo('#cap_6_a');

        $('#cap_1_a').append('<p id=" pa_1_a"></p>');
        $('#cap_2_a').append('<p id=" pa_2_a"></p>');
        $('#cap_3_a').append('<p id=" pa_3_a"></p>');
        $('#cap_4_a').append('<p id=" pa_4_a"></p>');
        $('#cap_5_a').append('<p id=" pa_5_a"></p>');
        $('#cap_6_a').append('<p id=" pa_6_a"></p>');

        $('#cap_1_a').append('<p id="pa_1_aa"></p>');
        $('#cap_2_a').append('<p id="pa_2_aa"></p>');
        $('#cap_3_a').append('<p id="pa_3_aa"></p>');
        $('#cap_4_a').append('<p id="pa_4_aa"></p>');
        $('#cap_5_a').append('<p id="pa_5_aa"></p>');
        $('#cap_6_a').append('<p id="pa_6_aa"></p>');

        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_1_aa');
        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_2_aa');
        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_3_aa');
        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_4_aa');
        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_5_aa');
        $('<a href="#" class="btn btn-primary" role="button">Button</a>').appendTo('#pa_6_aa');

    });
    event.stopPropagation();
    location.reload();

});
$(document).ready(function () {

    $('#li_2a').on('click', function () {

        $('#form_1').show();
        $('#cont_1').show();
        $('#form_2').hide();
        $('#cont_2').hide();

    });


}); 
