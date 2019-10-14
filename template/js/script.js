$(document).ready(function(){
    var paginateBtn = $('.page-link');
    var readMore    = $('.post_read');
    var content     = $('#content');
    var loadBtn     = $('#load');

    paginateBtn.click(function (e) {
        e.preventDefault();

        var page = $(this).attr('data-page');

        $.ajax({
            url: "",
            method:"POST",
            dataType: "json",
            data: {page: page},

            success:function(response){
                var len = response.length;
                content.text('');

                for (var i = 0; i < len; i++) {
                    var id    = response[i].id;
                    var title = response[i].title;
                    var link  = response[i].link;
                    var text  = response[i].text;

                    var row = "<div class='col-md-6 post'>"+
                        "<h3>"  +
                            "<a class='post_title' target='_blank' href='" + link +"'>" + title + "</a>" +
                        "</h3>" +
                        "<p>" + text + "</p>" +
                        "<p>" +
                            "<a data-toggle='modal' data-target='#exampleModal' data-id='" + id + "' " +
                            "class='btn btn-secondary post_read' href='#' role='button'>Полный текст</a>" +
                        "</p>";

                    content.append(row);
                }

                window.history.pushState('/page/'+page, 'Hobby', '/page/'+page);

            }
        });
        return false;
    });

    // Обновление списка статей
    $("body").on('DOMSubtreeModified', "#content", function() {
        readMore = $('.post_read');
        readFullText(readMore);
    });

    // Просмотр полного текста статьи
    function readFullText(elem) {
        elem.click(function () {
            var post_id = $(this).attr('data-id');
            var modal   = $('#exampleModal .modal-body');

            $.ajax({
                url: "/modal/"+post_id,
                method: "POST",
                dataType: "json",
                data: {post_id: post_id},

                success:function(response){
                    modal.html(response);
                }, error: function (e) {
                    console.log(e.message);
                }
            });
        });
    }

    readFullText(readMore);

    loadBtn.click(function () {
        loadBtn.prop('disabled', true);
        $.ajax({
            url: "/load",
            method: "POST",
            dataType: "json",

            success:function(){
                location.reload();
            }, complete: function () {
                loadBtn.prop('disabled', false);
            }
        });
    })

});