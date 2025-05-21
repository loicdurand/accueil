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

  styleLinks();

  function styleLinks() {
    links.forEach((link, i) => {
      var deg = startPoint + (i * increment);
      link.style.transform = 'rotate(' + deg + 'deg)';
      hovers[i].style.transform = 'rotate(' + deg + 'deg)';
    });

  }

  window.onresize = function () {
    windowHeight = window.innerHeight;
    radius = windowHeight * 0.6;
    borderSize = radius * 0.021;
    fontSize = radius * 0.12;
    linkSize = radius * 0.25;
    styleLinks();
  }

}