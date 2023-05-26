const buttonChange = document.getElementById('addpost');

function changeColor(){
    buttonChange.style.backgroundColor = "#597cdc";
    buttonChange.style.padding="2rem";
}
buttonChange.onclick = () => changeColor();