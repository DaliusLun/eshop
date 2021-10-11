function imgSelect(imgs) {
    document.getElementById("expandedImg").src = imgs.src;
    let photos = document.getElementsByClassName('photo__small');
    for (i = 0; i < photos.length; i++) {
        photos[i].classList.remove('border')
    }
    imgs.classList.add('border');
    }

function borderOnFirstPhotoOnPageLoad() {
    let imgs = document.getElementsByClassName('photo__small');
    imgs[0].className += ' border';
    }
    
borderOnFirstPhotoOnPageLoad();

let photos = document.getElementsByClassName("photo__small");
Array.from(photos).forEach(photo => {
    photo.addEventListener("click", () => {
        imgSelect(photo);
        });
});