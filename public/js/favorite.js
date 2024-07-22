$(document).ready(function() {
    $('.photo-card__button--favorite').click(function() {
        var button = $(this);
        var photoId = button.data('photo-id');
        $.ajax({
            url: '/photos/' + photoId + '/favorite',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.isFavorited) {
                    button.addClass('is-favorited');
                } else {
                    button.removeClass('is-favorited');
                }
                button.find('.favorites-count').text(response.favoritesCount);
            }
        });
    });
});