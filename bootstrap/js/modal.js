

function getReadInfo(object){
    let number = object.name;

    let button = document.getElementById('read_info'+number);


    let closeButton = document.getElementById('modalCloseButton');
    let modal = document.getElementById('modal'+number);
    let buttonClose = document.getElementById('close'+number);

    let show = () => {
        modal.style.display = 'block';
    };

    button.onclick = show;


    let close = () => {
        modal.style.display = 'none';
    };

    buttonClose.onclick = close;
    closeButton.onclick = close;

}
