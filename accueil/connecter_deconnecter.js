$(document).ready(function () {
    $('#myModal').on('hidden.bs.modal', function () {
        $('.alert-danger').addClass('hide');
        $('.alert-success').addClass('hide');
    });
    var k = 0;
    k = 2;
    $('#connecter').click(function () {
        var data = {
            login: $('#login_connexion').val(),
            mdp: $('#mdp_connexion').val(),
        };
        $.ajax({
            type: "post",
            dataType: "JSON",
            url: "../accueil/valider_connexion.php",
            data: data,
            success: function (result)
            {
                if (result.hasOwnProperty('error') && result.error == '1') {
                    var html = '';
                    $.each(result, function (key, item) {
                        if (key != 'error') {
                            html += '<li>' + item + '</li>';
                        }
                    });
                    $('.alert-danger').html(html).removeClass('hide');
                    $('.alert-success').addClass('hide');
                } else { // Thành công
                    $('.alert-success').html('Connexion succès!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
                    setTimeout(function () {
                        $('#myModal').modal('hide');
                        // Ẩn thông báo lỗi
                        $('.alert-danger').addClass('hide');
                        $('.alert-success').addClass('hide');
                    }, 3000);
                    setTimeout("location.reload(true);", 0);
                }
            }
        });
    });
    $('#deconnexion').click(function () {
        $.ajax({
            url: "../accueil/deconnexion.php",
            success: function (result) {
                window.location.assign("../accueil/index.php");
            }
        });
    });
});