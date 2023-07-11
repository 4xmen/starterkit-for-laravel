require('./sortable');

try {
    require('jquery-autocomplete/jquery.autocomplete');
} catch (e) {
    console.log(e.message);
}


function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}

jQuery(function () {

    $("#main-menu .toggle").click(function () {
      $("#main-menu").toggleClass('show-menu');
      $(window).scrollTop(0);
      if($("#main-menu").hasClass('show-menu')){
          $("#main-menu .toggle").html('<i class="fa fa-times"></i>');
      }else{
          $("#main-menu .toggle").html('<i class="fa fa-bars"></i>');
      }
    });
    $("#main-menu .search").click(function () {
        $("#main-menu li:not(.search)").hide();
        $("#main-menu-search").show();
        $("#main-menu-search").focus();
        $(this).css({
            'padding':0,
            'display':'block',
            'float':'none',
        }).find('.fa').hide();
    });
    $("#main-menu-search").blur(function () {
        $("#main-menu li:not(.search)").removeAttr('style');
        $("#main-menu-search").hide();
        $("#main-menu .search").removeAttr('style');
        $("#main-menu .search .fa").show();
    });

    $("#main-menu-search").keyup(function (e) {
        if(e.keyCode == 13){
            window.location.href = search_url + $(this).val();
        }
        if(e.keyCode == 27){
            $("#main-menu-search").blur();
        }
    });

    cates = $("#cat-sort").sortable({
        onDrop: function ($item, container, _super) {
            _super($item, container);
            var data = cates.sortable("serialize").get();

            var jsonString = JSON.stringify(data, null, ' ');

            $('#sorted').val(jsonString);
        }
    });
    $("#cat-sort-save").click(function () {
        var url = $("#cat-sort-store").val();
        if ($('#sorted').val() == '[]'){
            alertify.warning('Not save any thing');
            return;
        }
        axios.post(url, {'info': $('#sorted').val()}).then(function (e) {
            if (e.data["OK"] == true) {
                alertify.success(e.data.msg);
            }
        });
    });
    try {
        var group = $("#menu-manage").sortable({
            group: 'no-drop',
            onDragStart: function ($item, container, _super) {
                // Duplicate items of the no drop area
                if (!container.options.drop)
                    $item.clone().insertAfter($item);
                _super($item, container);
            },
            onDrop: function ($item, container, _super) {
                $item.find('ol.dropdown-menu').sortable('enable');
                if ($($item).data('can') == false || $($item).data('can') == "false") {
                    alertify.error('You must complete information');
                    $($item).remove();
                } else {
                    $($item).find('input,select').each(function () {
                        try {
                            let tmp = $(this).attr('name').toString();
                            tmp = tmp.substr(7, tmp.length - 8);
                            $($item).data(tmp, $(this).val());
                        } catch (e) {
                            console.log(e.message);
                        }

                        $(this).remove();
                    });
                }
                _super($item, container);
                var data = group.sortable("serialize").get();

                var jsonString = JSON.stringify(data, null, ' ');

                $('#sorted').val(jsonString);
                autcom();

            }
        });
        $("#draggable").sortable({
            group: 'no-drop',
            drop: false,
        });
        $(document).on('keyup', '#empy-title', function () {
            if ($(this).val().toString().length > 3) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($(this).val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });

        $(document).on('keyup', '#tag-title', function () {
            if ($(this).val().toString().length > 3 && $("#tag-auto1").val().toString().length > 1) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($(this).val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });
        $(document).on('keyup', '#tag-sub-title', function () {
            if ($(this).val().toString().length > 3 && $("#tag-auto2").val().toString().length > 1) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($(this).val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });
        $(document).on('keyup', '#cat-title,#cat-post-title,#cat-sub-title', function () {
            if ($(this).val().toString().length > 3) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($(this).val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });
        $(document).on('keyup', '#link-title,#link-link', function () {
            if ($("#link-title").val().toString().length > 3 && validURL($("#link-link").val())) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($("#link-title").val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });
        $(document).on('keyup', '#posts-title', function () {
            if ($(this).val().toString().length > 3 && ($("#nid").val() != '')) {
                $(this).parent().data('can', 'true');
                $(this).parent().find('span').text($(this).val());
            } else {
                $(this).parent().data('can', 'false');
            }
        });

        $("#save-menu").click(function () {
            var url = $(this).closest('form').attr('action');
            axios.post(url, {'info': $('#sorted').val()}).then(function (e) {
                if (e.data["OK"] == true) {
                    alertify.success(e.data.msg);
                }
            });
        });
        autcom();

        var data = group.sortable("serialize").get();

        var jsonString = JSON.stringify(data, null, ' ');

        $('#sorted').val(jsonString);

    } catch (e) {
        console.log(e.message);
    }

});

$("#menu-manage li").bind('dblclick',async function () {
    if (confirm('Are you sure to remove?')){
        let url =  $("#rm-item").val()+'/'+$(this).data('item-id');
        await  axios.get(url);
        $(this).slideUp(300).remove();
    }
});

var autcom = function () {
    try {
        $("#tag-auto1,#tag-auto2").autocomplete({
            minLength: 2,
            source: [
                function (q, add) {
                    $.getJSON($("#tag-search").val() + '/' + encodeURIComponent(q), function (resp) {
                        add(resp);
                    })
                }
            ],
        }).on('selected.xdsoft', function (e, dt) {
            console.log(dt);
        });
        $("#posts-auto").autocomplete({
            minLength: 2,
            source: [
                function (q, add) {
                    $.getJSON($("#posts-search").val() + '/' + encodeURIComponent(q), function (resp) {
                        back = [];
                        for (const i of resp) {
                            back.push(i.id + '||' + i.title);
                        }
                        add(back);
                    })
                }
            ],
        }).on('selected.xdsoft', function (e, dt) {
            $("#nid").val(dt.split("||")[0]);
        });
    } catch (e) {
        console.log(e.message);
    }

};
