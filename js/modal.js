function openModal1(){
    document.getElementById('modal1').style.display = 'block';
}

function closeModal1(){
    document.getElementById('modal1').style.display = 'none';
}

function openModal2(){
    document.getElementById('modal2').style.display = 'block';
}

function closeModal2(){
    document.getElementById('modal2').style.display = 'none';
}

function openNotification(){
    document.getElementById('notification').style.display ='block';
}

function closeNotification(){
    document.getElementById('notification').style.display ='none';
}

function incoming(){
    document.getElementById('incoming').style.display = 'flex';
    document.getElementById('outgoing').style.display = 'none';
}

function outgoing(){
    document.getElementById('incoming').style.display = 'none';
    document.getElementById('outgoing').style.display = 'flex';
}