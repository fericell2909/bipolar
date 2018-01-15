export function isEnterKey(event) {
    const keyCode = event.which || event.keyCode;
    return (keyCode === 13);
}

export function isLeftClick(event) {
    return event.button === 0;
}

export function existInArray(theArray, value) {
    return theArray.findIndex(element => element === value) !== -1;
}

export function removeFromSimpleArray(theArray, value) {
    const indexElement = theArray.findIndex(element => element === value);
    if (indexElement !== -1) {
        theArray.splice(indexElement, 1);
    }
    return [...theArray];
}