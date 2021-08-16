    jQuery(document).ready( function( $ ) {
            let data = {
                action: 'get_related_post',
                category_post: ajaxDataSend.category_post
            };

            let locationHref = location.href;
            let locationHost  = location.protocol + '//' + location.host;
            let strForCut = locationHref.substr(locationHost.length);

            if (strForCut != '/' ){
                jQuery.post(ajaxDataSend.url, data, function (response) {
                    drawRelatedPosts(response);
                });
            }
    });

    function drawRelatedPosts(relatedPostsHTML){
            let divForRelatedPosts = document.getElementById("site-footer");
            divForRelatedPosts.insertAdjacentHTML('beforebegin',JSON.parse(relatedPostsHTML));
    }