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