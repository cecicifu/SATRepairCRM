import './styles/tracker.css';

document.getElementById('tracker__btn').addEventListener('click', (event) => {
    event.preventDefault();

    const button = event.target;
    const code = document.getElementById('tracker_code');

    if(code.value && (/^SR-[0-9]{10}$/.test(code.value))) {
        button.disabled = true;
        button.classList.add('disabled');
        code.disabled = true;
        fetch('/tracker', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: code.value
        }).then((response) => {
            if(response.ok){
                return response.json();
            }
            throw Error(response.statusText);
        }).then((data) => {
            code.value = '';
            button.disabled = false;
            button.classList.remove('disabled');
            code.disabled = false;
            showResults(data);
        }).catch((error) => {
            code.value = '';
            button.disabled = false;
            button.classList.remove('disabled');
            code.disabled = false;
            showResults(null);
        });
    }
});

function showResults(data) {
    const content = document.getElementById('content__block');
    content.style.display = 'initial';

    if(!data) {
        content.innerHTML = `<div id="msg">Not Found</div>`;
        return null;
    }

    content.innerHTML = `
        <div>Code: <span id="code">${data.code}</span></div>
        <div>Status: <span id="status">${data.status}</span></div>
        <div>Category: <span id="category">${data.category}</span></div>
        <div style="display: ${data.colour === null ? "none" : "initial"}">Colour: <span id='colour' title="${data.colour}"></span></div>
        <div>Fault: <span id="fault">${data.fault}</span></div>
        <div style="display: ${data.publicComment === null ? "none" : "initial"}">Comment: <span id="publicComment">${data.publicComment}</span></div>
        <div>Created: <span id="created">${data.created}</span></div>
    `;

    document.getElementById('colour').style.backgroundColor = data.colour;
    document.getElementById('status').style.backgroundColor = data.status_color;
}