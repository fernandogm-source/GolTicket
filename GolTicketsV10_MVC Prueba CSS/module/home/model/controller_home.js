function loadCategories() {

    ajaxPromise('module/home/controller/controller_home.php?op=homePageCategory', 'GET', 'JSON')
    .then(function(data) {
        console.log(data);

        for (let row = 0; row < data.length; row++) {
            const name = data[row].nombre_competicion;
            const icon = data[row].img_competicion;

            $('<div></div>')
                .addClass('category-card')
                .attr('id', 'cat_' + row)
                .appendTo('#containerCategories')
                .html(
                    '<div class="category-icon">' +
                        '<img class="logo-icon" src="'+icon+'">'   + 
                    '<span>' + name + '</span>'
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
