//Ejecutando funciones
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

//FUNCIONES

function anchoPage() {

    if (window.innerWidth > 850) {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
    }
}

anchoPage();


function iniciarSesion() {
    if (window.innerWidth > 850) {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register() {
    if (window.innerWidth > 850) {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}


const urlParams = new URLSearchParams(window.location.search);

if (urlParams.has('error')) {
    let title = 'Error';
    let text = 'Ocurrió un problema.';
    switch (urlParams.get('error')) {
        case 'invalid_pin':
            title = 'PIN Inválido';
            text = 'El PIN no es correcto o ya fue utilizado.';
            break;
        case 'invalid_pin_format':
            title = 'Formato Incorrecto';
            text = 'El PIN debe tener exactamente 6 números.';
            break;
        case 'missing_fields':
            title = 'Campos Vacíos';
            text = 'Por favor completa todos los campos.';
            break;
        case 'email_taken':
            title = 'Correo ya registrado';
            text = 'Este correo electrónico ya está en uso.';
            break;
        case 'missing_fields_login':
            title = 'Datos incompletos';
            text = 'Por favor ingresa tu correo y contraseña.';
            break;
        case 'invalid_credentials':
            title = 'Credenciales inválidas';
            text = 'Correo o contraseña incorrectos.';
            break;
        case 'invalid_email':
            title = 'Correo inválido';
            text = 'Por favor ingresa un correo electrónico válido.';
            break;
        case 'invalid_password':
            title = 'Contraseña inválida';
            text = 'La contraseña debe tener mínimo 6 caracteres, incluir 1 número, 1 mayúscula y 1 caracter especial.';
            break;
    }

    Swal.fire({
        icon: "error",
        title: title,
        text: text,
        timer: 1500,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: '<i class="bi bi-x-lg"></i>',
        confirmButtonAriaLabel: 'Cerrar',
        customClass: {
            confirmButton: 'btn-swal-close'
        }
    });
}

if (urlParams.has('success')) {
    Swal.fire({
        icon: "success",
        title: "Registro Exitoso",
        text: "Bienvenido, ahora puedes iniciar sesión.",
        timer: 30000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: '<i class="bi bi-x-lg"></i>',
        confirmButtonAriaLabel: 'Cerrar',
        customClass: {
            confirmButton: 'btn-swal-close'
        }
    });
}

const pinInput = document.querySelector("[name=Pin]");

if (pinInput) {
    pinInput.addEventListener("input", function () {
        // Eliminar cualquier caracter que no sea número
        this.value = this.value.replace(/[^0-9]/g, '');

        // Limitar a 6 caracteres
        if (this.value.length > 6) {
            this.value = this.value.slice(0, 6);
        }
    });
}
