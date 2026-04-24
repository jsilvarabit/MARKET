document.addEventListener('DOMContentLoaded', () => {
    const usuarioInput = document.querySelector('#usuario');
    const primeiroAcessoModalElement = document.querySelector('#modalPrimeiroAcesso');
    const primeiroAcessoForm = document.querySelector('#primeiroAcessoForm');
    const novaSenhaInput = document.querySelector('#novaSenha');
    const confirmarNovaSenhaInput = document.querySelector('#confirmarNovaSenha');

    if (usuarioInput) {
        usuarioInput.focus();
    }

    if (primeiroAcessoModalElement?.dataset.showModal === '1') {
        const primeiroAcessoModal = new bootstrap.Modal(primeiroAcessoModalElement, {
            backdrop: 'static',
            keyboard: false,
        });

        primeiroAcessoModal.show();
    }

    primeiroAcessoModalElement?.addEventListener('shown.bs.modal', () => {
        novaSenhaInput?.focus();
    });

    primeiroAcessoForm?.addEventListener('submit', (event) => {
        const novaSenha = novaSenhaInput.value;
        const confirmarNovaSenha = confirmarNovaSenhaInput.value;

        confirmarNovaSenhaInput.setCustomValidity('');

        if (!novaSenha || !confirmarNovaSenha || novaSenha !== confirmarNovaSenha) {
            event.preventDefault();
            confirmarNovaSenhaInput.setCustomValidity('As senhas devem ser iguais.');
            primeiroAcessoForm.classList.add('was-validated');
        }
    });
});
