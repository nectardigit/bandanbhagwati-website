/* Shared mobile nav — injects hamburger + toggles menu on all pages */
(function () {
  document.querySelectorAll(".nav-blue").forEach(function (bar) {
    if (bar.querySelector(".hamburger")) return;
    var nav = bar.querySelector(".nav");
    if (!nav) return;
    var btn = document.createElement("button");
    btn.className = "hamburger";
    btn.setAttribute("aria-label", "Toggle menu");
    btn.innerHTML = "<span></span><span></span><span></span>";
    var actions = bar.querySelector(".nav-actions");
    if (actions) bar.insertBefore(btn, actions);
    else bar.appendChild(btn);
    btn.addEventListener("click", function () {
      bar.classList.toggle("open");
      btn.classList.toggle("active");
    });
    // close menu when a link is tapped
    nav.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () {
        bar.classList.remove("open");
        btn.classList.remove("active");
      });
    });
  });
})();
