$(document).ready(function () {
    //Смена картинки-статуса информации в siteinfo
    $('.btn-warning').bind('click', function () {
        $(this).removeClass('btn-warning glyphicon-hourglass');
        $(this).addClass('btn-success glyphicon-ok');
    });

});


