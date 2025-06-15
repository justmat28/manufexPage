document.addEventListener("DOMContentLoaded", function () {
    const backgrounds = [
        'images/loginFondo1.jpg',
        'images/loginFondo2.jpg',
        'images/loginFondo3.jpg'
    ];

    let index = 0;
    const bg1 = document.querySelector(".imagen1");
    const bg2 = document.querySelector(".imagen2");
    let visible = bg1;

    bg1.style.backgroundImage = `url('${backgrounds[index]}')`;
    bg1.classList.add("visible");

    setInterval(() => {
        index = (index + 1) % backgrounds.length;
        const nextImage = visible === bg1 ? bg2 : bg1;

        nextImage.style.backgroundImage = `url('${backgrounds[index]}')`;

        nextImage.classList.add("visible");

        setTimeout(() => {
            visible.classList.remove("visible");
            visib
        }, 2000);
    }, 5000); 
});