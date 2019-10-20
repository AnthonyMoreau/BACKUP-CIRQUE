let textarea_ = document.getElementById('content');
let add_strong = document.getElementById("add-strong");
let add_h2 = document.getElementById("add-h2");
let font_big = document.getElementById("font-big");
let font_small = document.getElementById("font-small");
let paragraphe_ = document.getElementById("add-p");
let rewind = document.getElementById("cancel-add");
let link_ = document.getElementById("add-link");
let video_ = document.getElementById("add-video");
let center_ = document.getElementById("center");

let color_ = document.getElementById("color");

let preview_ = document.getElementById("preview");


/**
 * Variables d'instances
 */
let selection, tab_reset = [], value_, start, end, count = 0, element, color;



/**
 * Retour en arrière
 */
rewind.onclick = function () {
    count--;
    if (count < 0){count = 0}
    if (tab_reset[count] !== undefined){textarea_.value = tab_reset[count]}
    tab_reset.pop();
};

/**
 * init de la selection dans le textearea
 * @param e
 */
textarea_.onselect = function (e) {
    start = getStartSelection(e);
    end = getEndSelection(e);
    selection = getSelection(e);
    value_ = textarea_.value
};

/**
 * Init preview
 */
document.onmouseover = function (){
    preview();
    document.onclick = function () {
        preview();
    }
};



/**
 * Changer un mot ou plusieurs mots identiques en mots clés <strong>element</strong>
 */
add_strong.onclick = function () {
    initSuppr();
    addStrong(selection);
};

/**
 * Changer un mot ou plusieurs mots identiques en titre <h2>element</h2>
 */
add_h2.onclick = function () {
    initSuppr();
    addTitle(selection);
};

/**
 * reduit la taille de la police de la selection à 70%
 */
font_small.onclick = function () {
    initSuppr();
    smallFonts(selection);
};

/**
 * augmente la taille de la police de la selection à 130%
 */
font_big.onclick = function () {
    initSuppr();
    bigFonts(selection);
};

/**
 * transform la selection en paragraphe <p>element</p>
 */
paragraphe_.onclick = function () {
    initSuppr();
    paragraphe(selection);
};

/**
 * transform la selection en lien <a href="link">element</a>
 */
link_.onclick = function () {
    initSuppr();
    link(selection);
};

/**
 * insere un embbed youtube
 */
video_.onclick = function () {
    initSuppr();
    embbedYoutube();
};

/**
 * set color on element
 * @param e
 */
color_.oninput = function (e) {
    color = getColorValue(e)

};
color_.onchange = function () {
    initSuppr();
    Color(color, selection);
};

/**
 * Centre le texte
 */
center_.onclick = function () {
    initSuppr();
    Center(selection);
};




function addStrong(selection) {
    let t = '<strong>'+ selection +'</strong>';
    textarea_.value = replace(selection, t)
}

function addTitle(selection) {
    let t = '<h2>'+ selection +'</h2>';
    textarea_.value = replace(selection, t)
}

function smallFonts(selection) {
    let t = '<span style="font-size: 70%">'+ selection +'</span>';
    textarea_.value = replace(selection, t)
}

function bigFonts(selection) {
    let t = '<span style="font-size: 130%">'+ selection +'</span>';
    textarea_.value = replace(selection, t)
}

function paragraphe(selection) {
    let t = '<p>'+ selection +'</p>';
    textarea_.value = replace(selection, t)
}

function link(selection) {

    let modalBox = openModal("#toolbox-modal");

    let closebutton = document.getElementById('confirm-link');

    closebutton.onclick = function(){
        element = getInputValue('#input-link', modalBox);
        if (element !== ''){
            let t = '<a style="text-decoration: none" href="'+ element +'" target="_blank">'+ selection +'</a>';
            textarea_.value = replace(selection, t);
        }
    };
}



function getStartSelection(e) {
    return e.target.selectionStart
}

function getEndSelection(e) {
    return e.target.selectionEnd
}

function getSelection(e) {
    return e.target.value.substring(getStartSelection(e), getEndSelection(e))
}

function getInputValue(selector, modal) {
    modal.style.display = 'none';
    return document.querySelector(selector).value;
}

function openModal(selector) {
    let modalBox = document.querySelector(selector);
    modalBox.style.display = 'block';
    return modalBox
}

function initSuppr(){
    count++;
    tab_reset.push(value_);
}

function preview() {
    preview_.innerHTML = textarea_.value;
}

function replace(selection, value) {
    return textarea_.value.split(selection).join(value);
}

function embbedYoutube() {

    let modalBox = openModal("#toolbox-modal");

    let closebutton = document.getElementById('confirm-link');

    closebutton.onclick = function(){

        element = getInputValue('#input-link', modalBox);

        let l = element.split('=')[1];

        let t = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + l + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        textarea_.value = textarea_.value + `  ` + t;
    };

}

function getColorValue(e) {
    return e.target.value
}

function Color(color, selection){
    let t = '<div style="color: '+ color +'">'+ selection +'</div>';
    textarea_.value = replace(selection, t)
}

function Center(selection) {
    let t = '<div style="text-align: center">' + selection + '</div>';
    textarea_.value = replace(selection, t)
}
