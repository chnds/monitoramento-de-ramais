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

function executarFuncoes() {
    persistirRamais();
    persistirFilas();
    atualizarPainel();
}

setInterval(executarFuncoes, 10000);

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

function persistirRamais() {
    $.getJSON('../lib/ramais.json', function(data) {
        console.log('Dados ramais:', data.peers); // Correção aqui
        $.ajax({
            url: '/atualizarRamais',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data.peers),
            success: function(response) {
                console.log('Dados dos ramais persistidos com sucesso!');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao persistir os dados dos ramais:', error);
            }
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Erro ao carregar o arquivo JSON:', errorThrown);
    });
}


function persistirFilas() {
    $.getJSON('../lib/filas.json', function(data) {
        console.log('Dados filas:', data.filas); // Correção aqui
        $.ajax({
            url: '/atualizarFilas',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ filas: data.filas }), 
            success: function(response) {
                console.log('Dados das filas persistidos com sucesso!');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao persistir os dados das filas:', error);
            }
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Erro ao carregar o arquivo JSON das filas:', errorThrown);
    });
}



