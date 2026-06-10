/* Blog Detail page — related posts sidebar */
const img = (id, w = 300, q = 80) =>
  `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=${q}`;

const related = [
  "1504307651254-35680f356dfd", "1581094794329-c8112a89af12", "1454165804606-c3d57bc86b40",
  "1521791136064-7986c2920216", "1503387762-592deb58ef4e",
];
document.getElementById("relList").innerHTML = related.map(r => `
  <a class="rel-card" href="#">
    <img src="${img(r)}" alt="related">
    <div>
      <div class="rmeta"><span>BY: Bandhan Nirman</span><span>Aug20,2025</span></div>
      <h4>Good buildings come from good people</h4>
    </div>
  </a>`).join("");
