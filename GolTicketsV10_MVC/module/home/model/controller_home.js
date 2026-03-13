function loadCategories() {
    //console.log('loadCategories() called');

    ajaxPromise('module/home/controller/controller_home.php?op=homePageCategory','GET', 'JSON')
    .then(function(data) {
        console.log(data);

        for (let row = 0; row < data.length; row++) {
            $('<div></div>')
                .addClass("user_card")
                .attr('id', data[row].event_id)
                .appendTo('#containerCategories')
                .html(
                    "<div class='item-main'>" +
                        "<h3 class='user-name'>" + data[row].event_competition + "</h3>" +
                    "</div>"
                );
        }
    }).catch(function() {
        //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
    });
}

$(document).ready(function () {
    //console.log('controller_home.js loaded');

    loadCategories();
});
