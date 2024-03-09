var baseUrl = "http://localhost";

var ramaisData = []; 

function atualizarPainel() {
    $.ajax({
        url: baseUrl + "/listarFilas",
        type: "GET",
        dataType: "json",
        success: function(data) {
            ramaisData = data;

            $('#cartoes').empty();
            data.forEach(function(item) {
                var statusIconClass = '';
                var statusColorClass = '';

                if (item.status === 'Unavailable') {
                    statusIconClass = 'icone-indisponivel';
                    statusColorClass = 'cartao-indisponivel';
                } else if (item.paused) {
                    statusIconClass = 'icone-pausa';
                    statusColorClass = 'cartao-pausa';
                }

                var $cartao = $(`
                    <div class="cartao ${statusColorClass}">
                        <div>${item.name}</div>
                        <span class="${statusIconClass} icone-posicao"></span>
                        <span class="abrir-modal-btn material-symbols-outlined" style="cursor: pointer;">info</span>
                    </div>`);

                $cartao.find('.abrir-modal-btn').on('click', function() {
                    exibirInformacoesModal(item);
                });

                $('#cartoes').append($cartao);
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log("Erro ao obter dados: " + textStatus);
        }
    });
}

function exibirInformacoesModal(item) {
    $('#modal-body').empty();
    $('#modal-body').append(`
        <p><strong>Nome:</strong> ${item.name}</p>
        <p><strong>Chamadas Atendidas:</strong> ${item.calls_taken}</p>
        <p><strong>Extensão:</strong> ${item.extension}</p>
        <p><strong>Status:</strong> ${item.status}</p>
    `);
    $('#myModal').modal('show');
}

setInterval(atualizarPainel, 10000);

$(document).ready(function() {
    atualizarPainel();
});

function searchRamal() {
    var input, filter, cards, card, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    cards = document.getElementsByClassName('cartao');

    for (i = 0; i < cards.length; i++) {
        card = cards[i];
        txtValue = card.textContent || card.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    }
}
