async function saveEvent() {
    const date = document.getElementById("event-date").value;
    const title = document.getElementById("text-article").value;
    const tags = document.getElementsByClassName("tag-article");
    const details =document.getElementById("event-details").value;
    const description = document.getElementById("event-description").value;
    const tagValues = [];
    for (let i = 0; i < tags.length; i++) {
        tagValues.push(tags[i].value);
    };

    const response = await fetch('/api/insertevent', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: serialize({date,title,tags: tagValues,details,description}),
    })
        .then(data => {
            if (data.status === 200) {
                location.reload();
            }
        });
}
function showDetails(){
    document.getElementById('id05').style.display='block';

}