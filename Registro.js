document.getElementById("continueBtn").addEventListener("click", function() {
    var email = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var passwordConfirm = document.getElementById("password-confirm").value;
    var rol = document.getElementById("role").value;
    var avatar = document.getElementById("avatar").value;
    var fullname = document.getElementById("fullname").value;
    var birthdate = document.getElementById("birthdate").value;
    var gender = document.getElementById("gender").value;



    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;


     
       if (email && emailPattern.test(email) && username && password && passwordConfirm && rol && avatar && fullname && birthdate && gender) {
        //  3 caracteres o más
        if (username.length >= 3) {
            //  de la contraseña
            const passwordCheck = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+{}|:;<>,.?~]).{8,}$/;
            // Se verifica que cumpla con todo
            if (passwordCheck.test(password)) {
                //contraseña y la confirmación coinciden
                if (password === passwordConfirm) {
                    alert("Registro completado correctamente.");
                    //window.location.href = "Login.php";
                } else {
                    alert("Las contraseñas no coinciden. Por favor, vuelva a ingresarlas.");
                }
            } else {
                alert("La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
            }
        } else {
            alert("El nombre de usuario debe tener al menos 3 caracteres.");
        }
    } else {
        alert("Completa todos los campos correctamente antes de continuar.");
    }
    
});