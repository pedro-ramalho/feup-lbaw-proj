const dropdown = document.querySelector("#user-section");
const options = document.querySelector("#navigation-options");

function toggle() {
  options.classList.toggle("show");
}

dropdown.addEventListener("click", toggle)