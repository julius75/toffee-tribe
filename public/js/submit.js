(function () {
    $('.prevent-m-subs').on('submit', function () {
        $('.button-prevent').attr('disabled', 'true');
        $('.spinner').show();
    })
})();


$('.btn-prevent').click(function(){
    $(this).attr('disabled');
});