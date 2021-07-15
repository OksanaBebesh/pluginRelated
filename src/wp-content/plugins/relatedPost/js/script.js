

$(document).ready( function( $ ){
    console.log('yes')
    var data = {
        action: 'my_action',
        whatever: 1234
    };

    // с версии 2.8 'ajaxurl' всегда определен в админке
    $.post( ajaxurl, data, function( response ){
        alert( 'Получено с сервера: ' + response );
    } );
} )


let body  = new FormData();
body.append('action','myaction');



('/wp-admin/admin-ajax.php',{
    method:'POST',
    body
}).then(result => {
    console.log(result.text());
})