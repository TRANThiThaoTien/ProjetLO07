$(document).ready(function () {
    var inputs = document.forms['ajouter_article'].getElementsByTagName('input');
    var run_onchange = false;
    function valid() {
        var errors = false;

        for (var i = inputs.length - 3; i >= 0; i--) {
            var value = inputs[i].value;
            var id = inputs[i].getAttribute('id');

            var span = document.createElement('span');
            var p = inputs[i].parentNode;
            if (p.lastChild.nodeName == 'SPAN') {
                p.removeChild(p.lastChild);
            }

            if (value == '') {
                if (id == 'photo') {
                    continue;
                }
                ;
                span.innerHTML = 'Ce champ est obligatoire.';

            } else {
                if (id == 'annee' && isNaN(value) == true) {
                    span.innerHTML = 'Mauvais saisir.';
                }
                if (id == 'photo') {
                    var fsize = $('#photo')[0].files[0].type;
                    if (fsize != 'image/png' && fsize != 'image/gif' && fsize != 'image/jpeg') {
                        span.innerHTML = 'Vous doivez joindre l\'image avec .jpg ou .png ou .gif ou.jpeg';
                    }
                }
            }

            if (span.innerHTML != '') {
                inputs[i].parentNode.appendChild(span);
                span.setAttribute('style', 'color: red; font-style:italic');
                errors = true;
                run_onchange = true;
                inputs[i].style.border = '1px solid #c6807b';
                inputs[i].style.background = '#fffcf9';
                inputs[i].focus();
            }
        }
        return !errors;
    }
    var register = document.getElementById('submit_article');
    register.onclick = function () {
        return valid();
    }
    for (var i = 0; i < inputs.length; i++) {
        var id = inputs[i].getAttribute('id');
        inputs[i].onchange = function () {
            if (run_onchange == true) {
                this.style.border = '';
                this.style.background = '';
                valid();
            }
        }
    }
});