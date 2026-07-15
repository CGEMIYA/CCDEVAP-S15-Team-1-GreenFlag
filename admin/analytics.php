<?php 
$pageTitle = 'Dashboard'; 
include 'includes/header.php'; 
?> 

<div class="wrapper"> 
    <?php include 'includes/sidebar.php'; ?> 
    
    <div class="main"> 
        <?php include 'includes/topbar.php'; ?> 
        
        <div class="content"> 
            <div class="row"> 
                <div class="col-lg-3"> 
                    <div class="card shadow-sm"> 
                        <div class="card-body"> 
                            <h6>Pending Reviews</h6> 
                            <h2>0</h2> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-3"> 
                    <div class="card shadow-sm"> 
                        <div class="card-body"> 
                            <h6>Total Users</h6> 
                            <h2>0</h2> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-3"> 
                    <div class="card shadow-sm"> 
                        <div class="card-body"> 
                            <h6>Total Spots</h6> 
                            <h2>0</h2> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-3"> 
                    <div class="card shadow-sm"> 
                        <div class="card-body"> 
                            <h6>Total Favorites</h6> 
                            <h2>0</h2> 
                        </div> 
                    </div> 
                </div> 
            </div> 
            
            <br> 
            
            <div class="row"> 
                <div class="col-lg-8"> 
                    <div class="card shadow-sm"> 
                        <div class="card-header">Review Activity</div> 
                        <div class="card-body"> 
                            <canvas id="reviewChart"></canvas> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4"> 
                    <div class="card shadow-sm"> 
                        <div class="card-header">User Status</div> 
                        <div class="card-body"> 
                            <canvas id="userChart"></canvas> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<?php include 'includes/footer.php'; ?>
