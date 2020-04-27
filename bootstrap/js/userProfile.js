function changeActionType(object){
      if (object.value =='F') {
            document.getElementById('appointment').style.display='none';
            document.getElementById('feedback').style.display='block';
      }
      else {
        document.getElementById('appointment').style.display='block';
        document.getElementById('feedback').style.display='none';
      }
}

function editFirstUserData(object){
    if (object.name == 'btnEdit') {
      document.getElementById('userInfor').style.display='none';
      document.getElementById('formEditFirstUserData').style.display='block';
    }
    else if (object.name=='btnRevertEdit') {
      document.getElementById('userInfor').style.display='block';
      document.getElementById('formEditFirstUserData').style.display='none';
    }

}

function editSecondUserData(object){
    if (object.name=='btnEditMore') {
      document.getElementById('edtUserMoreData').style.display='none';
      document.getElementById('editUserMoreDataEdit').style.display='block';
    }
    else if (object.name=='btnRevertEditMore') {
      document.getElementById('edtUserMoreData').style.display='block';
      document.getElementById('editUserMoreDataEdit').style.display='none';
    }
}

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
