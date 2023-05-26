// view more option
const viewBtn = document.getElementById('view');
const hidden = document.getElementById('hidden');

function show(){
    hidden.style.display = "block";
}
function hide(){
    hidden.style.display = "none";
}
viewBtn.onclick = () => {
    if(viewBtn.innerText === 'View More'){
        viewBtn.innerText = 'View Less';
        show();
    }
    else{
        viewBtn.innerText = 'View More';
        hide();
    }
}
// sliding image
const left = document.getElementById('left');
const right = document.getElementById('right');
const imgSlides2 = document.querySelector('.img-slides2');
const imgSlides1 = document.querySelector('.img-slides');

function leftslider(){
    imgSlides2.style.transitionDuration = "0.5s";
    imgSlides2.style.display = "block";
    imgSlides1.style.display = "none";
  
}

function rightslider(){
    imgSlides2.style.display = "none";
    imgSlides1.style.display = "block";
    imgSlides2.style.transitionDuration = "0.5s";
}

left.onclick=()=>leftslider()
right.onclick=()=>rightslider()
// success message display/
const successMsg = document.getElementById('welcome');
const cross = document.getElementById('cross');
function disable(){
    successMsg.style.display="none";
}
cross.onclick = () => disable();


// const navigation = document.getElementById('navigation');
// const navTop = navigation.offsetTop;

// function handleScroll() {
//   if (window.pageYOffset > navTop) {
//     navigation.classList.add('scroll');
//   } else {
//     navigation.classList.remove('scroll');
//   }
// }

// window.addEventListener('scroll', handleScroll);
