let images = document.querySelectorAll('img');


let container;


for (let i = 0; i < images.length; i++) {
    images[i].onmouseover = function () {
        images[i].style.cursor = 'pointer';
    };
    images[i].onclick = function () {
        let t = captureImg('#contain-image');
        if (t !== undefined){
            t.remove();
        }
        displayImg(images[i]);
    }
}



function displayImg(img, ChoseClass = '.site-content', id = 'display-img') {

    container = getContainer(ChoseClass);
        let link = getImgLink(img);
        let img_ = createImgWithSrc(link);
        let div = createDivWithId(id);
        let contain_ = contain();

        contain_.style.position = 'fixed';
        contain_.style.top = (window.innerHeight / 2) + 'px';
        contain_.style.right = (window.innerWidth / 2) + 'px';
        let button = createCloseButton();

        div.appendChild(img_);
        div.appendChild(button);
        contain_.appendChild(div);

        console.log(contain_.offsetHeight);

    container.appendChild(contain_);

}

function captureImg(id){
    return (document.querySelector(id)) ? document.querySelector(id) : undefined;
}


function getContainer(ChoseClass) {
    return document.querySelector(ChoseClass);
}
function getImgLink(img) {
    let i = img.getAttribute('src');
    return i.replace('miniatures', 'HQ');
}
function contain(){
    let contain = document.createElement('div');
    contain.setAttribute('id', 'contain-image');
    return contain;
}
function createDivWithId(id) {
    let div = document.createElement('div');
    div.setAttribute('id', id);
    div.style.position = 'relative';
    div.style.display = 'inline-block';
    div.style.width = 'auto';
    div.style.height = 'auto';
    div.style.padding = '20px';
    div.style.borderRadius = '5px';
    div.style.backgroundColor = 'whitesmoke';
    div.style.boxShadow = '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);';
    return div;
}
function createImgWithSrc(src) {
    let img = document.createElement('img');
    img.setAttribute('src', src);
    return img;
}
function createCloseButton() {
    let button = document.createElement('div');
        button.style.width = 'auto';
        button.style.height = 'auto';
        button.style.fontSize = '17px';
        button.style.padding = '5px';
        button.style.position = 'absolute';
        button.style.top = '0';
        button.style.right = '0';
        button.style.borderRadius = '2px';
        button.style.backgroundColor = 'green';
        button.innerHTML = '&times;';
        button.onmouseover = function () {
            button.style.cursor = 'pointer';
            button.style.backgroundColor = 'blue';
        };
        button.onmouseleave = function () {
            button.style.cursor = 'pointer';
            button.style.backgroundColor = 'green';
        };
        button.onclick = function () {
            button.parentElement.remove();
        };
    return button;
}