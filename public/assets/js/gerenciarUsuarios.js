document.addEventListener('DOMContentLoaded', () => {
    const cadastroUsuarioForm = document.querySelector('#formCadastrarUsuario');
    const cadastroInputs = cadastroUsuarioForm
        ? cadastroUsuarioForm.querySelectorAll('input')
        : [];
    const cadastrarUsuarioButton = document.querySelector('#btnIncluirUsuario');
    const modalElement = document.querySelector('#modalEditarUsuario');
    const editarUsuarioForm = document.querySelector('#editarUsuarioForm');
    const usuarioIdInput = document.querySelector('#editarUsuarioId');
    const usuarioNomeInput = document.querySelector('#editarUsuarioNome');
    const usuarioEmailInput = document.querySelector('#editarUsuarioEmail');
    const botoesEditar = document.querySelectorAll('.js-editar-usuario');

    window.cadastrarUsuario = () => {
        if (!cadastroUsuarioForm || !cadastrarUsuarioButton) {
            return;
        }

        const camposDesabilitados = Array.from(cadastroInputs).some((input) => input.disabled);

        if (camposDesabilitados) {
            cadastroInputs.forEach((input) => {
                input.disabled = false;
            });

            cadastrarUsuarioButton.textContent = 'Salvar';
            cadastroUsuarioForm.classList.add('is-editing');
            cadastroInputs[0]?.focus();
            return;
        }

        cadastroInputs.forEach((input) => {
            input.value = input.value.trim();
        });

        if (!cadastroUsuarioForm.checkValidity()) {
            cadastroUsuarioForm.classList.add('was-validated');
            return;
        }

        cadastroUsuarioForm.submit();
    };

    if (!modalElement || !editarUsuarioForm || !usuarioIdInput || !usuarioNomeInput || !usuarioEmailInput) {
        return;
    }

    const modalEditarUsuario = new bootstrap.Modal(modalElement);

    botoesEditar.forEach((botao) => {
        botao.addEventListener('click', () => {
            usuarioIdInput.value = botao.dataset.userId || '';
            usuarioNomeInput.value = botao.dataset.userName || '';
            usuarioEmailInput.value = botao.dataset.userEmail || '';

            modalEditarUsuario.show();
        });
    });

    modalElement.addEventListener('shown.bs.modal', () => {
        usuarioNomeInput.focus();
        usuarioNomeInput.select();
    });

    editarUsuarioForm.addEventListener('submit', (event) => {
        const nome = usuarioNomeInput.value.trim();
        const email = usuarioEmailInput.value.trim();

        usuarioNomeInput.value = nome;
        usuarioEmailInput.value = email;

        if (!nome || !email || !usuarioEmailInput.checkValidity()) {
            event.preventDefault();
            editarUsuarioForm.classList.add('was-validated');
        }
    });

    modalElement.addEventListener('hidden.bs.modal', () => {
        editarUsuarioForm.reset();
        editarUsuarioForm.classList.remove('was-validated');
    });
});
