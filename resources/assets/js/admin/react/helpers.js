export function isEnterKey(event) {
    const keyCode = event.which || event.keyCode;
    return (keyCode === 13);
}

export function isLeftClick(event) {
    return event.button === 0;
}