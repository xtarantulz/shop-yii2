$(document).on('click', '.modal-btn', function (e) {
    var target = $(this).attr('data-target') || $(this).attr('href');

    $('#modal').modal('show');
    $('#modal').find('#modal-content').text('Загрузка...');
    $('#modal').find('#modal-content').load(target);
    $('#modal .modal-header h2').text($(this).attr('title'));

    return false;
});
