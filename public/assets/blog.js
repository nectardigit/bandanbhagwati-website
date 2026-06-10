/* Blog list page */
const img = (id, w = 600, q = 80) =>
  `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=${q}`;

const posts = [
  "1504307651254-35680f356dfd", "1503387762-592deb58ef4e", "1521791136064-7986c2920216", "1454165804606-c3d57bc86b40",
  "1454165804606-c3d57bc86b40", "1521791136064-7986c2920216", "1503387762-592deb58ef4e", "1504307651254-35680f356dfd",
];
document.getElementById("blogGrid").innerHTML = posts.map(p => `
  <a class="blog-card" href="/blog-detail">
    <div class="thumb"><img src="${img(p)}" alt="blog"></div>
    <div class="blog-meta"><span>BY: Bandhan Nirman</span><span>Aug20,2025</span></div>
    <h3>A Guide To Hassle-Free Cross-Border Shipping</h3>
  </a>`).join("");
