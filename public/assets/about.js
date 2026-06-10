/* About Us page — services list + FAQ only */
const arrow = `<span class="ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>`;

const services = [
  "Road Works",
  "Irrigation and water supply",
  "Government Building Construction",
  "Privat Commercial Building",
  "Industrial / Bridge Construction",
];
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
