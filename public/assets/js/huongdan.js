window.addEventListener('hashchange', function() {
    var hash = window.location.hash;

    if (hash !== "") {
        // Xóa lớp 'active' khỏi các tab và tab-pane hiện tại
        $('.nav.nav-tabs li').removeClass('active');
        $('.tab-pane').removeClass('active');

        // Thêm lớp 'active' vào tab và tab-pane mới dựa trên hash
        $('a[href="' + hash + '"]').parent().addClass('active');
        $(hash).addClass('active');

        // Cuộn trang đến vị trí của tab
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 'duration');
    }
});