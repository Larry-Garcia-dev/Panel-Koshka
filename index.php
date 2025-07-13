<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <main>

        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="php/login-register/login.php" class="formulario__login" method="post">
                    <h2>Iniciar Sesión</h2>
                    <input name="Email" type="text" placeholder="Correo Electronico">
                    <div style="position: relative;">
                        <input name="Password" id="loginPassword" type="password" placeholder="Contraseña">
                        <i class="bi bi-eye-slash" id="toggleLoginPassword" style="position: absolute; right: 10px; top: 30px; cursor: pointer;"></i>
                    </div>
                    <button>Entrar</button>
                </form>

                <!--Register-->
                <form action="php/login-register/register.php" class="formulario__register" method="post">
                    <h2>Regístrarse</h2>
                    <input type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" name="Pin" placeholder="Pin de Autenticacion" required>
                    <input name="Name" type="text" placeholder="Nombre completo">
                    <input type="email" name="Email" placeholder="Correo Electrónico" pattern="^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$" title="Ingresa un correo válido" required>
                    <input name="User" type="text" placeholder="Usuario">
                    <div style="position: relative;">
                        <input type="password" name="Password" id="registerPassword" placeholder="Contraseña" required>
                        <i class="bi bi-eye-slash" id="toggleRegisterPassword" style="position: absolute; right: 10px; top: 30px; cursor: pointer;"></i>
                    </div>

                    <!-- Mensaje de validación en tiempo real -->
                    <div id="password-requirements" class="password-requirements">
                        <p id="length" class="invalid">✓ Al menos 6 caracteres</p>
                        <p id="number" class="invalid">✓ Al menos 1 número</p>
                        <p id="uppercase" class="invalid">✓ Al menos 1 letra mayúscula</p>
                        <p id="special" class="invalid">✓ Al menos 1 caracter especial</p>
                    </div>

                    <button>Regístrarse</button>
                </form>
            </div>
        </div>

    </main>

    <script>
        // Mostrar/Ocultar contraseña - Login
        const toggleLogin = document.getElementById("toggleLoginPassword");
        const loginPassword = document.getElementById("loginPassword");

        if (toggleLogin && loginPassword) {
            toggleLogin.addEventListener("click", function () {
                const type = loginPassword.getAttribute("type") === "password" ? "text" : "password";
                loginPassword.setAttribute("type", type);
                this.classList.toggle("bi-eye");
                this.classList.toggle("bi-eye-slash");
            });
        }

        // Mostrar/Ocultar contraseña - Registro
        const toggleRegister = document.getElementById("toggleRegisterPassword");
        const registerPassword = document.getElementById("registerPassword");

        if (toggleRegister && registerPassword) {
            toggleRegister.addEventListener("click", function () {
                const type = registerPassword.getAttribute("type") === "password" ? "text" : "password";
                registerPassword.setAttribute("type", type);
                this.classList.toggle("bi-eye");
                this.classList.toggle("bi-eye-slash");
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("registerPassword");
            const requirements = {
                length: {
                    el: document.getElementById("length"),
                    regex: /.{6,}/
                },
                number: {
                    el: document.getElementById("number"),
                    regex: /\d/
                },
                uppercase: {
                    el: document.getElementById("uppercase"),
                    regex: /[A-Z]/
                },
                special: {
                    el: document.getElementById("special"),
                    regex: /[\W_]/
                }
            };

            function validatePassword() {
                const value = passwordInput.value;

                for (const key in requirements) {
                    if (requirements[key].regex.test(value)) {
                        requirements[key].el.textContent = "✓ " + requirements[key].el.textContent.split(" ").slice(1).join(" ");
                        requirements[key].el.className = "valid";
                    } else {
                        requirements[key].el.textContent = "✗ " + requirements[key].el.textContent.split(" ").slice(1).join(" ");
                        requirements[key].el.className = "invalid";
                    }
                }
            }

            if (passwordInput) {
                passwordInput.addEventListener("input", validatePassword);
            }
        });
    </script>

    <script src="js/script.js"></script>
</body>

</html>
