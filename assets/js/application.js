(function($) {
    $('.alert-error').hide();
    $('.btn-add').live('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var row = $(this).closest('.row');
        if (row.find('input.span6').val() == '' && row.find('input.span5').val() == '') {
            return;
        }
        var newrow = row.clone().insertAfter($('.row:last'));
        newrow.find('input').val('');
        button.removeClass('btn-primary')
              .removeClass('btn-add')
              .addClass('btn-danger')
              .addClass('btn-remove')
              .find('span')
              .removeClass('icon-plus')
              .addClass('icon-trash');
    });
    $('.btn-remove').live('click', function(e) {
        e.preventDefault();
        var row = $(this).closest('.row');
        if (confirm('Are you sure you wish to remove this parameter?')) {
            row.remove();
        }
    });
    $('form').on('submit', function(e) {
        e.preventDefault();
        $.post('index.php', $('form').serialize(), function(response) {
            $('.alert-error').fadeOut('fast');
            if (response.error) {
                $('.alert-error').text(response.error.message).fadeIn('fast');
            }
            else {
                $('#response').text(response.result);
                prettyPrint();
            }
        });
    });
})(jQuery);