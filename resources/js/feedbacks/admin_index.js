$(document).ready(function(){
    console.log('document ready!');

    $(document).on('change', '#perPage-select', function(event){
        let perPage = $(this).val();
        let url = '/admin/feedbacks?perPage=' + perPage;
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

});

