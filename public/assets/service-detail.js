/* Service Details page — more services, expertise, FAQ */
const moreServices = [
  "Building construction", "Residential construction", "Commercial construction",
  "Renovation Planning", "Structural Engineering", "Home Building and Renovation",
];
const moreList = document.getElementById("moreList");
moreList.innerHTML = moreServices.map((s, i) => `
  <div class="serv-item ${i === -1 ? "active" : ""}">
    <span>${s}</span>
    <span class="dot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
  </div>`).join("");
moreList.querySelectorAll(".serv-item").forEach(item => {
  item.addEventListener("click", () => {
    moreList.querySelectorAll(".serv-item").forEach(x => x.classList.remove("active"));
    item.classList.add("active");
  });
});

/* expertise */
const expIcon = `<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2l2.2 4.6L19 7.3l-3.5 3.4.8 4.8L12 13.2 7.7 15.5l.8-4.8L5 7.3l4.8-.7z"/></svg>`;
const exp = document.getElementById("expGrid");
exp.innerHTML = Array(4).fill(0).map(() => `
  <div class="exp">
    <span class="ei">${expIcon}</span>
    <div><h4>Expertise</h4><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p></div>
  </div>`).join("");

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
