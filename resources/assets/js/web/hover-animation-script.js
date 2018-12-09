$(function () {
  $(".bipolar-hovered-effect").hover(function (e) {
    // console.log(getDir($(this), e));
    const el_pos = $(this).offset();
    const edge = closestEdge(e.pageX - el_pos.left, e.pageY - el_pos.top, $(this).width(), $(this).height());
    const edgeAnimation = getAnimationByPosition(edge, true);
    const directChild = $(this).find('> .overlay-image').stop(true, true);
    directChild.css('opacity', '0.9').animateCss(`${edgeAnimation} faster`);
    // console.log(`mouse entered at ${edge}`);
    // console.log(`=========== START ANIMATION AT ${edge} ========`);
  }, function (e) {
    // console.log(getDir($(this), e));
    const el_pos = $(this).offset();
    const edge = closestEdge(e.pageX - el_pos.left, e.pageY - el_pos.top, $(this).width(), $(this).height());
    const edgeAnimation = getAnimationByPosition(edge, false);
    const directChild = $(this).find('> .overlay-image').stop(true, true);
    directChild.css('opacity', '0.9').animateCss(`${edgeAnimation} faster`, () => {
      let timeOut = setTimeout(directChild.css('opacity', '0'), 300);
      clearInterval(timeOut);
    });
    // console.log(`=========== END ANIMATION AT ${edge} ========`);
    // console.log(`mouse leave at ${edge}`);
  });

  const getDir = function( elem, e ) {
    /** the width and height of the current div **/
    var w = elem.width();
    var h = elem.height();
    var offset = elem.offset();
    /** calculate the x and y to get an angle to the center of the div from that x and y. **/
    /** gets the x value relative to the center of the DIV and "normalize" it **/
    var x = (e.pageX - offset.left - (w/2)) * ( w > h ? (h/w) : 1 );
    var y = (e.pageY - offset.top  - (h/2)) * ( h > w ? (w/h) : 1 );

    /** the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);**/
    /** first calculate the angle of the point,
     add 180 deg to get rid of the negative values
     divide by 90 to get the quadrant
     add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
    var direction = Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180 ) / 90 ) + 3 )  % 4;


    /** do your animations here **/
    switch(direction) {
      case 0:
        return 'top';
      case 1:
        return 'right';
      case 2:
        return 'bottom';
      case 3:
        return 'left';
    }
  };

  function getAnimationByPosition(edge, entering = true) {
    switch (edge) {
      case "left": return entering ? 'fadeInLeft' : 'fadeOutLeft';
      case "right": return entering ? 'fadeInRight' : 'fadeOutRight';
      case "bottom": return entering ? 'fadeInUp' : 'fadeOutDown';
      case "top": return entering ? 'fadeInDown' : 'fadeOutUp';
    }
  }

  function closestEdge(x, y, w, h) {
    var topEdgeDist = distMetric(x, y, w / 2, 0);
    var bottomEdgeDist = distMetric(x, y, w / 2, h);
    var leftEdgeDist = distMetric(x, y, 0, h / 2);
    var rightEdgeDist = distMetric(x, y, w, h / 2);

    var min = Math.min(topEdgeDist, bottomEdgeDist, leftEdgeDist, rightEdgeDist);
    switch (min) {
      case leftEdgeDist:
        return "left";
      case rightEdgeDist:
        return "right";
      case topEdgeDist:
        return "top";
      case bottomEdgeDist:
        return "bottom";
    }
  }

  function distMetric(x, y, x2, y2) {
    var xDiff = x - x2;
    var yDiff = y - y2;
    return (xDiff * xDiff) + (yDiff * yDiff);
  }
});