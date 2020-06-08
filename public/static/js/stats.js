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