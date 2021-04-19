function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

jQuery(function () {

    $('.icon-pickerx').iconpicker();
    $('.icp-dd').iconpicker({
        //title: 'Dropdown with picker',
        //component:'.btn > i'
    }).on('iconpickerSelected', function(event){
        $($(this).data('src')).val(event.iconpickerValue);
    });

    $(".clip").click(function () {
      if(!$(this).hasClass('played')){
          $(this).find('img').hide();
          $(this).find('video').show();
          $(this).addClass('played');
      }
    });

    $(document).on('click', '.rm-row', function () {
        if (confirm( areYouSure )) {
            $(this).closest('.row').remove();
            $(window).resize();
        }
    });

    $('.add-row').click(function () {
        $("#row-base").append(
            ' <div class="row p-2">\n' +
            '                    <div class="col-11">\n' +
            `                        <input type="text" class="form-control" name="options[]" value="" placeholder="${option}"/>\n` +
            '                    </div>\n' +
            '                    <div class="col-1">\n' +
            '                        <div class="btn btn-danger rm-row">\n' +
            '                            <i class="fa fa-times"></i>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>'
        );
        $(window).resize();
    });


    try {
        $("#navbar").rvnm({
            theme: 'dark-doder'
        });
    } catch(e) {
        // console.log(e.message);
    }


    $(".xsumbmiter").submit(function () {
      $(this).attr('action',$("#smt").val());
    });

    $(".comment-reply").click(function () {
      $('#reply').remove();
      var pid = $(this).data('id');
      $("#comment-form-body").append(`<input type="hidden" id="reply" name="parent" value="${pid}" />`);
      $("#comment-message").focus();
    });



    /**
     * delete confirm
     */
    $(document).on('click', '.delete-confirm,.del-conf', function () {
        if (!confirm(areYouSure)) {
            return false;
        }
    });
    /**
     * delete confirm for images
     */
    $(document).on('click', '.delete-image-btn', function () {
        if (!confirm(areYouSure)) {
            return false;
        }
        $(this).closest('.thumb').slideUp(300, function () {
            $(this).remove();
        });
        return false;
    });

    /**
     * delete confirm for bulk delete
     */
    $(document).on('submit', '.bulk-action', function () {
        if ($(this).find('#bulk').val() == 'delete') {
            if (!confirm('Are you sure to bulk delete?')) {
                return false;
            }
        }
    });


    // checkbox group select begin
    // source: http://stackoverflow.com/questions/659508/how-can-i-shift-select-multiple-checkboxes-like-gmail

    var $chkboxes = $('.chkbox');
    var lastChecked = null;

    $chkboxes.click(function(e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });

    $(".chkall").on('change click',function () {
        var ischeck = $(this).is(":checked");
        if  (ischeck){
            $(this).closest('table').find('.chkbox').attr('checked','');
        }else{
            $(this).closest('table').find('.chkbox').removeAttr('checked');
        }
    });

    $("#like-now,#dislike-now").click(function () {
        var url = $("#like-route").val();
        var act = 0;
        if ($(this).attr('id') == 'like-now'){
            act = 1;
        }
        axios.post(url,{'action' : act}).then(function (e) {
            if(e.data.OK){
                alertify.success(e.data.msg);
                if (act == 1){
                    $("#like-posts").text((parseInt($("#like-posts").text())+1).toString());
                }else {
                    $("#dislike-posts").text((parseInt($("#dislike-posts").text())+1).toString());
                }
            }else {
                alertify.error(e.data.msg);
            }
        });
    });


     var winLoader = function() {
        // console.log('e');
         $("#preloader").slideUp(313);
         setTimeout(function () {
             $("#posts-li").click();
         },500);
         clearInterval(winld);

         // filter set
         if(getParameterByName('filter') !== null){
             var filterval = getParameterByName('filter');
             $(`[data-filter="${filterval}"]`).removeClass('btn-dark').addClass('btn-primary');
         }else{
             $(`[data-filter="all"]`).removeClass('btn-dark').addClass('btn-primary');
         }

         $(window).resize();

    };
    // windows load
    $(window).on('load', function () {
        winLoader();
        uProgress.done();
    });
   //
   var winld = setTimeout(winLoader,1000);


   $("#gallery_images").change(function (e) {
       $("#newimgs").html('');
       var tmp = '';
       for( const img of e.target.files) {

           tmp += `<li> <div class="img" style="background-image: url('${URL.createObjectURL(img)}')"></div> <br> <input class="form-control" type="text" name="title[]" placeholder="Title" /> </li>`;

       }
       $("#newimgs").append(tmp);

   });



   try {
       $(".taggble").tagsinput({
           typeahead: {
               source: function(query) {
                   return $.get(tagsearch+'/'+query);
               }
           },
           freeInput: true
       });
       $(document).on('click',".typeahead .dropdown-item",function () {
         setTimeout(function () {
             console.log($(".bootstrap-tagsinput").find('input').val());
           $(".bootstrap-tagsinput").find('input').val('').focus(	);
         },100);
       });
        $('.searchable').selectpicker();
   } catch(e) {
       console.log(e.message);
   }



   try {
       if($("[name='body']").length){
           CKEDITOR.replace('body', {
               filebrowserUploadUrl:xupload,
               filebrowserUploadMethod: 'form',
               contentsLangDirection: 'rtl'
           });
       }
   } catch(e) {
   }

   try {
       lightbox.option({
           'resizeDuration': 200,
           'wrapAround': true,
       })
   } catch(e) {
       console.log(e.message);
   }







});
