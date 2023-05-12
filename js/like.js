$(document).ready(function() {
    $('#favorite').on('change', function() {
        if($(this).is(':checked')) {
            maf = $(this).attr('like');
        }
        else{
            maf = '-1'
        }
        $.post('', {like: maf}, function(){
            console.log(maf)
            window.location.reload()
        })
    });
})