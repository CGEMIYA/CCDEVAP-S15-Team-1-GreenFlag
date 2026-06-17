
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

setTimeout(updateCarousel, 100);

window.addEventListener('resize', updateCarousel);

function goToSpot(spotName) {
    window.location.href = "indiv_spot.html?spot=" + spotName;

function loadSpotData() {
    let params = new URLSearchParams(window.location.search);
    let spotName = params.get('spot');

    const spotData = {
        "CafeMasa": {
            title: "Cafe Masa",
            location: "Taft Ave.",
            rating: "4.4★ (34)",
            price: "$$",
            description: "Cafe to lock in for finals... quiet corners, decent wifi, and good food to keep you going.",
            tags: "<span>[Cafe]</span> <span>[Quiet]</span> <span>[Workspace]</span>",
            hours: "Hours : Open - 9:00AM until 10:00PM",
            noise: "Noise Level : [ Low ]",
            privacy: "Privacy Level : [ Medium ]"
        },
        "ArchersPlace": {
            title: "Archer's Place",
            location: "Taft Ave.",
            rating: "4.7★ (57)",
            price: "$$$",
            description: "Cool place to bring your friends. Clean environment, rapid connectivity. Perfect for standard group projects.",
            tags: "<span>[Quiet]</span> <span>[Hangout]</span>",
            hours: "Hours : Open - 8:00AM until 10:00PM",
            noise: "Noise Level : [ Low ]",
            privacy: "Privacy Level : [ Medium ]"
        },
        "SantosGarden": {
            title: "Santos Garden",
            location: "Taft Ave.",
            rating: "5.0★ (22)",
            price: "$$$$",
            description: "Free date spot far from traffic. Spacious, well-lit, and great for an evening walk before dinner.",
            tags: "<span>[Romantic]</span> <span>[Couple Photos]</span>",
            hours: "Hours : Open - 6:00AM until 9:00PM",
            noise: "Noise Level : [ Low ]",
            privacy: "Privacy Level : [ High ]"
        },
        "DeathToAladeen": {
            title: "Death To Aladeen",
            location: "Taft Ave.",
            rating: "4.2★ (67)",
            price: "$$",
            description: "Cheap Arab food. Fast service, generous portions, good for a quick solo meal or a casual group lunch.",
            tags: "<span>[Restaurant]</span> <span>[Ambient]</span> <span>[Cheap Eats]</span>",
            hours: "Hours : Open - 10:00AM until 9:00PM",
            noise: "Noise Level : [ Medium ]",
            privacy: "Privacy Level : [ Low ]"
        }
    };

    const data = spotData[spotName];
    if (data) {
        document.getElementById('title').innerHTML = data.title;
        document.getElementById('location').innerHTML = data.location;
        document.getElementById('rating').innerHTML = data.rating;
        document.getElementById('price').innerHTML = data.price;
        document.getElementById('description').innerHTML = data.description;
        document.getElementById('tags').innerHTML = data.tags;
        document.getElementById('hours').innerHTML = data.hours;
        document.getElementById('noise').innerHTML = data.noise;
        document.getElementById('privacy').innerHTML = data.privacy;
    }
}

window.onload = function() {
    loadSpotData();
    // Also set up carousel if on index page
    setTimeout(updateCarousel, 100);
};

function loadSpotData() {
    let title = document.getElementById('title');
    if (title == null) {
        return;
    }

    let params = new URLSearchParams(window.location.search);
    let spotName = params.get('spot');

    if (spotName == "CafeMasa") {
        document.getElementById('title').innerHTML = "Cafe Masa";
        document.getElementById('location').innerHTML = "Taft Ave.";
        document.getElementById('rating').innerHTML = "4.4* (34)";
        document.getElementById('price').innerHTML = "$$";
        document.getElementById('description').innerHTML = "Cafe to lock in for finals... quiet corners, decent wifi, and good food to keep you going.";
        document.getElementById('tags').innerHTML = "<span>[Cafe]</span> <span>[Quiet]</span> <span>[Workspace]</span>";
        document.getElementById('hours').innerHTML = "Hours : Open - 9:00AM until 10:00PM";
        document.getElementById('noise').innerHTML = "Noise Level : [ Low ]";
        document.getElementById('privacy').innerHTML = "Privacy Level : [ Medium ]";
    } 
    else if (spotName == "ArchersPlace") {
        document.getElementById('title').innerHTML = "Archer's Place";
        document.getElementById('location').innerHTML = "Taft Ave.";
        document.getElementById('rating').innerHTML = "4.7* (57)";
        document.getElementById('price').innerHTML = "$$$";
        document.getElementById('description').innerHTML = "Cool place to bring your friends. Clean environment, rapid connectivity. Perfect for standard group projects.";
        document.getElementById('tags').innerHTML = "<span>[Quiet]</span> <span>[Hangout]</span>";
        document.getElementById('hours').innerHTML = "Hours : Open - 8:00AM until 10:00PM";
        document.getElementById('noise').innerHTML = "Noise Level : [ Low ]";
        document.getElementById('privacy').innerHTML = "Privacy Level : [ Medium ]";
    }
    else if (spotName == "SantosGarden") {
        document.getElementById('title').innerHTML = "Santos Garden";
        document.getElementById('location').innerHTML = "Taft Ave.";
        document.getElementById('rating').innerHTML = "5.0* (22)";
        document.getElementById('price').innerHTML = "$$$$";
        document.getElementById('description').innerHTML = "Free date spot far from traffic. Spacious, well-lit, and great for an evening walk before dinner.";
        document.getElementById('tags').innerHTML = "<span>[Romantic]</span> <span>[Couple Photos]</span>";
        document.getElementById('hours').innerHTML = "Hours : Open - 6:00AM until 9:00PM";
        document.getElementById('noise').innerHTML = "Noise Level : [ Low ]";
        document.getElementById('privacy').innerHTML = "Privacy Level : [ High ]";
    }
    else if (spotName == "DeathToAladeen") {
        document.getElementById('title').innerHTML = "Death To Aladeen";
        document.getElementById('location').innerHTML = "Taft Ave.";
        document.getElementById('rating').innerHTML = "3.9* (61)";
        document.getElementById('price').innerHTML = "$$";
        document.getElementById('description').innerHTML = "Cheap Arab food. Fast service, generous portions, good for a quick solo meal or a casual group lunch.";
        document.getElementById('tags').innerHTML = "<span>[Restaurant]</span> <span>[Ambient]</span>";
        document.getElementById('hours').innerHTML = "Hours : Open - 10:00AM until 9:00PM";
        document.getElementById('noise').innerHTML = "Noise Level : [ Medium ]";
        document.getElementById('privacy').innerHTML = "Privacy Level : [ Low ]";
    }
}

window.onload = loadSpotData;

// Ratings & Review
let currRating = null;

function selectGreenFlag() {
    currRating = "green";
    document.getElementById('green-flag-btn').classList.add('selected');
    document.getElementById('red-flag-btn').classList.remove('selected');
}

function selectRedFlag() {
    currRating = "red";
    document.getElementById('red-flag-btn').classList.add('selected');
    document.getElementById('green-flag-btn').classList.remove('selected');
}

function postReview() {
    let reviewText = document.getElementById('new-review-text').value;

    if (reviewText == "") {
        alert("Please write a review first!");
        return;
    }

    if (currRating == null) {
        alert("Please select a Green Flag or a Red Flag!");
        return;
    }

    let icon = "green-flag-icon";
    if (currRating == "red") {
        icon = "red-flag-icon";
    }

    let newComment = "<div class='comment-card'>";
    newComment += "<p class='comment-author'>@current_user <span class='" + icon + "'>✕</span></p>";
    newComment += "<p class='comment-text'>" + reviewText + "</p>";
    newComment += "</div>";

    let container = document.getElementById('comments-container');
    container.innerHTML = newComment + container.innerHTML;

    // Clear review
    document.getElementById('new-review-text').value = "";
    document.getElementById('green-flag-btn').classList.remove('selected');
    document.getElementById('red-flag-btn').classList.remove('selected');
    currRating = null;
}
/*
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
*/

function switchView(viewId) {

    const allViews = document.querySelectorAll('.spa-view');

    if (allViews.length === 0) {
        window.location.href = 'index.html?view=' + viewId.replace('view-', '');
        return;
    }
    allViews.forEach(view => view.classList.remove('active-view'));
    const target = document.getElementById(viewId);
    if (target) {

        target.classList.add('active-view');
    }
}

window.addEventListener('load', () => {
    const params = new URLSearchParams(window.location.search);
    const requestedView = params.get('view');
    if (requestedView) {
        switchView('view-' + requestedView);
    }
});

function switchSettingsTab(tabName) {
    
    const allTabs = document.querySelectorAll('.settings-tab-content');
    allTabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    
    const allBtns = document.querySelectorAll('.settings-tab-btn');
    allBtns.forEach(btn => {
        btn.classList.remove('active');
    });
    
    
    const selectedTab = document.getElementById(`tab-${tabName}`);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    
    
    event.target.classList.add('active');
}

function updateEmail() {
    const currentEmail = document.getElementById('current-email').value;
    const newEmail = document.getElementById('new-email').value;
    const confirmEmail = document.getElementById('confirm-email').value;
    
    if (!newEmail || !confirmEmail) {
        alert('Please fill in all email fields');
        return;
    }
    
    if (newEmail !== confirmEmail) {
        alert('New emails do not match');
        return;
    }
    
    localStorage.setItem('userEmail', newEmail);
    alert('Email updated successfully!');
    document.getElementById('new-email').value = '';
    document.getElementById('confirm-email').value = '';
}

function updatePassword() {
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('Please fill in all password fields');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('New passwords do not match');
        return;
    }
    
    localStorage.setItem('userPassword', newPassword);
    alert('Password updated successfully!');
    document.getElementById('current-password').value = '';
    document.getElementById('new-password').value = '';
    document.getElementById('confirm-password').value = '';
}

function saveGeneral() {
    const general = {
        displayName: document.getElementById('display-name').value,
        bio: document.getElementById('bio').value,
        keepPublic: document.getElementById('keep-public').checked,
        showActivity: document.getElementById('show-activity').checked
    };
    
    if (!general.displayName) {
        alert('Please enter a display name');
        return;
    }
    
    localStorage.setItem('userGeneral', JSON.stringify(general));
    alert('General settings saved!');
}

function applyTheme() {
    const themeMode = document.querySelector('input[name="theme-mode"]:checked').value;
    const accentColor = localStorage.getItem('accentColor') || '#22c55e';
    
    if (themeMode === 'light') {
        document.documentElement.removeAttribute('data-theme');
    } else if (themeMode === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    
    localStorage.setItem('themeMode', themeMode);
    alert('Theme applied successfully!');
}

function selectAccentColor(color) {
    localStorage.setItem('accentColor', color);
    document.documentElement.style.setProperty('--accent-green', color);
}

function saveNotifications() {
    const notifications = {
        newReviews: document.getElementById('notify-reviews').checked,
        replies: document.getElementById('notify-replies').checked,
        marketing: document.getElementById('notify-marketing').checked,
        pushMessages: document.getElementById('notify-push').checked,
        emailFrequency: document.getElementById('email-frequency').value
    };
    
    localStorage.setItem('userNotifications', JSON.stringify(notifications));
    alert('Notification preferences saved!');
}


window.addEventListener('load', () => {
    
    const savedGeneral = localStorage.getItem('userGeneral');
    if (savedGeneral) {
        const general = JSON.parse(savedGeneral);
        document.getElementById('display-name').value = general.displayName;
        document.getElementById('bio').value = general.bio;
        document.getElementById('keep-public').checked = general.keepPublic;
        document.getElementById('show-activity').checked = general.showActivity;
    }
    
    const savedNotifications = localStorage.getItem('userNotifications');
    if (savedNotifications) {
        const notif = JSON.parse(savedNotifications);
        document.getElementById('notify-reviews').checked = notif.newReviews;
        document.getElementById('notify-replies').checked = notif.replies;
        document.getElementById('notify-marketing').checked = notif.marketing;
        document.getElementById('notify-push').checked = notif.pushMessages;
        document.getElementById('email-frequency').value = notif.emailFrequency;
    }
    
    const savedTheme = localStorage.getItem('themeMode');
    if (savedTheme) {
        document.getElementById(`mode-${savedTheme}`).checked = true;
    }
    
    const accentColor = localStorage.getItem('accentColor');
    if (accentColor) {
        document.documentElement.style.setProperty('--accent-green', accentColor);
    }
});

let postsDoughnutChartInstance = null;
let tagsPolarChartInstance = null;

function initAdminCharts() {
    const ctxPosts = document.getElementById('topPostsChart').getContext('2d');
    const ctxTags = document.getElementById('tagsPolarChart').getContext('2d');
    
    if (postsDoughnutChartInstance) postsDoughnutChartInstance.destroy();
    if (tagsPolarChartInstance) tagsPolarChartInstance.destroy();
    

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

let currentSlide = 0;
const track = document.getElementById('carousel-track');
const cards = track ? track.querySelectorAll('.spot-card') : [];
const cardsPerView = 3;
const totalSlides = Math.ceil(cards.length / cardsPerView);

function updateCarousel() {
    if (!track) return;
    const cardWidth = cards[0]?.offsetWidth || 280;
    const gap = 20;
    const slideWidth = (cardWidth + gap) * cardsPerView;
    const offset = currentSlide * slideWidth;
    track.style.transform = `translateX(-${offset}px)`;
}

function moveCarousel(direction) {
    if (cards.length === 0) return;
    currentSlide += direction;
    
    // Loop the carousel to back hereee
    if (currentSlide < 0) {
        currentSlide = totalSlides - 1;
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0;
    }
    
    updateCarousel();
}

document.querySelector('.left-arrow')?.addEventListener('click', () => moveCarousel(-1));
document.querySelector('.right-arrow')?.addEventListener('click', () => moveCarousel(1));

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById('topPostsChart')) {
        initAdminCharts();
    }
})}