/**
 * Created by Luiz Eduardo on 17/05/2016.
 */

$(function () {
    alert('aaaaa');
    $("#actions li").on('click', function () {
        elementlist = $(this).parent;
        alert('Element ' + elementlist.index(this) + ' was clicked');
    });
});