

jQuery(document).ready( function( $ ) {
    console.log(myajaxData)
        var data = {
            action: 'get_related_post',
            category_post: myajaxData.category_post
        };

        jQuery.post(myajaxData.url, data, function (response) {
            alert('Получено с сервера: ' + response);
        });
    });






