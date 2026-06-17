/* ===== Bandan Bhagwati — front-end interactions (data is server-rendered) ===== */

/* ---- Mobile hero video carousel (one slide per hero video) ---- */
(function () {
  const track = document.getElementById("mHeroTrack");
  const dotsWrap = document.getElementById("mHeroDots");
  if (!track) return;
  const slides = Array.from(track.children);
  let current = 0;

  const playActive = () => {
    slides.forEach((s, j) => {
      const v = s.querySelector("video");
      if (!v) return;
      if (j === current) { v.muted = true; const p = v.play(); if (p && p.catch) p.catch(() => {}); }
      else { try { v.pause(); } catch (e) {} }
    });
  };

  // dots only when there is more than one slide
  let dots = [];
  if (dotsWrap && slides.length > 1) {
    slides.forEach((s, i) => {
      const b = document.createElement("button");
      b.type = "button";
      b.setAttribute("aria-label", "Slide " + (i + 1));
      if (i === 0) b.className = "active";
      b.addEventListener("click", () => track.scrollTo({ left: track.clientWidth * i, behavior: "smooth" }));
      dotsWrap.appendChild(b);
    });
    dots = Array.from(dotsWrap.children);
  }

  track.addEventListener("scroll", () => {
    const i = Math.round(track.scrollLeft / track.clientWidth);
    if (i === current) return;
    current = i;
    dots.forEach((d, j) => d.classList.toggle("active", j === current));
    playActive();
  });

  playActive();
})();

/* ---- Mobile nav (hamburger) ---- */
(function () {
  const toggle = document.getElementById("navToggle");
  const navBlue = toggle && toggle.closest(".nav-blue");
  if (!toggle || !navBlue) return;
  const setOpen = open => {
    navBlue.classList.toggle("open", open);
    toggle.classList.toggle("active", open);
    toggle.setAttribute("aria-expanded", open ? "true" : "false");
  };
  toggle.addEventListener("click", () => setOpen(!navBlue.classList.contains("open")));
  // close after tapping a link, or when tapping outside
  navBlue.querySelectorAll(".nav a").forEach(a => a.addEventListener("click", () => setOpen(false)));
  document.addEventListener("click", e => {
    if (navBlue.classList.contains("open") && !navBlue.contains(e.target)) setOpen(false);
  });
})();

/* ---- Photo album lightbox ---- */
(function () {
  const grid = document.getElementById("albumGrid");
  const lb = document.getElementById("lightbox");
  if (!grid || !lb) return;
  const img = document.getElementById("lbImg");
  const counter = document.getElementById("lbCounter");
  const thumbs = Array.from(grid.querySelectorAll(".photo-thumb"));
  let idx = 0;
  const show = i => {
    idx = (i + thumbs.length) % thumbs.length;
    img.src = thumbs[idx].dataset.full;
    counter.textContent = (idx + 1) + " / " + thumbs.length;
  };
  const open = i => { show(i); lb.classList.add("open"); lb.setAttribute("aria-hidden", "false"); document.body.style.overflow = "hidden"; };
  const close = () => { lb.classList.remove("open"); lb.setAttribute("aria-hidden", "true"); document.body.style.overflow = ""; };
  thumbs.forEach((t, i) => t.addEventListener("click", () => open(i)));
  document.getElementById("lbClose").addEventListener("click", close);
  document.getElementById("lbPrev").addEventListener("click", () => show(idx - 1));
  document.getElementById("lbNext").addEventListener("click", () => show(idx + 1));
  lb.addEventListener("click", e => { if (e.target === lb) close(); });
  document.addEventListener("keydown", e => {
    if (!lb.classList.contains("open")) return;
    if (e.key === "Escape") close();
    else if (e.key === "ArrowLeft") show(idx - 1);
    else if (e.key === "ArrowRight") show(idx + 1);
  });
})();

/* ---- Video album lightbox (plays YouTube / Vimeo / file in a modal) ---- */
(function () {
  const grid = document.getElementById("videoGrid");
  const lb = document.getElementById("vLightbox");
  if (!grid || !lb) return;
  const frame = document.getElementById("vLbFrame");
  const open = (type, embed) => {
    if (type === "file") {
      frame.innerHTML = '<video src="' + embed + '" controls autoplay playsinline></video>';
    } else {
      frame.innerHTML = '<iframe src="' + embed + '" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>';
    }
    lb.classList.add("open"); lb.setAttribute("aria-hidden", "false"); document.body.style.overflow = "hidden";
  };
  const close = () => { lb.classList.remove("open"); lb.setAttribute("aria-hidden", "true"); frame.innerHTML = ""; document.body.style.overflow = ""; };
  grid.querySelectorAll(".video-thumb").forEach(btn => btn.addEventListener("click", () => open(btn.dataset.type, btn.dataset.embed)));
  document.getElementById("vLbClose").addEventListener("click", close);
  lb.addEventListener("click", e => { if (e.target === lb) close(); });
  document.addEventListener("keydown", e => { if (e.key === "Escape" && lb.classList.contains("open")) close(); });
})();

/* ---- Section carousels: prev/next arrows scroll the .h-scroll track ---- */
document.querySelectorAll(".arrows").forEach(arrows => {
  const sec = arrows.closest("section");
  const track = sec && sec.querySelector(".h-scroll");
  if (!track) return;
  const b = arrows.querySelectorAll("button");
  const page = () => Math.max(track.clientWidth * 0.85, 260);
  if (b[0]) b[0].addEventListener("click", () => track.scrollBy({ left: -page(), behavior: "smooth" }));
  if (b[1]) b[1].addEventListener("click", () => track.scrollBy({ left: page(), behavior: "smooth" }));
});

/* ---- "See more / See less" collapsible blocks ---- */
document.querySelectorAll(".see-more-btn").forEach(btn => {
  const target = document.getElementById(btn.dataset.target);
  if (!target) return;
  btn.addEventListener("click", () => {
    const open = target.classList.toggle("open");
    const lbl = btn.querySelector(".lbl");
    if (lbl) lbl.textContent = open ? "See less" : "See more";
  });
});

/* ---- Hero background video: force muted autoplay (some browsers ignore the attribute) ---- */
document.querySelectorAll("video.hero-bg").forEach(v => {
  v.muted = true;
  v.setAttribute("muted", "");
  v.playsInline = true;
  const play = () => { const p = v.play(); if (p && p.catch) p.catch(() => {}); };
  play();
  v.addEventListener("loadeddata", play, { once: true });
  v.addEventListener("canplay", play, { once: true });
  // if the browser blocked autoplay, start on the first interaction
  const kick = () => { play(); document.removeEventListener("click", kick); document.removeEventListener("scroll", kick); };
  document.addEventListener("click", kick, { once: true });
  document.addEventListener("scroll", kick, { once: true });
});

/* ---- "More services" list on service-detail (just highlight) ---- */
document.querySelectorAll(".more-serv").forEach(list => {
  list.querySelectorAll(".serv-item").forEach(item => {
    item.addEventListener("click", () => {
      list.querySelectorAll(".serv-item").forEach(x => x.classList.remove("active"));
      item.classList.add("active");
    });
  });
});

/* ---- Services selector (home / about / service): clicking a list item updates the
        preview card in place; only "Explore now" navigates to the detail page. ---- */
document.querySelectorAll(".serv-list").forEach(list => {
  const section = list.closest(".services") || document;
  const card = section.querySelector(".serv-card");
  if (!card) return;
  const cardImg = card.querySelector(".serv-media img");
  const cardBtn = card.querySelector(".serv-media .btn");
  const cardTitle = card.querySelector(".body h3");
  const cardDesc = card.querySelector(".body p");

  const apply = item => {
    if (item.dataset.image && cardImg) cardImg.src = item.dataset.image;
    if (item.dataset.title && cardTitle) cardTitle.textContent = item.dataset.title;
    if (item.dataset.desc && cardDesc) cardDesc.textContent = item.dataset.desc;
    if (item.dataset.url && cardBtn) cardBtn.setAttribute("onclick", "location.href='" + item.dataset.url + "'");
  };

  list.querySelectorAll(".serv-item").forEach(item => {
    item.addEventListener("click", () => {
      list.querySelectorAll(".serv-item").forEach(x => x.classList.remove("active"));
      item.classList.add("active");
      apply(item);
    });
  });

  // initialise the card from the active (first) item
  apply(list.querySelector(".serv-item.active") || list.querySelector(".serv-item"));
});

/* ---- FAQ accordion ---- */
document.querySelectorAll(".faq-list").forEach(faqList => {
  const sync = () => faqList.querySelectorAll(".faq-item").forEach(it => {
    const a = it.querySelector(".faq-a");
    if (a) a.style.maxHeight = it.classList.contains("open") ? a.scrollHeight + 40 + "px" : "0px";
  });
  faqList.querySelectorAll(".faq-q").forEach(q => {
    q.addEventListener("click", () => {
      const item = q.parentElement;
      const wasOpen = item.classList.contains("open");
      faqList.querySelectorAll(".faq-item").forEach(x => x.classList.remove("open"));
      if (!wasOpen) item.classList.add("open");
      sync();
    });
  });
  sync();
});

/* ---- Project Ongoing/Completed toggle + Category filter (project page + home "Work in Action") ---- */
document.querySelectorAll(".proj-toggle").forEach(projToggle => {
  const section = projToggle.closest("section");
  if (!section) return;
  const grid = section.querySelector(".proj-grid");
  const tabs = projToggle.querySelectorAll("button");
  const catFilter = section.querySelector(".proj-cat-filter");
  const crumb = document.getElementById("projCrumb");
  const eyebrow = section.querySelector(".eyebrow");
  let curStatus = "ongoing";
  let curCat = "all";
  const render = () => {
    const name = curStatus === "completed" ? "Completed" : "Ongoing";
    if (crumb) crumb.textContent = name + " project";
    if (eyebrow) eyebrow.textContent = eyebrow.id === "projEyebrow" ? (name + " Project") : ("Our " + name + " Project");
    if (grid) grid.querySelectorAll(".proj-card").forEach(card => {
      const okStatus = card.dataset.set === curStatus;
      const okCat = curCat === "all" || card.dataset.cat === curCat;
      card.style.display = (okStatus && okCat) ? "" : "none";
    });
  };
  tabs.forEach(t => t.addEventListener("click", () => {
    tabs.forEach(x => x.classList.remove("active"));
    t.classList.add("active");
    curStatus = t.dataset.set;
    render();
  }));
  if (catFilter) catFilter.querySelectorAll("button").forEach(b => b.addEventListener("click", () => {
    catFilter.querySelectorAll("button").forEach(x => x.classList.remove("active"));
    b.classList.add("active");
    curCat = b.dataset.cat;
    render();
  }));
  const initial = projToggle.querySelector("button.active");
  curStatus = initial ? initial.dataset.set : "ongoing";
  render();
});

/* ---- Equipment category filter (equipment list page) ---- */
const equipFilter = document.querySelector(".equip-filter");
if (equipFilter) {
  const grid = document.getElementById("equipFilterGrid");
  const btns = equipFilter.querySelectorAll("button");
  const apply = cat => {
    if (!grid) return;
    grid.querySelectorAll(".eq-card").forEach(card => {
      card.style.display = (cat === "all" || card.dataset.cat === cat) ? "" : "none";
    });
  };
  btns.forEach(b => b.addEventListener("click", () => {
    btns.forEach(x => x.classList.remove("active"));
    b.classList.add("active");
    apply(b.dataset.cat);
  }));
  // apply the pre-selected category on load (e.g. arriving from a category card)
  const initial = equipFilter.querySelector("button.active");
  if (initial && initial.dataset.cat !== "all") apply(initial.dataset.cat);
}

/* ---- FAQ category filter (faq page): show only the chosen category's group ---- */
const faqFilter = document.querySelector(".faq-filter");
if (faqFilter) {
  const blocks = document.querySelectorAll(".faq-group-block");
  const btns = faqFilter.querySelectorAll("button");
  btns.forEach(b => b.addEventListener("click", () => {
    btns.forEach(x => x.classList.remove("active"));
    b.classList.add("active");
    const cat = b.dataset.cat;
    blocks.forEach(bl => { bl.style.display = (cat === "all" || bl.dataset.cat === cat) ? "" : "none"; });
  }));
}
