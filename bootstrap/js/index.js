let button = document.getElementById('read_info');
let closeButton = document.getElementById('modalCloseButton');
let modal = document.getElementById('modal');
let buttonClose = document.getElementById('close');

let show = () => {
    modal.style.display = 'block';
};

button.onclick = show;


let close = () => {
    modal.style.display = 'none';
};

buttonClose.onclick = close;
closeButton.onclick = close;
