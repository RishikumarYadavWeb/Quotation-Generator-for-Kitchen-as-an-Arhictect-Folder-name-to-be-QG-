
<?php
include 'includes/auth.php';
include 'db.php';
/** @var mysqli $conn */
include 'includes/header.php';
include 'includes/sidebar.php';

/* =========================================
   OVERALL STATS
========================================= */

$totalQuotesQuery = "

SELECT COUNT(*) AS total_quotes

FROM quotations

";

$totalQuotesResult =
mysqli_query($conn, $totalQuotesQuery);

$totalQuotes =
mysqli_fetch_assoc($totalQuotesResult);

/* =========================================
   TOTAL VALUE
========================================= */

$totalValueQuery = "

SELECT SUM(final_customer_price) AS total_value

FROM quotations

";

$totalValueResult =
mysqli_query($conn, $totalValueQuery);

$totalValue =
mysqli_fetch_assoc($totalValueResult);

/* =========================================
   TOTAL SQFT
========================================= */

$totalSqftQuery = "

SELECT SUM(total_sqft) AS total_sqft

FROM quotations

";

$totalSqftResult =
mysqli_query($conn, $totalSqftQuery);

$totalSqft =
mysqli_fetch_assoc($totalSqftResult);

/* =========================================
   PROJECT TYPE STATS
========================================= */

$projectQuery = "

SELECT

project_type,

COUNT(*) AS total_projects,

SUM(total_sqft) AS total_sqft,

SUM(final_customer_price) AS total_value

FROM quotations

GROUP BY project_type

";

$projectResult =
mysqli_query($conn, $projectQuery);


/* =========================================
   MONTHLY REVENUE
========================================= */

$monthlyRevenueQuery = "

SELECT

DATE_FORMAT(created_at, '%b') AS month,

SUM(final_customer_price) AS revenue

FROM quotations

GROUP BY MONTH(created_at)

ORDER BY MONTH(created_at)

";

$monthlyRevenueResult =
mysqli_query($conn, $monthlyRevenueQuery);

$months = [];
$revenues = [];

while($row = mysqli_fetch_assoc($monthlyRevenueResult)){

    $months[] =
    $row['month'];

    $revenues[] =
    $row['revenue'];

}

/* =========================================
   PROJECT TYPE ANALYTICS
========================================= */

$projectChartQuery = "

SELECT

project_type,

COUNT(*) AS total_projects,

SUM(total_sqft) AS total_sqft

FROM quotations

GROUP BY project_type

";

$projectChartResult =
mysqli_query($conn, $projectChartQuery);

$projectLabels = [];
$projectCounts = [];
$projectSqfts = [];

while($row = mysqli_fetch_assoc($projectChartResult)){

    $projectLabels[] =
    $row['project_type'];

    $projectCounts[] =
    $row['total_projects'];

    $projectSqfts[] =
    $row['total_sqft'];

}


?>


<div class="dashboard-wrapper">

    <!-- =========================================
        HEADER
    ========================================== -->

    <div class="dashboard-header">

        <div>

            <h1 class="dashboard-main-title">

                Business Dashboard

            </h1>

            <p class="dashboard-subtitle">

                Executive overview of quotation system

            </p>

        </div>

        <div class="dashboard-date">

            <i class="fa-solid fa-calendar-days"></i>

            <?= date('d M Y'); ?>

        </div>

    </div>

    <!-- =========================================
        KPI CARDS
    ========================================== -->

    <div class="dashboard-kpi-grid">

        <!-- TOTAL QUOTES -->

        <div class="dashboard-kpi-card">

            <div class="kpi-icon blue-gradient">

                <i class="fa-solid fa-file-lines"></i>

            </div>

            <div class="kpi-content">

                <div class="kpi-label">

                    Total Quotations

                </div>

                <div class="kpi-value">

                    <?= $totalQuotes['total_quotes'] ?? 0; ?>

                </div>

            </div>

        </div>

        <!-- REVENUE -->

        <div class="dashboard-kpi-card">

            <div class="kpi-icon green-gradient">

                <i class="fa-solid fa-indian-rupee-sign"></i>

            </div>

            <div class="kpi-content">

                <div class="kpi-label">

                    Total Revenue

                </div>

                <div class="kpi-value">

                    ₹  <?= number_format(
                        $totalValue['total_value'] ?? 0,
                        0
                    ); ?>

                </div>

            </div>

        </div>

        <!-- SQFT -->

        <div class="dashboard-kpi-card">

            <div class="kpi-icon purple-gradient">

                <i class="fa-solid fa-ruler-combined"></i>

            </div>

            <div class="kpi-content">

                <div class="kpi-label">

                    Total Sq.Ft

                </div>

                <div class="kpi-value">

                    <?= number_format(
                        $totalSqft['total_sqft'] ?? 0,
                        0
                    ); ?>

                </div>

            </div>

        </div>

        <!-- AVG VALUE -->

        <div class="dashboard-kpi-card">

            <div class="kpi-icon orange-gradient">

                <i class="fa-solid fa-chart-line"></i>

            </div>

            <div class="kpi-content">

                <div class="kpi-label">

                    Avg Project Value

                </div>

                <div class="kpi-value">

                    ₹  <?=

                    ($totalQuotes['total_quotes'] ?? 0) > 0

                    ?

                    number_format(

                        $totalValue['total_value'] / max(1, $totalQuotes['total_quotes']),0


                    )

                    :

                    0;

                    ?>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================================
        PROJECT ANALYTICS
    ========================================== -->

    <div class="analytics-title">

        Project Analytics

    </div>

    <!-- =========================================
        CHART SECTION
    ========================================= -->

    <div class="dashboard-chart-grid">

        <!-- REVENUE CHART -->

        <div class="chart-card revenue-chart-card">

            <div class="chart-header">

                <div>

                    <div class="chart-title">

                        Revenue Analytics

                    </div>

                    <div class="chart-subtitle">

                        Monthly quotation revenue

                    </div>

                </div>

                <div class="chart-icon">

                    <i class="fa-solid fa-chart-line"></i>

                </div>

            </div>

            <canvas id="revenueChart"></canvas>

        </div>

        <!-- DONUT CHART -->

        <div class="chart-card">

            <div class="chart-header">

                <div>

                    <div class="chart-title">

                        Project Distribution

                    </div>

                    <div class="chart-subtitle">

                        Project type comparison

                    </div>

                </div>

                <div class="chart-icon">

                    <i class="fa-solid fa-chart-pie"></i>

                </div>

            </div>

            <canvas id="projectChart"></canvas>

        </div>

    </div>



    <div class="project-grid">

        <?php

        while($project = mysqli_fetch_assoc($projectResult)){

        ?>

        <div class="project-analytics-card">

            <!-- TOP -->

            <div class="project-card-top">

                <div>

                    <div class="project-name">

                        <?= $project['project_type']; ?>

                    </div>

                    <div class="project-desc">

                        Quotation Analytics

                    </div>

                </div>

                <div class="project-icon">

                    <i class="fa-solid fa-chart-pie"></i>

                </div>

            </div>

            <!-- BODY -->

            <div class="project-analytics-body">

                <!-- SQFT -->

                <div class="analytics-row">

                    <span>

                        Total Sq.Ft

                    </span>

                    <strong>

                        <?= number_format(
                            $project['total_sqft'] ?? 0,
                            0
                        ); ?>

                    </strong>

                </div>

                <!-- VALUE -->

                <div class="analytics-row">

                    <span>

                        Total Value

                    </span>

                    <strong>

                        ₹  <?= number_format(
                            $project['total_value'] ?? 0,
                            0
                        ); ?>

                    </strong>

                </div>

                <!-- PROJECT COUNT -->

                <div class="analytics-row">

                    <span>

                        Projects

                    </span>

                    <strong>

                        <?= $project['total_projects']; ?>

                    </strong>

                </div>

            </div>

            <!-- FOOTER -->

            <div class="project-footer-bar">

                <div
                    class="project-footer-progress"
                    style="width:<?= min(($project['total_projects'] * 20),100); ?>%;"
                ></div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php
include 'includes/footer.php';
?>