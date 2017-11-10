export function isEnterKey(event) {
    const keyCode = event.which || event.keyCode;
    return (keyCode === 13);
}