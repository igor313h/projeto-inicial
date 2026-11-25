var preco = $('#preco').maskMoney({
    prefix: '',
    decimal: ',',
    thousands: '.',
    allowZero: true
});

var campoImagem = document.getElementById('imagem');
var imagemAtual = document.getElementById('imagem-atual');

if (campoImagem && imagemAtual) {
    campoImagem.addEventListener('change', function () {
        var arquivo = campoImagem.files[0];
        if (!arquivo) {
            return;
        }

        var leitor = new FileReader();
        leitor.onload = function (evento) {
            imagemAtual.src = evento.target.result;
        };
        leitor.readAsDataURL(arquivo);
    });
}
