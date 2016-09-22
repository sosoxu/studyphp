/**
 * Created by sosoxu on 2016/9/21.
 */


console.log('test js');

$(document).ready(function(){
    console.log('test jquery');
    setTimeout(function () {
        $("#fjzt").load('/fjzttable.php?page=5');
        //$.ajax({url:'/fjzttable.php?page=3'});
    }, 5000);
});