/* Service page — solutions grid + services list + FAQ */
const arrow = `<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>`;
const vmArrow = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M7 17 17 7M9 7h8v8"/></svg>`;

/* icons (white line-art on orange) */
const ic = {
  building: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M5 21V7l7-4 7 4v14"/><path d="M9 9h0M9 13h0M9 17h0M15 9h0M15 13h0M15 17h0"/></svg>`,
  renovate: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 21h18M6 21V10l6-4 6 4v11"/><path d="m14 13 4-4 3 3-4 4z"/></svg>`,
  robot: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5 5l2 2M17 17l2 2M19 5l-2 2M7 17l-2 2"/></svg>`,
  home: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="m3 11 9-7 9 7M5 10v10h14V10"/><path d="m9 14 2 2 4-4"/></svg>`,
  blueprint: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h6M7 12h4M14 16l3-3 1 1-3 3z"/></svg>`,
  crane: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 21V5l14-2v4M5 7h14M9 7v3M9 10h4v4H9z"/></svg>`,
  tower: `<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M9 21V3h6v18M9 7h6M9 11h6M9 15h6"/></svg>`,
};

const solutions = [
  ["building", "Building Construction"],
  ["renovate", "Commercial Renovate"],
  ["robot", "Automation & Robotics"],
  ["home", "Residential Construction"],
  ["blueprint", "Architecture Design"],
  ["crane", "Building Construction"],
  ["tower", "Building Construction"],
  ["building", "Building Construction"],
];
document.getElementById("svcGrid").innerHTML = solutions.map(s => `
  <a class="svc-card" href="/service-detail">
    <div class="top"><span class="ic">${ic[s[0]]}</span><h3>${s[1]}</h3></div>
    <p>After more than twenty years og success in the wood products industry.</p>
    <span class="view-more" style="font-size:15px">View more ${vmArrow}</span>
  </a>`).join("");

/* services accordion list */
const services = ["Road Works", "Irrigation and water supply", "Government Building Construction", "Privat Commercial Building", "Industrial / Bridge Construction"];
const servList = document.getElementById("servList");
servList.innerHTML = services.map((s, i) => `
  <div class="serv-item ${i === 0 ? "active" : ""}">
    <span>${s}</span>
    <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
  </div>`).join("");
servList.querySelectorAll(".serv-item").forEach(item => {
  item.addEventListener("click", () => {
    servList.querySelectorAll(".serv-item").forEach(x => x.classList.remove("active"));
    item.classList.add("active");
  });
});

/* FAQ */
const faqs = Array(5).fill("What construction services do you provide?");
const faqAnswer = "Fusce lacinia nulla consequat porta et viverra velit etiam, varius per condimentum lacus ultricies a placerat venatis semper donec id accumsan augue eleifend facili sis. Lectus arcu odio erat congue sociosqu ultricies";
const faqList = document.getElementById("faqList");
faqList.innerHTML = faqs.map((q, i) => `
  <div class="faq-item ${i === 0 ? "open" : ""}">
    <div class="faq-q"><span>${q}</span><span class="faq-plus">+</span></div>
    <div class="faq-a"><p>${faqAnswer}</p></div>
  </div>`).join("");
function syncFaq() {
  faqList.querySelectorAll(".faq-item").forEach(it => {
    const a = it.querySelector(".faq-a");
    a.style.maxHeight = it.classList.contains("open") ? a.scrollHeight + 40 + "px" : "0px";
  });
}
faqList.querySelectorAll(".faq-q").forEach(q => {
  q.addEventListener("click", () => {
    const item = q.parentElement;
    const wasOpen = item.classList.contains("open");
    faqList.querySelectorAll(".faq-item").forEach(x => x.classList.remove("open"));
    if (!wasOpen) item.classList.add("open");
    syncFaq();
  });
});
syncFaq();
