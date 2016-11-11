var inputs = document.forms['inscrire'].getElementsByTagName('input');
var run_onchange = false;
var errors = true;
var succes = false;
var reset = document.getElementById('reset');
reset.onclick = function () {
    run_onchange = false;
    for (var i = 0; i < inputs.length; i++) {
        var p = inputs[i].parentNode;
        if (p.lastChild.nodeName == 'SPAN') {
            p.removeChild(p.lastChild);
            inputs[i].style.border = '';
            inputs[i].style.background = '';
        }
    }
}
$(document).ready(function () {
    function valid(role) {
        var data = {
            nom: $('#nom').val(),
            prenom: $('#prenom').val(),
            email: $('#email').val(),
            confirm_email: $('#confirm_email').val(),
            login: $('#login').val(),
            mdp: $('#mdp').val(),
            confirm_mdp: $('#confirm_mdp').val(),
            organisation: $('#organisation').val(),
            laboratoire: $('#laboratoire').val(),
        };
        if (role == true) {
            url = "../inscrire/verifier_ajouter_inscrire.php";
        } else {
            url = "../inscrire/verifier_inscrire.php";
        }
        $.ajax({
            type: "post",
            dataType: "JSON",
            url: url,
            data: data,
            success: function (result)
            {
                if (result.hasOwnProperty('error') && result.error == '1') {
                    if (role == true) {
                        if (result.compte != '') {
                            alert(result.compte);
                            setTimeout("location.reload(true);", 0);
                        }
                    }
                    for (var i = inputs.length - 1; i >= 0; i--) {
                        var id = inputs[i].getAttribute('id');
                        var span = document.createElement('span');

                        var p = inputs[i].parentNode;
                        if (p.lastChild.nodeName == 'SPAN') {
                            p.removeChild(p.lastChild);
                            inputs[i].style.border = '';
                            inputs[i].style.background = '';
                        }

                        if (id == 'login' && result.login != '') {
                            span.innerHTML = result.login;
                        }
                        if (id == 'email' && result.email != '') {
                            span.innerHTML = result.email;
                        }
                        if (id == 'confirm_email' && result.confirm_email != '') {
                            span.innerHTML = result.confirm_email;
                        }
                        if (id == 'nom' && result.nom != '') {
                            span.innerHTML = result.nom;
                        }
                        // Kiểm tra password
                        if (id == 'prenom' && result.prenom != '') {
                            span.innerHTML = result.prenom;
                        }
                        if (id == 'organisation' && result.organisation != '') {
                            span.innerHTML = result.organisation;
                        }
                        if (id == 'mdp' && result.mdp != '') {
                            span.innerHTML = result.mdp;
                        }
                        if (id == 'confirm_mdp' && result.confirm_mdp != '') {
                            span.innerHTML = result.confirm_mdp;
                        }

                        if (span.innerHTML != '') {
                            span.setAttribute('style', 'color: red; font-style:italic');
                            inputs[i].parentNode.appendChild(span);
                            run_onchange = true;
                            inputs[i].style.border = '1px solid #c6807b';
                            inputs[i].style.background = '#fffcf9';
                            inputs[i].focus();
                        }
                    }
                } else {
                    if (succes == true) {
                        $('#succes').html('Incrire succès!').removeClass('hide');
                        setTimeout(function () {
                            $('#myModal2').modal('hide');
                            // Ẩn thông báo lỗi
                            $('#succes').addClass('hide');
                        }, 2000);
                        setTimeout("location.reload(true);", 0);
                    }
                }
            }
        });
    }
    ;

    $('#submit').click(function () {
        succes = true;
        valid(true);
    });
    for (var i = 0; i < inputs.length; i++) {
        var id = inputs[i].getAttribute('id');
        inputs[i].onchange = function () {
            if (run_onchange == true) {
                succes = false;
                this.style.border = '';
                this.style.background = '';
                if (this.parentNode.lastChild.nodeName == 'SPAN') {
                    this.parentNode.removeChild(this.parentNode.lastChild);
                }
                return valid(false);
            }
        };
    }
});


