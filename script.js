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

if (menuToggle) menuToggle.addEventListener('click', openSidebar);
if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

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
if(themeBtn){
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
}


// Bind system home navigation triggers directly onto interactive items
const logoHome = document.getElementById('logo-home');
if (logoHome) { // <--- Safe Check Guard Added
    logoHome.addEventListener('click', () => {
        window.location.href = 'homepage.html';
    });
}

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
const submitReviewBtn= document.getElementById('submit-review-btn');
if(submitReviewBtn){
        submitReviewBtn.addEventListener('click', () => {
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
}


// ==========================================================================
// ANALYTICS CHARTJS RENDERING ENGINES (ADMIN WORKSPACE DEPENDENCIES)
// ==========================================================================
let postsDoughnutChartInstance = null;
let tagsPolarChartInstance = null;

function initAdminCharts() {
    // Canvas context declarations
    const ctxPosts = document.getElementById('topPostsChart').getContext('2d');
    const ctxTags = document.getElementById('tagsPolarChart').getContext('2d');
    
    // Safety check sequence clearance to destroy old analytical runtime state instances on reallocation reruns
    if (postsDoughnutChartInstance) postsDoughnutChartInstance.destroy();
    if (tagsPolarChartInstance) tagsPolarChartInstance.destroy();
    
    // 1. Render Top 5 Most Reviewed Posts Doughnut Ring Visualizer
    postsDoughnutChartInstance = new Chart(ctxPosts, {
        type: 'doughnut',
        data: {
            labels: ['Cafe Masa', 'Manila Zoo', '4x4 Photobooth', 'Benilde Museum', 'Rooftop Cafe'],
            datasets: [{
                data: [367, 159, 134, 121, 73],
                backgroundColor: ['#4b5563', '#6b7280', '#9ca3af', '#d1d5db', '#e5e7eb'],
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '70%'
        }
    });

    // 2. Render Most Frequent Tags Polar Grid Graph Area Visualizer Map Chart
    tagsPolarChartInstance = new Chart(ctxTags, {
        type: 'polarArea',
        data: {
            labels: ['Hangout', 'Romantic', 'Chill', 'Workspace'],
            datasets: [{
                data: [75, 50, 65, 85],
                backgroundColor: [
                    'rgba(75, 85, 99, 0.7)',
                    'rgba(107, 114, 128, 0.7)',
                    'rgba(156, 163, 175, 0.7)',
                    'rgba(209, 213, 219, 0.7)'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { r: { ticks: { display: false } } }
        }
    });
}

// ==========================================================================
// AUTOMATED EXECUTION ROUTER ENTRY POINT
// ==========================================================================
document.addEventListener("DOMContentLoaded", () => {
    // Fire up charts automatically if canvas elements are on screen
    if (document.getElementById('topPostsChart')) {
        initAdminCharts();
    }
});