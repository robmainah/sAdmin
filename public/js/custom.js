$('#menu_toggle').click(function (event) {
    event.preventDefault();
    $('#wrapper').toggleClass('menuDisplayed');
});
$('.sidebar-nav li').click(function (event) {
    $('.sidebar-nav li').removeClass('active');
    $(this).addClass('active');
});
