async function download(type) {
    const response = await fetch(`/api/getdata/${type}`, {
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