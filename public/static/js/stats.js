async function download(type) {
    const time =document.getElementById("downloadInfo").value;
    console.log(time);
    const response = await fetch(`/api/getdata/${type}?report=${time}`, {
        method: 'GET',
    })
    .then(response => response.blob())
    .then(blob => {
        const a = document.createElement('a');
        a.href = window.URL.createObjectURL(blob);
        a.download = `filename.${type}`;
        a.click();
        return false
    });
}

async function upload(type){
    let files = document.getElementById('jsonFile').files;
    if (files.length <= 0) {
        return false;
    }

    let fr = new FileReader();

    fr.onload = function(e) {
        let result;
        if(type === 'json'){
            result = JSON.parse(e.target.result);
        }
        else{
            result = Papa.parse(e.target.result);
            console.log(result);
        }
        let formatted = JSON.stringify(result, null, 2);
        fetch('/api/insertdata/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
    }

    fr.readAsText(files.item(0));
}