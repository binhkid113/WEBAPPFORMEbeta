const imageUrls = {
  salmon:
    "https://images.unsplash.com/photo-1574781330855-d0db8cc6a79c?auto=format&fit=crop&w=900&q=80",
  produce:
    "https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=80",
  bento:
    "https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=900&q=80",
  milk:
    "https://images.unsplash.com/photo-1563636619-e9143da7973b?auto=format&fit=crop&w=900&q=80",
  bread:
    "https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80"
};

const posts = [
  {
    id: 1,
    type: "image",
    title: "Half-price salmon packs at AEON",
    description:
      "Look for the red 50% sticker near the fresh fish corner. Good for dinner tonight.",
    store: "AEON Takamatsu",
    distance: "0.8 km",
    time: "18 min ago",
    expires: "Ends tonight",
    saving: "Save about ¥480",
    image: imageUrls.salmon,
    author: "Minh",
    avatar: "M",
    badge: "Trusted",
    likes: 42,
    comments: 9,
    viewers: 18,
    tags: ["#fish", "#dinner", "#kanji-help"],
    commentsList: [
      ["Ana", "I just checked this shelf. Still a few packs left."],
      ["Sam", "The sticker says best before today, so cook it soon."]
    ]
  },
  {
    id: 2,
    type: "text",
    title: "Tip: yellow stickers usually start after 7 PM",
    description:
      "In my local supermarket, bentos and fried food get cheaper after 7 PM. Check the ready-meal area first.",
    store: "Marunaka",
    distance: "1.1 km",
    time: "34 min ago",
    expires: "Useful daily",
    saving: "Save ¥200-¥600",
    author: "Lina",
    avatar: "L",
    badge: "Guide",
    likes: 58,
    comments: 14,
    viewers: 31,
    tags: ["#beginner", "#bento", "#life-tip"],
    commentsList: [
      ["Ravi", "This helped me yesterday. The staff marked things down around 19:20."],
      ["Maya", "Same at my store, but weekends start a bit earlier."]
    ]
  },
  {
    id: 3,
    type: "image",
    title: "Vegetables bundle for curry week",
    description:
      "Potatoes, carrots, onions. The sign says limited quantity, but there were many left.",
    store: "YouMe Town",
    distance: "1.9 km",
    time: "1 hr ago",
    expires: "2 hours left",
    saving: "Save about ¥320",
    image: imageUrls.produce,
    author: "Ravi",
    avatar: "R",
    badge: "Helpful",
    likes: 25,
    comments: 5,
    viewers: 12,
    tags: ["#vegetarian", "#curry", "#cheap"],
    commentsList: [["Minh", "Great for meal prep. Thanks!"]]
  },
  {
    id: 4,
    type: "image",
    title: "Bento corner markdown at 8 PM",
    description:
      "Chicken karaage bento dropped from ¥498 to ¥298. No English label, but photo helps.",
    store: "Fuji Grand",
    distance: "2.4 km",
    time: "2 hr ago",
    expires: "Night deal",
    saving: "Save ¥200",
    image: imageUrls.bento,
    author: "Ana",
    avatar: "A",
    badge: "Local MVP",
    likes: 36,
    comments: 7,
    viewers: 21,
    tags: ["#bento", "#night", "#photo-help"],
    commentsList: [["Lina", "The kanji says chicken, right? Good to know."]]
  },
  {
    id: 5,
    type: "image",
    title: "Milk discount: check expiry date",
    description:
      "Cheap milk near the back of the dairy shelf. Good if you use it within two days.",
    store: "MaxValu",
    distance: "3.0 km",
    time: "Yesterday",
    expires: "Today only",
    saving: "Save ¥90",
    image: imageUrls.milk,
    author: "Sam",
    avatar: "S",
    badge: "New helper",
    likes: 18,
    comments: 3,
    viewers: 6,
    tags: ["#milk", "#breakfast", "#date-check"],
    commentsList: [["Ravi", "Good reminder to check the date."]]
  }
];

const leaders = [
  { name: "Ana", value: "¥8,420 saved", badge: "Local MVP" },
  { name: "Minh", value: "34 useful posts", badge: "Trusted" },
  { name: "Lina", value: "91 helpful votes", badge: "Guide" }
];

const stores = [
  { name: "AEON Takamatsu", deals: "8 posts today", distance: "0.8 km", pin: "A" },
  { name: "Marunaka", deals: "5 posts today", distance: "1.1 km", pin: "M" },
  { name: "YouMe Town", deals: "4 posts today", distance: "1.9 km", pin: "Y" },
  { name: "Fuji Grand", deals: "3 posts today", distance: "2.4 km", pin: "F" }
];

let state = {
  screen: "home",
  selectedPostId: 1,
  theme: localStorage.getItem("otoku-theme") || "dark",
  filter: "All"
};

const root = document.querySelector("#screen-root");
const navItems = document.querySelectorAll(".nav-item");

function init() {
  document.body.classList.toggle("light", state.theme === "light");
  bindGlobalEvents();
  render();
  refreshIcons();
}

function bindGlobalEvents() {
  document.addEventListener("click", (event) => {
    const screenButton = event.target.closest("[data-screen]");
    const actionButton = event.target.closest("[data-action]");
    const postButton = event.target.closest("[data-post-id]");
    const filterButton = event.target.closest("[data-filter]");

    if (screenButton) {
      setScreen(screenButton.dataset.screen);
      return;
    }

    if (actionButton) {
      handleAction(actionButton.dataset.action);
      return;
    }

    if (postButton) {
      state.selectedPostId = Number(postButton.dataset.postId);
      if (postButton.dataset.openDetail === "true") {
        setScreen("detail");
      } else {
        render();
      }
      return;
    }

    if (filterButton) {
      state.filter = filterButton.dataset.filter;
      render();
    }
  });
}

function handleAction(action) {
  if (action === "toggle-theme") {
    state.theme = state.theme === "dark" ? "light" : "dark";
    localStorage.setItem("otoku-theme", state.theme);
    document.body.classList.toggle("light", state.theme === "light");
    return;
  }

  if (action === "open-profile") {
    setScreen("profile");
  }

  if (action === "next-post") {
    const currentIndex = posts.findIndex((post) => post.id === state.selectedPostId);
    const next = posts[(currentIndex + 1) % posts.length];
    state.selectedPostId = next.id;
    render();
  }
}

function setScreen(screen) {
  state.screen = screen;
  root.scrollTo({ top: 0, behavior: "smooth" });
  render();
}

function render() {
  const screens = {
    home: renderHome,
    search: renderSearch,
    create: renderCreate,
    nearby: renderNearby,
    profile: renderProfile,
    notifications: renderNotifications,
    detail: renderDetail
  };

  root.innerHTML = screens[state.screen]();
  updateNav();
  refreshIcons();
}

function updateNav() {
  navItems.forEach((item) => {
    item.classList.toggle("active", item.dataset.screen === state.screen);
  });
}

function refreshIcons() {
  if (window.lucide) {
    window.lucide.createIcons();
  }
}

function getSelectedPost() {
  return posts.find((post) => post.id === state.selectedPostId) || posts[0];
}

function renderHome() {
  const post = getSelectedPost();
  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <h2>Deals from people near you</h2>
          <p>Photos, text tips, and quick notes from foreigners living in Japan.</p>
        </div>
        <span class="status-pill"><span data-lucide="map-pin"></span> Takamatsu</span>
      </div>

      <div class="chip-row">
        ${["All", "Near me", "Text tips", "Photos", "Ending soon"].map((filter) => `
          <button class="chip ${state.filter === filter ? "active" : ""}" type="button" data-filter="${filter}">${filter}</button>
        `).join("")}
      </div>

      <article
        class="hero-post ${post.type === "image" ? "image" : "text-only"}"
        ${post.type === "image" ? `style="background-image:url('${post.image}')"` : ""}
        data-action="next-post"
        aria-label="Featured post"
      >
        <div class="hero-content">
          <div class="hero-top">
            <span class="deal-badge">${post.expires}</span>
            <span class="viewer-badge">${post.viewers} viewing</span>
          </div>
          <div class="hero-bottom">
            <div class="author-line">
              <span class="avatar small ${avatarTone(post.avatar)}">${post.avatar}</span>
              <span>${post.author}</span>
              <small>${post.badge}</small>
            </div>
            <div>
              <h3 class="hero-title">${post.title}</h3>
              <p class="hero-desc">${post.description}</p>
            </div>
            <span class="saving-chip">${post.saving}</span>
            <div class="meta-line">
              <span data-lucide="store"></span>
              <span>${post.store}</span>
              <span>•</span>
              <span>${post.distance}</span>
              <span>•</span>
              <span>${post.time}</span>
            </div>
            <div class="social-line">
              <span data-lucide="heart"></span><span>${post.likes}</span>
              <span data-lucide="message-circle"></span><span>${post.comments}</span>
              <span>${post.tags.slice(0, 2).join(" ")}</span>
            </div>
          </div>
        </div>
      </article>

      <div class="thumb-grid">
        ${posts.map(renderThumb).join("")}
      </div>

      <section class="panel">
        <div class="panel-title">
          <h3>Top helpers this week</h3>
          <small>Community trust</small>
        </div>
        <div class="leaderboard">
          ${leaders.map((leader, index) => `
            <div class="leader-row">
              <span class="rank">${index + 1}</span>
              <div>
                <strong>${leader.name}</strong>
                <span>${leader.value}</span>
              </div>
              <span class="badge">${leader.badge}</span>
            </div>
          `).join("")}
        </div>
      </section>
    </div>
  `;
}

function renderThumb(post) {
  return `
    <button class="thumb-card ${post.id === state.selectedPostId ? "active" : ""}" type="button" data-post-id="${post.id}">
      ${
        post.type === "image"
          ? `<div class="thumb-image" style="background-image:url('${post.image}')"></div>`
          : `<div class="thumb-text-bg">TEXT</div>`
      }
      <div class="thumb-body">
        <strong>${post.title}</strong>
        <span>${post.store}</span>
      </div>
    </button>
  `;
}

function renderSearch() {
  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <h2>Search deals</h2>
          <p>Find food, shops, tags, or kanji-help posts.</p>
        </div>
      </div>

      <div class="search-box">
        <span data-lucide="search"></span>
        <input type="search" value="" placeholder="Search milk, bento, halal, AEON..." />
      </div>

      <div class="chip-row">
        ${["#kanji-help", "#halal", "#vegetarian", "#night-deal", "#beginner"].map((tag) => `
          <button class="chip" type="button">${tag}</button>
        `).join("")}
      </div>

      <section class="post-list">
        ${posts.map((post) => renderPostRow(post)).join("")}
      </section>
    </div>
  `;
}

function renderCreate() {
  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <h2>Create a post</h2>
          <p>Post a photo, write a text tip, or combine both. Keep it simple for new arrivals.</p>
        </div>
      </div>

      <form class="form-panel">
        <div class="upload-zone">
          <div>
            <span data-lucide="image-plus"></span>
            <strong>Add product or sale photo</strong>
            <span>Photos help others understand kanji labels, sale stickers, and shelf locations.</span>
          </div>
        </div>

        <div class="field">
          <label for="post-title">Post title</label>
          <input id="post-title" type="text" placeholder="Example: 50% off salmon at AEON" />
        </div>

        <div class="field">
          <label for="post-body">Description in English</label>
          <textarea id="post-body" placeholder="Explain what the kanji sign means, where the shelf is, and when the deal ends."></textarea>
        </div>

        <div class="form-grid">
          <div class="field">
            <label for="store-name">Store name</label>
            <input id="store-name" type="text" placeholder="AEON Takamatsu" />
          </div>
          <div class="field">
            <label for="saving">Estimated saving</label>
            <input id="saving" type="text" placeholder="¥480" />
          </div>
        </div>

        <div class="form-grid">
          <div class="field">
            <label for="tag">Useful tag</label>
            <select id="tag">
              <option>#kanji-help</option>
              <option>#halal</option>
              <option>#vegetarian</option>
              <option>#night-deal</option>
              <option>#beginner</option>
            </select>
          </div>
          <div class="field">
            <label for="expires">Deal status</label>
            <select id="expires">
              <option>Ends tonight</option>
              <option>Today only</option>
              <option>This week</option>
              <option>Useful daily tip</option>
            </select>
          </div>
        </div>

        <p class="form-help">Clear posts help new arrivals shop with more confidence.</p>

        <div class="button-row">
          <button class="ghost-button" type="button" data-screen="home">
            <span data-lucide="x"></span> Cancel
          </button>
          <button class="primary-button" type="button">
            <span data-lucide="send"></span> Publish preview
          </button>
        </div>
      </form>
    </div>
  `;
}

function renderNearby() {
  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <h2>Nearby deals</h2>
          <p>Find recent community posts around your current shopping area.</p>
        </div>
        <span class="status-pill"><span data-lucide="navigation"></span> 3 km</span>
      </div>

      <section class="map-panel">
        <div class="map-canvas">
          <div class="map-route"></div>
          <button class="pin mint" style="left: 18%; top: 24%;" data-label="A" type="button" aria-label="AEON pin"></button>
          <button class="pin sky" style="left: 64%; top: 35%;" data-label="M" type="button" aria-label="Marunaka pin"></button>
          <button class="pin amber" style="left: 42%; top: 64%;" data-label="Y" type="button" aria-label="YouMe Town pin"></button>
          <button class="pin" style="left: 75%; top: 68%;" data-label="F" type="button" aria-label="Fuji Grand pin"></button>
        </div>
        <div class="store-list">
          ${stores.map((store) => `
            <div class="store-card">
              <div>
                <strong>${store.name}</strong>
                <span>${store.deals} • ${store.distance}</span>
              </div>
              <span class="tiny-pill green">${store.pin}</span>
            </div>
          `).join("")}
        </div>
      </section>

      <section class="post-list">
        ${posts.slice(0, 3).map((post) => renderPostRow(post)).join("")}
      </section>
    </div>
  `;
}

function renderProfile() {
  return `
    <div class="screen">
      <section class="profile-hero">
        <div class="profile-top">
          <div class="profile-avatar">M</div>
          <div>
            <h2>Minh Nguyen</h2>
            <p>New in Japan • Takamatsu • English/Vietnamese</p>
          </div>
        </div>
        <div class="profile-stats">
          <div><strong>24</strong><span>Posts</span></div>
          <div><strong>¥12,840</strong><span>Total saved</span></div>
          <div><strong>148</strong><span>Helpful votes</span></div>
        </div>
        <div class="tag-row">
          <span class="tiny-pill green">Trusted helper</span>
          <span class="tiny-pill">#kanji-help</span>
          <span class="tiny-pill">#budget-life</span>
        </div>
      </section>

      <section class="panel">
        <div class="panel-title">
          <h3>Saved posts</h3>
          <small>Useful later</small>
        </div>
        <div class="post-list">
          ${posts.slice(0, 3).map((post) => renderPostRow(post)).join("")}
        </div>
      </section>
    </div>
  `;
}

function renderNotifications() {
  const items = [
    ["heart", "Ana liked your post", "Half-price salmon helped her find dinner tonight.", "Now", true],
    ["message-circle", "New comment from Ravi", "He added the exact time Marunaka starts markdowns.", "12m", true],
    ["badge-check", "You earned Trusted helper", "Your last 5 posts were marked useful by the community.", "1h", false],
    ["map-pin", "New deal near you", "AEON Takamatsu has a fresh fish discount post.", "2h", false]
  ];

  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <h2>Notifications</h2>
          <p>Keep users returning with likes, comments, and nearby deal alerts.</p>
        </div>
      </div>

      <div class="notification-list">
        ${items.map(([icon, title, copy, time, unread]) => `
          <article class="notification-item ${unread ? "unread" : ""}">
            <span class="icon-button"><span data-lucide="${icon}"></span></span>
            <div class="notification-copy">
              <strong>${title}</strong>
              <p>${copy}</p>
            </div>
            <span class="tiny-pill">${time}</span>
          </article>
        `).join("")}
      </div>
    </div>
  `;
}

function renderDetail() {
  const post = getSelectedPost();
  return `
    <div class="screen">
      <div class="screen-heading">
        <div>
          <button class="ghost-button" type="button" data-screen="home">
            <span data-lucide="arrow-left"></span> Back
          </button>
        </div>
        <span class="status-pill">${post.expires}</span>
      </div>

      ${
        post.type === "image"
          ? `<div class="detail-image" style="background-image:url('${post.image}')"></div>`
          : `<div class="detail-text-card"><h2>${post.title}</h2><p>${post.description}</p></div>`
      }

      <section class="detail-body">
        <div class="author-line">
          <span class="avatar small ${avatarTone(post.avatar)}">${post.avatar}</span>
          <span>${post.author}</span>
          <small>${post.badge}</small>
        </div>
        <h2>${post.title}</h2>
        <p class="hero-desc">${post.description}</p>
        <span class="saving-chip">${post.saving}</span>
        <div class="meta-line">
          <span data-lucide="store"></span>
          <span>${post.store}</span>
          <span>•</span>
          <span>${post.distance}</span>
          <span>•</span>
          <span>${post.time}</span>
        </div>
        <div class="tag-row">
          ${post.tags.map((tag) => `<span class="tiny-pill">${tag}</span>`).join("")}
        </div>
      </section>

      <section class="panel">
        <div class="panel-title">
          <h3>Comments</h3>
          <small>${post.comments} total</small>
        </div>
        <div class="comment-box">
          ${post.commentsList.map(([name, copy]) => `
            <div class="comment-line">
              <span class="avatar small ${avatarTone(name[0])}">${name[0]}</span>
              <div>
                <strong>${name}</strong>
                <p>${copy}</p>
              </div>
            </div>
          `).join("")}
        </div>
      </section>
    </div>
  `;
}

function renderPostRow(post) {
  return `
    <article class="post-row" data-post-id="${post.id}" data-open-detail="true">
      ${
        post.type === "image"
          ? `<div class="post-row-image" style="background-image:url('${post.image}')"></div>`
          : `<div class="post-row-image text-mini-card"><strong>TEXT</strong></div>`
      }
      <div class="post-row-content">
        <span>${post.store} • ${post.distance}</span>
        <h3>${post.title}</h3>
        <p>${post.description}</p>
        <div class="tag-row">
          <span class="tiny-pill green">${post.saving}</span>
          <span class="tiny-pill">${post.expires}</span>
        </div>
      </div>
    </article>
  `;
}

function avatarTone(letter) {
  const tones = {
    A: "coral",
    L: "sky",
    R: "amber",
    S: "sky"
  };
  return tones[letter] || "";
}

init();
