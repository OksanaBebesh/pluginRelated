
jQuery(document).ready( function( $ ) {
    console.log(myajaxData)
        var data = {
            action: 'get_related_post',
            category_post: myajaxData.category_post
        };

        jQuery.post(myajaxData.url, data, function (response) {
            const obj = JSON.parse(response);
            console.log(obj);
            drawRelatedPosts(obj);
        });
    });

function drawRelatedPosts(jsonInfo){
    //version 1
    // let divMain = document.getElementById("primary");
    // let responseDiv = document.createElement("div");
    // document.getElementById("block-2").textContent = JSON.parse(jsonInfo);



    //version 2
    let divMain = document.getElementById("primary");
    jsonInfo.forEach(function(value){
        let responseDiv = document.createElement("div");
        responseDiv.innerHTML = "<hr>";
        responseDiv.innerHTML = responseDiv.innerHTML + "<div><H2>" + value['post_title'] + "</H2></div>";
        responseDiv.innerHTML = responseDiv.innerHTML + "<div>" + value['post_content'] + "</div>";
        responseDiv.innerHTML = responseDiv.innerHTML + "<div>" + value['post_date'] + "</div>";
        responseDiv.innerHTML = responseDiv.innerHTML + "<hr>";
        divMain.appendChild(responseDiv);
    })

}