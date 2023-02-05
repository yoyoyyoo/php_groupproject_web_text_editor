function changeFont(fontChoice) {
    if (fontChoice == "") {
        document.querySelector(".changeText").style.fontFamily = "Ariel";
    }
    else {
        document.querySelector(".changeText").style.fontFamily = fontChoice;
    }
}

function changeSize(sizeChoice) {
    document.querySelector(".changeText").style.fontSize = sizeChoice;
}
