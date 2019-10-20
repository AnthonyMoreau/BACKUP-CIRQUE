let drop_area = document.querySelector(".drop_zone");
let form = document.querySelector("form");
let gallery = document.querySelector(".gallery");
let title = document.querySelector('textarea').innerHTML;

let event = [

    "dragenter",
    "dragover",
    "dragleave",
    "drop"
];


function handleFiles(files) {
    ([...files]).forEach(uploadFile)
}

/*
 * visual aid -> valider le drop
 */

drop_area.addEventListener('dragenter', function() {
    gallery.classList.add('is-dropped');
});

drop_area.addEventListener('drop', function() {
    gallery.classList.remove('is-dropped');
});

function uploadFile(file) {

    let http_request = new XMLHttpRequest();
    let formData = new FormData();
    formData.append('drop_name', file);

    http_request.onreadystatechange = function (){
        if (http_request.readyState === 4){
            if(http_request.status !== 200){
                gallery.innerHTML = "ERRORS";
            } else {
                let path_miniature = JSON.parse(http_request.response);
                let path_HQ = path_miniature["image"].replace('miniatures', 'HQ');

                let thumbnails = document.createElement("div");
                thumbnails.setAttribute("class", "thumbnails");

                thumbnails.style.position = "relative";
                thumbnails.style.width = "110px";
                thumbnails.style.height = "110px";

                let img = document.createElement("img");
                img.setAttribute("src", "../ajax/" + path_miniature["image"]);
                console.log(path_miniature["image"]);
                let close = document.createElement("button");
                close.setAttribute("class", "dd-del");
                close.setAttribute("href", `../ajax/cancel_drop.php?path=`+ path_miniature["image"] + `&HQ=` + path_HQ)
                close.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let unlink_photo = new XMLHttpRequest();

                    unlink_photo.open("GET", close.getAttribute("href"), true);
                    unlink_photo.send();
                    thumbnails.style.display = "none";
                });



                close.value = "X";
                close.innerHTML = "X";
                close.style.position = "absolute";
                close.style.top = "0";
                close.style.left = "0";

                thumbnails.appendChild(img);
                thumbnails.appendChild(close);
                gallery.appendChild(thumbnails);

            }

        }
    };

    http_request.open("POST", form.getAttribute("action"), true);
    http_request.send(formData);
}

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;

    handleFiles(files)
}

event.forEach(function (value) {
    drop_area.addEventListener(value, function (e) {
        e.preventDefault();
        e.stopPropagation();

        handleDrop(e);
    })
});



let buttons = document.querySelectorAll('.dd-del');
console.log(buttons)
for (let i = 0; i < buttons.length; i++) {

        buttons[i].addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let unlink_photo = new XMLHttpRequest();

        unlink_photo.open("GET", buttons[i].getAttribute("href"), true);
        unlink_photo.send();

        buttons[i].offsetParent.style.display = "none";
        console.log(buttons[i])
    })
}

