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

// SPOT DETAILS PLACEHOLDER DATA
const spotsData = {
    "archers-place": {
        title: "Archer's Place",
        location: "Taft Ave.",
        rating: "4.7* (57)",
        price: "$$$",
        description: "Cool place to bring your friends. Clean environment, rapid connectivity. Perfect for standard group projects.",
        tags: ["Quiet", "Hangout"],
        hours: "Open - 8:00AM until 10:00PM",
        noise: "Low",
        privacy: "Medium"
    },
        "cafe-masa": {
        title: "Cafe Masa",
        location: "Taft Ave.",
        rating: "4.1★ (34)",
        price: "$$$",
        description: "Cafe to lock in for finals... quiet corners, decent wifi, and good food to keep you going.",
        tags: ["Cafe", "Quiet", "Workspace"],
        hours: "Open - 9:00AM until 10:00PM",
        noise: "Low",
        privacy: "Medium"
    },
    "santos-garden": {
        title: "Santos Garden",
        location: "Taft Ave.",
        rating: "5.0★ (22)",
        price: "$$$$",
        description: "Free date spot far from traffic. Spacious, well-lit, and great for an evening walk before dinner.",
        tags: ["Romantic", "Couple Photos", "Ambiance"],
        hours: "Open - 6:00AM until 9:00PM",
        noise: "Low",
        privacy: "High"
    },
    "death-to-aladeen": {
        title: "Death to Aladeen",
        location: "Taft Ave.",
        rating: "4.2★ (67)",
        price: "$$",
        description: "Cheap Arab food. Fast service, generous portions, good for a quick solo meal or a casual group lunch.",
        tags: ["Restaurant", "Ambient"],
        hours: "Open - 10:00AM until 9:00PM",
        noise: "Medium",
        privacy: "Low"
    }
}

// INDIVIDUAL SPOT DETAILS
function goToSpot(spotName) {
    window.location.href = "indiv_spot.html?spot=" + spotName;
}

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
});*/


// SETTINGS & ACCOUNT MANAGEMENT

function switchView(viewId) {

    const allViews = document.querySelectorAll('.spa-view');

    if (allViews.length === 0) {
        window.location.href = 'homepage.html?view=' + viewId.replace('view-', '');
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