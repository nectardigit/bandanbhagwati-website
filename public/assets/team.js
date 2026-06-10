/* Team list page */
const img = (id, w = 500, q = 80) =>
  `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=${w}&q=${q}`;

const social = `
  <a href="#" aria-label="Facebook"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3l.5-3H14V4.5c0-.9.3-1.5 1.6-1.5H18V.2A21 21 0 0 0 15.5 0C12.9 0 11 1.6 11 4.4V6H8v3h3v9h3z"/></svg></a>
  <a href="#" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
  <a href="#" aria-label="X"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h3l-7 8 8 12h-6l-5-6.5L6 22H3l7.5-9L3 2h6l4.5 6z"/></svg></a>
  <a href="#" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5A2.5 2.5 0 1 1 0 3.5a2.5 2.5 0 0 1 4.98 0zM0 8h5v16H0zM8 8h4.8v2.2h.06A5.3 5.3 0 0 1 17.6 8c5 0 5.9 3.3 5.9 7.6V24h-5v-7.5c0-1.8 0-4-2.5-4s-2.9 2-2.9 4V24H8z"/></svg></a>
  <a href="#" aria-label="YouTube"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 5 12 5 12 5s-7 0-8.9.4A3 3 0 0 0 1 7.5 31 31 0 0 0 .6 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1C5 19 12 19 12 19s7 0 8.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.4 12 31 31 0 0 0 23 7.5zM9.7 15.5v-7l6 3.5z"/></svg></a>`;

const team = [
  ["1573496359142-b8d87734a5a2", "Vincent smith", "Industrial Engineer and CEO"],
  ["1500648767791-00dcc994a43e", "Aarav Sharma", "Project Manager"],
  ["1438761681033-6461ffad8d80", "Sita Gurung", "Site Engineer"],
  ["1507003211169-0a1dd7228f2d", "Bikash Thapa", "Civil Engineer"],
  ["1494790108377-be9c29b29330", "Maya Rai", "Architect"],
  ["1517841905240-472988babdf9", "Anjali Karki", "Safety Officer"],
  ["1573497019940-1c28c88b4f3e", "Priya Lama", "Structural Engineer"],
  ["1519085360753-af0119f7cbe7", "Rohan Magar", "Surveyor"],
  ["1487412720507-e7ab37603c6f", "Nisha Shah", "Design Lead"],
  ["1463453091185-61582044d556", "Kiran Adhikari", "Foreman"],
];
document.getElementById("teamGrid").innerHTML = team.map(t => `
  <article class="team-card">
    <img src="${img(t[0])}" alt="${t[1]}">
    <div class="info">
      <b>${t[1]}</b><span>${t[2]}</span>
      <div class="ts">${social}</div>
    </div>
  </article>`).join("");
