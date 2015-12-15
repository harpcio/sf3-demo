$(document).ready(function () {
    $('.csrf-item').click(function () {
        var uri = $(this).data('url');
        $('#csrfModal').find('form').attr('action', uri);
        $('#csrfModal').modal();
    });
});