async function login(e)
{
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('pass').value;
    const response = await fetch("/home/login", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: serialize({email, password})
    })
    .then(data => {
        if (data.status === 401) {
            document.getElementById("error-message").innerHTML = 'Invalid credentials!';
        }
        if (data.status === 200) {
            window.location.href = data.url;
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
async function register(e)
{
    e.preventDefault();
    const email = document.getElementById('register-email').value;
    const first_name= document.getElementById('fname').value;
    const last_name= document.getElementById('lname').value;
    const pass1= document.getElementById('pass1').value;
    const pass2= document.getElementById('pass2').value;
    const street= document.getElementById('street').value;
    if (!document.getElementById('register').checkValidity()) {
        document.getElementById('register').reportValidity();
        document.getElementById("error-message-register").innerHTML = 'Formular invalid!';
        return false;
    }

    if (pass1 !== pass2) {
        document.getElementById("error-message-register").innerHTML = 'Parolele nu coincid!';
        return false;
    }

    const response = await fetch("/home/register", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: serialize({email,first_name,last_name,password:pass1,pass2,street})
    })
        .then(data => {
            if (data.status === 400) {
                document.getElementById("error-message-register").innerHTML = 'Email deja existent';
            }
            if (data.status === 200) {
                 window.location.href = "/home";
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}