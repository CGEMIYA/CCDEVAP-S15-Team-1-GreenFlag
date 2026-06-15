// ==========================================================================
// SIDEBAR CONTROL ARCHITECTURE
// ==========================================================================
const menuToggle = document.getElementById('menu-toggle');
const sidebarMenu = document.getElementById('sidebar-menu');
const sidebarOverlay = document.getElementById('sidebar-overlay');

function openSidebar() {
    sidebarMenu.classList.add('open');
    sidebarOverlay.classList.add('open');
}

function closeSidebar() {
    sidebarMenu.classList.remove('open');
    sidebarOverlay.classList.remove('open');
}

menuToggle.addEventListener('click', openSidebar);
sidebarOverlay.addEventListener('click', closeSidebar);

// Simulated verification runtime visual toggle logic
let isMockVerifiedUser = false;
function toggleVerificationMock() {
    isMockVerifiedUser = !isMockVerifiedUser;
    const verifiedItems = document.querySelectorAll('.verified-only');
    verifiedItems.forEach(el => {
        el.style.display = isMockVerifiedUser ? 'block' : 'none';
    });
    alert(`UI transformed to simulate: ${isMockVerifiedUser ? 'VERIFIED USER (Adds Games Panel Elements)' : 'UNVERIFIED USER'}`);
}

// ==========================================================================
// THEME SWITCH ENGINE RULES
// ==========================================================================
const themeBtn = document.getElementById('theme-btn');
themeBtn.addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    if (currentTheme === 'dark') {
        document.documentElement.removeAttribute('data-theme');
        themeBtn.textContent = '🌙';
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        themeBtn.textContent = '☀️';
    }
});

// Bind system home navigation triggers directly onto interactive items
document.getElementById('logo-home').addEventListener('click', () => switchView('view-home'));

// ==========================================================================
// DYNAMIC ITEM DATA DISPATCH ENGINE
// ==========================================================================
function openSpot(spotKey) {
    const data = spotsMockData[spotKey];
    if (!data) return;
    
    // Inject dynamic data directly into target structures within detail layout view
    document.getElementById('detail-title').textContent = data.title;
    document.getElementById('detail-location').textContent = data.location;
    document.getElementById('detail-rating').textContent = data.rating;
    document.getElementById('detail-price').textContent = data.price;
    document.getElementById('detail-desc').textContent = data.desc;
    
    // Build array components injection
    const tagsContainer = document.getElementById('detail-tags');
    tagsContainer.innerHTML = '';
    data.tags.forEach(tag => {
        const span = document.createElement('span');
        span.textContent = tag;
        tagsContainer.appendChild(span);
    });
    
    // Clean interactive comment area stream simulator container tracking
    document.getElementById('comments-container').innerHTML = `
        <div class="comment-card">
            <p class="comment-author">@username <span class="inline-wire-icon">✕</span></p>
            <p class="comment-text">Food was good at ${data.title}.</p>
        </div>
    `;
    
    // Switch View to designated panel target spot context
    switchView('view-spot-detail');
}

// Review processing stream simulator engine
document.getElementById('submit-review-btn').addEventListener('click', () => {
    const textarea = document.getElementById('new-review-text');
    const commentText = textarea.value.trim();
    
    if (commentText === "") {
        alert("Cannot post empty comment stream data!");
        return;
    }
    
    // Append structural comment dynamically
    const commentsContainer = document.getElementById('comments-container');
    const newCard = document.createElement('div');
    newCard.className = 'comment-card';
    newCard.innerHTML = `
        <p class="comment-author">@current_user <span class="inline-wire-icon">✕</span></p>
        <p class="comment-text">${commentText}</p>
    `;
    
    commentsContainer.insertBefore(newCard, commentsContainer.firstChild);
    textarea.value = ""; // Flush review target text content clear
});