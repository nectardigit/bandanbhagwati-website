/* Project page — ongoing / completed grid + toggle */
const img = (id, w = 600, q = 80) =>
  `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=${q}`;

const ongoing = [
  "1545324418-cc1a3fa10c00", "1486718448742-163732cd1544", "1529655683826-aba9b3e77383", "1496307653780-42ee777d4833",
  "1496307653780-42ee777d4833", "1545324418-cc1a3fa10c00", "1486718448742-163732cd1544", "1529655683826-aba9b3e77383",
];
const completed = [
  "1564013799919-ab600027ffc6", "1480714378408-67cf0d13bc1b", "1487958449943-2429e8be8625", "1503387762-592deb58ef4e",
  "1494891848038-7bd202a2afeb", "1460472178825-e5240623afd5", "1431576901776-e539bd916ba2", "1541888946425-d81bb19240f5",
];

const arrow2 = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h13M13 6l6 6-6 6"/></svg>`;

function render(set) {
  document.getElementById("projGrid").innerHTML = set.map(p => `
    <a class="proj-card" href="/project-detail">
      <img src="${img(p)}" alt="project">
      <div class="cap"><small>Building</small><b>Google Company</b></div>
      <span class="more">Explore more ${arrow2}</span>
    </a>`).join("");
}
render(ongoing);

const tabs = document.querySelectorAll(".proj-toggle button");
tabs.forEach(t => t.addEventListener("click", () => {
  tabs.forEach(x => x.classList.remove("active"));
  t.classList.add("active");
  render(t.dataset.set === "completed" ? completed : ongoing);
}));
