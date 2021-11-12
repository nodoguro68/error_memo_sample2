var $ = require('jquery');

$(function() {

    const $favorite = $('.js-click-favorite') || null;
    let favoriteMemoId = $favorite.data('memoid') || null;

    if (favoriteMemoId !== undefined && favoriteMemoId !== null) {

        $favorite.on('click', function() {
            
            const $this = $(this);

            $.ajax({
                type: "POST",
                url: "ajax_favorite_memo.php",
                data: {
                    memoId: favoriteMemoId
                },
            }).done(function(data) {
                $this.toggleClass('active');
            }).fail(function(msg) {
                console.log('Ajax Error');
            });
        });
    }
});