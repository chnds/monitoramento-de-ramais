var baseUrl = "http://localhost";

function atualizarPainel() {
    $.ajax({
        url: baseUrl + "/listarFilas",
        type: "GET",
        dataType: "json", 
        success: function(data) {
            console.log(data);
            $('#cartoes').empty(); // Limpar o conteúdo existente antes de adicionar os novos cartões
            
            data.forEach(function(item) {
                let statusIconClass = ''; 
                let statusColorClass = ''; 

                if (item.status === 'Unavailable') {
                    statusIconClass = 'icone-indisponivel';
                    statusColorClass = 'cartao-indisponivel';
                } else if (item.paused) {
                    statusIconClass = 'icone-pausa';
                    statusColorClass = 'cartao-pausa';
                }

                $('#cartoes').append(`<div class="cartao ${statusColorClass}">
                    <div>${item.name}</div>
                    <span class="${statusIconClass} icone-posicao"></span>
                    </div>`);
            });
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log("Erro ao obter dados: " + textStatus);
        }
    });
}

// Atualizar o painel a cada 10 segundos
setInterval(atualizarPainel, 10000);

// Chamar a função de atualização do painel quando a página for carregada
$(document).ready(function() {
    atualizarPainel();
});
