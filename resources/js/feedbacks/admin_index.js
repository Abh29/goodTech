$(document).ready(function(){
    console.log('document ready!');

    $('#perPage-select').on('change', function () {
        let perPage = $(this).val();
        let url = '/admin/feedbacks?page=1&perPage=' + perPage;
        window.location = url;
        return false;
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

});

