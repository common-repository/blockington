// Shared functions that provide various functionalities

function flipChevron(event) {
  let blockId = event.target.getAttribute('data-block-id');
  const chevron = document.getElementById(`chevron-${blockId}`);
  if(chevron.classList.contains("rs-blockington-flip-open")) {
    chevron.classList.add("rs-blockington-flip-close");
    chevron.classList.remove("rs-blockington-flip-open");
  } else {
    chevron.classList.add("rs-blockington-flip-open");
    chevron.classList.remove("rs-blockington-flip-close");
  }
}