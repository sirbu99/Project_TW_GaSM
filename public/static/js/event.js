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
    if (title.length===0 || details.length===0||description.length===0||date==="") {
        document.getElementById("error-message-admin").innerHTML = 'Toate câmpurile trebuie completate!';
        return false;
    }

    const response = await fetch('/api/insertevent', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
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
async function showDetails(id) {
    document.getElementById('id05').style.display = 'block';
    const response = await fetch(`/api/getEventInfo?id=${id}`, {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            let tags = data['tags'].split(',');
            tags = tags.filter(Boolean);
            tags = tags.map((tag) => {
                return (`<div>${tag}</div>`);
            });


            document.getElementById('modal-content-05').innerHTML = `
                <header class="article-header">
                    <div class="category-title">
                        <span class="date">${data['data']}</span>
                    </div>
                    <h2 class="article-title">${data['titlu']}</h2>
                </header>
                <div class="eventDescription">
                    ${data['descriere'] || 'fara descriere'}
                </div>
                <div class="tagsClass">
                    <div class="tags">
                        ${tags.join('')}
                    </div>
                </div>
                <div class="comments">
                    ${data["comments"].map((comment) => `<div class="commentInfo"> <div class="commentAuthor">${comment['first_name'] } ${comment['last_name'] }:</div> <div class="commentText">  ${comment['text']}  </div> <div class="commentDate">Data : ${comment['data']}</div></div>`).join("")}
                
                    <textarea id="eventComment"  rows="5" placeholder="Scrie un comentariu aici.."></textarea>
                    
                    <button id="commentBtn" onclick="addComment(${data['id']})">Posteaza</button>
                    
                </div>
                <div id="error-message-card"></div>
            `;
        });
}

async function addComment(id) {
    const description = document.getElementById("eventComment").value;
    if (description.length===0 ) {
        document.getElementById("error-message-card").innerHTML = 'Comentariul nu poate fi gol!';
        return false;
    }
    const response = await fetch('/api/insertcomment', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: serialize({id, description}),
    })
        .then(data => {
            if (data.status === 200) {
                showDetails(id);
            }
        });


}

async function deleteEvent(id) {
    const response = await fetch('/api/deleteEvent', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: serialize({id}),
    })
        .then(data => {
            if (data.status === 200) {
                location.reload();
            }
        });

}