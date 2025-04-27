let slideIndex = 1;

document.addEventListener("DOMContentLoaded", () => {
  showimg(slideIndex);
});

function plusimgs(n) {
  showimg(slideIndex += n);
}

function currentimg(n) {
  showimg(slideIndex = n);
}

function showimg(n) {
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");

  if (slides.length === 0 || dots.length === 0) {
    console.warn("No slides or dots found.");
    return;
  }

  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }

  for (let slide of slides) {
    slide.style.display = "none";
  }

  for (let dot of dots) {
    dot.className = dot.className.replace(" active", "");
  }

  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}
