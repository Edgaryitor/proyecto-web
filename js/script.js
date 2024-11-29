document.addEventListener("DOMContentLoaded", function() {  
    const registerForm = document.querySelector('form[action="register.php"]');  

    registerForm.addEventListener('submit', function(event) {  
        const password = registerForm.querySelector('input[name="password"]').value;  
        if (password.length < 6) {  
            alert("La contraseña debe tener al menos 6 caracteres.");  
            event.preventDefault(); // Prevenir el envío del formulario  
        }  
    });  
});