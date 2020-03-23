export function isEnterKey(event) {
  const keyCode = event.which || event.keyCode;
  return keyCode === 13;
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

export function calculatePercentage(total, percentage, likeInteger = false) {
  const discount = total * (percentage / 100);

  if (likeInteger) {
    return parseInt(discount.toString());
  }

  return discount;
}

// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
export function debounce(func, wait, immediate?: boolean) {
  var timeout;

  return function executedFunction() {
    var context = this;
    var args = arguments;

    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };

    var callNow = immediate && !timeout;

    clearTimeout(timeout);

    timeout = setTimeout(later, wait);

    if (callNow) func.apply(context, args);
  };
}
