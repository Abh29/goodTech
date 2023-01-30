$(document).ready(function(){
    console.log('document ready!');

    $(document).on('change', '#perPage-select', function(event){
        let perPage = $(this).val();
        let url = $(this).attr('current') + '&perPage=' + perPage;
        window.location = url;
    });

    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href');
        fetch_data(page);
    });

    function fetch_data(page)
    {
        $.ajax({
            url: page,
            success:function(data)
            {
                // console.log(data);
                $('#feedbacks_data').html(data);
                window.history.pushState("","", page);
            }
        });
    }


    // $(document).on('click', '.header-sorter', function (){
    //     $(this).toggleClass('desc');
    //     let param = 0;
    //     let desc = 0;
    //
    //     console.log($(this).attr('current'));
    //
    //     switch ($(this).attr('id')) {
    //         case "header-sorteby-user_id":
    //             param = 1;
    //             break;
    //         case "header-sorteby-user_ct":
    //             param = 2;
    //             break;
    //         case "header-sorteby-feed_ct":
    //             param = 3;
    //             break;
    //         case "header-sorteby-user_name":
    //             param = 4;
    //             break;
    //         case "header-sorteby-email":
    //             param = 5;
    //             break;
    //         default:
    //             param = '&orderBy=1';
    //     };
    //
    //     if ($(this).hasClass('desc'))
    //         desc = 1;
    //
    //     let url = $(this).attr('current');
    //
    //     $.ajax({
    //         url: url,
    //         data: {
    //             'order': param,
    //             'desc': desc,
    //         },
    //         success:function(data)
    //         {
    //             $('#feedbacks_data').html(data);
    //             window.history.pushState("","", url);
    //         }
    //     });
    //
    // });




});

