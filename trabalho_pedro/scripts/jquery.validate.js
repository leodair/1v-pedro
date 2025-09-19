document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('mural');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpar mensagens de erro anteriores
        clearErrors();
        
        // Validar campos
        const nomeValido = validateNome();
        const emailValido = validateEmail();
        const msgValido = validateMsg();
        
        // Se todos os campos forem válidos, enviar o formulário
        if (nomeValido && emailValido && msgValido) {
            form.submit();
        }
    });
    
    // Validação em tempo real
    document.getElementById('nome').addEventListener('blur', validateNome);
    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('msg').addEventListener('blur', validateMsg);
    
    function validateNome() {
        const nomeInput = document.getElementById('nome');
        const errorElement = document.getElementById('nome-error');
        const nome = nomeInput.value.trim();
        
        if (nome === '') {
            showError(nomeInput, errorElement, 'Por favor, digite seu nome');
            return false;
        }
        
        if (nome.length < 4) {
            showError(nomeInput, errorElement, 'Seu nome deve ter pelo menos 4 caracteres');
            return false;
        }
        
        clearError(nomeInput, errorElement);
        return true;
    }
    
    function validateEmail() {
        const emailInput = document.getElementById('email');
        const errorElement = document.getElementById('email-error');
        const email = emailInput.value.trim();
        
        if (email === '') {
            showError(emailInput, errorElement, 'Por favor, digite seu e-mail');
            return false;
        }
        
        if (!email.includes('@')) {
            showError(emailInput, errorElement, 'O e-mail deve conter o símbolo @');
            return false;
        }
        
        // Validação básica de formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError(emailInput, errorElement, 'Por favor, digite um e-mail válido');
            return false;
        }
        
        clearError(emailInput, errorElement);
        return true;
    }
    
    function validateMsg() {
        const msgInput = document.getElementById('msg');
        const errorElement = document.getElementById('msg-error');
        const msg = msgInput.value.trim();
        
        if (msg === '') {
            showError(msgInput, errorElement, 'Por favor, digite sua mensagem');
            return false;
        }
        
        if (msg.length < 10) {
            showError(msgInput, errorElement, 'Sua mensagem deve ter pelo menos 10 caracteres');
            return false;
        }
        
        clearError(msgInput, errorElement);
        return true;
    }
    
    function showError(input, errorElement, message) {
        input.classList.add('input-error');
        errorElement.textContent = message;
    }
    
    function clearError(input, errorElement) {
        input.classList.remove('input-error');
        errorElement.textContent = '';
    }
    
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        const inputs = document.querySelectorAll('#mural input, #mural textarea');
        inputs.forEach(input => {
            input.classList.remove('input-error');
        });
    }
});