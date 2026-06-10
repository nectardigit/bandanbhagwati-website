/* Project Detail page — gallery, key features, team */
const img = (id, w = 600, q = 80) =>
  `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=${q}`;

/* Gallery */
const gallery = [
  "1503387762-592deb58ef4e", "1541888946425-d81bb19240f5", "1504307651254-35680f356dfd", "1473341304170-971dccb5ac1e",
  "1581094794329-c8112a89af12", "1486718448742-163732cd1544", "1521791136064-7986c2920216", "1454165804606-c3d57bc86b40",
];
document.getElementById("galleryGrid").innerHTML =
  gallery.map(g => `<img src="${img(g)}" alt="gallery">`).join("");

/* Key features */
const features = [
  ["🏛️", "#fce9c9", "Modern Architecture"],
  ["🏢", "#fce9c9", "Smart Building"],
  ["♻️", "#d8f0dc", "Sustainable Design"],
  ["🛡️", "#fce9c9", "Advanced Security"],
  ["📶", "#fce9c9", "High-Speed Connectivity"],
  ["🅿️", "#fce9c9", "Smart Parking"],
];
document.getElementById("featList").innerHTML = features.map(f => `
  <div class="feat-card">
    <span class="fi" style="background:${f[1]}">${f[0]}</span>
    <div><h4>${f[2]}</h4><p>Contemporary design with glass facade and steel structure</p></div>
  </div>`).join("");

/* Team portraits */
const team = [
  "1573496359142-b8d87734a5a2", "1500648767791-00dcc994a43e", "1438761681033-6461ffad8d80",
  "1507003211169-0a1dd7228f2d", "1494790108377-be9c29b29330",
];
document.getElementById("teamRow").innerHTML =
  team.map(t => `<img src="${img(t, 500)}" alt="team member">`).join("");
