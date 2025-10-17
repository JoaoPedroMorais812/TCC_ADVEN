document.addEventListener('DOMContentLoaded', () => {
    // Função para alternar a visibilidade da senha
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.dataset.target;
            const passwordInput = document.getElementById(targetId);
            const icon = toggle.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Função para o botão "Salvar Alterações"
    const editProfileForm = document.getElementById('editProfileForm');
    editProfileForm.addEventListener('submit', (event) => {
        event.preventDefault();
        
        // Aqui você faria a validação dos dados e a requisição para o backend
        // Exemplo:
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmNewPassword = document.getElementById('confirm-new-password').value;

        if (newPassword !== confirmNewPassword) {
            alert('A nova senha e a confirmação não coincidem.');
            return;
        }

        // Lógica de envio para o servidor
        console.log('Dados do perfil salvos com sucesso!');
        // Por exemplo, você pode usar fetch() para enviar os dados
        // fetch('/api/update-profile', {
        //     method: 'POST',
        //     body: new FormData(editProfileForm)
        // }).then(response => response.json()).then(data => {
        //     console.log(data);
        // });
    });

    // Função para os botões "Cancelar"
    document.querySelectorAll('.btn-secondary, .cancel-password-change').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            // Lógica para cancelar as alterações ou voltar para a página anterior
            // Por exemplo:
            alert('Ação cancelada!');
            // window.history.back(); // Volta para a página anterior
        });
    });
});