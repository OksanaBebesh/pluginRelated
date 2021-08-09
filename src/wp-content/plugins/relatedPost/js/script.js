
jQuery(document).ready(function ($) {
    const urlPost = new URL(location.href);
    var slug = urlPost.pathname;
    slug = slug.replaceAll('/', '');
    var data = {
        action: 'my_action',
        postCategory: myajax.postCategory,
        postTerms: myajax.postTerms
    };
    // с версии 2.8 'ajaxurl' всегда определен в админке
    jQuery.post(myajax.url, data, function (response) {
        console.log('response:');
        console.log(response);
    });


});
