// STYLES
import './styles/app.scss';

// JAVASCRIPTS
// import "/node_modules/@gouvfr/dsfr/dist/dsfr/dsfr.module";

if (location.pathname === '/') {

  const //
    inputs = document.getElementsByClassName('input-data'),
    datas = [...inputs].map(input => ({ ...input.dataset })),
    links = [...document.getElementsByClassName('link')],
    hovers = [...document.getElementsByClassName('hover')];

  let // 
    windowHeight = window.innerHeight || 238,
    radius = windowHeight * 0.6,
    borderSize = radius * 0.021,
    totalArea = 48,
    increment = totalArea / (datas.length - 1),
    startPoint = 0 - (totalArea / 2),
    fontSize = radius * 0.12,
    linkSize = radius * 0.25;

  links.forEach((link, i) => {
    link.addEventListener('mouseover', linkOver);
    link.addEventListener('mouseout', linkOut);
  });

  hovers.forEach((hover, i) => {
    hover.addEventListener('mouseover', hoverOver);
    hover.addEventListener('mouseout', hoverOut);
  });

  styleLinks();

  function styleLinks() {
    links.forEach((link, i) => {
      var deg = startPoint + (i * increment);
      setTransform(link, 'rotate(' + deg + 'deg)');
    });

    hovers.forEach((hover, i) => {
      var deg = startPoint + (i * increment);
      setTransform(hover, 'rotate(' + deg + 'deg)');
    })
  }

  window.onresize = function () {
    windowHeight = window.innerHeight;
    radius = windowHeight * 0.6;
    borderSize = radius * 0.021;
    fontSize = radius * 0.12;
    linkSize = radius * 0.25;
    styleLinks();
  }

  function linkOver(e) {
    var thisLink = e.target;
    thisLink.style.paddingLeft = radius * 1.25 + 'px';
  }

  function linkOut(e) {
    var thisLink = e.target;
    thisLink.style.paddingLeft = radius * 1.2 + 'px';
  }

  function hoverOver(e) {
    var thisHover = e.target;
    thisHover.style.opacity = 1;
  }

  function hoverOut(e) {
    var thisHover = e.target;
    thisHover.style.opacity = 0;
  }

  function setTransform(element, string) {
    element.style.webkitTransform = string;
    element.style.MozTransform = string;
    element.style.msTransform = string;
    element.style.OTransform = string;
    element.style.transform = string;
  }

  function setTransformOrigin(element, string) {
    element.style.webkitTransformOrigin = string;
    element.style.MozTransformOrigin = string;
    element.style.msTransformOrigin = string;
    element.style.OTransformOrigin = string;
    element.style.transformOrigin = string;
  }

  function setTransition(element, string) {
    element.style.webkitTransition = string;
    element.style.MozTransition = string;
    element.style.msTransition = string;
    element.style.OTransition = string;
    element.style.transition = string;
  }
}