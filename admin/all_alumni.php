<?php
include("../backend/db_admin.php");
session_start();

/*
|--------------------------------------------------------------------------
| SESSION CHECK (USING role FROM DATABASE)
|--------------------------------------------------------------------------
*/
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$selected_course = $_GET['course'] ?? 'All';
$selected_year = $_GET['year'] ?? 'All';
/*
|--------------------------------------------------------------------------
| FETCH ALUMNI DATA (BASED SA REAL DB MO)
|--------------------------------------------------------------------------
*/
$query = "
SELECT
ad.alumni_id,

TRIM(CONCAT_WS(' ',
    up.first_name,
    NULLIF(up.middle_name, ''),
    up.last_name,
    NULLIF(up.suffix, '')
)) AS full_name,

c.course_code AS Programme,
ad.year_graduated AS Academic_year,
u.email AS Email,
up.contact_number AS Phone,
u.status AS Status

FROM alumnidetails ad
INNER JOIN users u ON ad.user_id = u.id
INNER JOIN userprofile up ON up.user_id = u.id
LEFT JOIN courses c ON ad.course_id = c.course_id

WHERE 
    ('$selected_course' = 'All' OR c.course_code = '$selected_course')
    AND ('$selected_year' = 'All' OR ad.year_graduated = '$selected_year')

ORDER BY ad.year_graduated DESC, c.course_code ASC, ad.alumni_id DESC
LIMIT $limit OFFSET $offset
";

$ret = mysqli_query($conn, $query);

/*
|--------------------------------------------------------------------------
| TOTAL RECORDS
|--------------------------------------------------------------------------
*/
$total_q = "
SELECT COUNT(*) AS total
FROM alumnidetails ad
LEFT JOIN courses c ON ad.course_id = c.course_id
WHERE 
    ('$selected_course' = 'All' OR c.course_code = '$selected_course')
    AND ('$selected_year' = 'All' OR ad.year_graduated = '$selected_year')
";

$total_res = mysqli_query($conn, $total_q);
$total_row = mysqli_fetch_assoc($total_res);

$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

/*
|--------------------------------------------------------------------------
| DELETE ALUMNI (SAFE)
|--------------------------------------------------------------------------
*/
if (isset($_GET['id'])) {
    $rid = intval($_GET['id']);

    $getUser = mysqli_query($conn, "SELECT user_id FROM alumnidetails WHERE alumni_id = $rid");
    $data = mysqli_fetch_assoc($getUser);
    $user_id = $data['user_id'] ?? 0;

    mysqli_query($conn, "DELETE FROM alumnidetails WHERE alumni_id = $rid");

    if ($user_id) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
    }

    header("Location: all_alumni.php?delete=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>All Alumni | Alumni Association</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>

    <style>
        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 10px;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child {
            width: 130px;
        }

        table.table td a {
            color: #a0a5b1;
            display: inline-block;
            margin: 0 5px;
        }

        table.table td a.view {
            color: #03A9F4;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #E34724;
        }

        table.table td i {
            font-size: 19px;
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <?php include('includes/navbar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <main class="app-main">

            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">All Alumni</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Alumni</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header">
                                    <div class="card-title">All alumni are shown here</div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <form method="GET" id="filterForm">
                                            <table class="table table-striped table-hover" id="table-data">
                                                <thead>
                                                    <tr class="align-middle">
                                                        <th style="width: 10px">#</th>
                                                        <th>Name</th>
                                                        <th>
                                                            Program
                                                            <div class="dropdown d-inline">
                                                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="text-decoration:none;">
                                                                </a>

                                                                <ul class="dropdown-menu">

                                                                    <li>
                                                                        <a class="dropdown-item <?= ($selected_course == 'All') ? 'active' : '' ?>"
                                                                            href="?course=All&year=<?= $selected_year ?>">
                                                                            All
                                                                        </a>
                                                                    </li>

                                                                    <?php
                                                                    $courses = mysqli_query($conn, "SELECT course_code FROM courses ORDER BY course_code ASC");

                                                                    while ($c = mysqli_fetch_assoc($courses)) {
                                                                        $code = $c['course_code'];
                                                                    ?>
                                                                        <li>
                                                                            <a class="dropdown-item <?= ($selected_course == $code) ? 'active' : '' ?>"
                                                                                href="?course=<?= urlencode($code) ?>&year=<?= $selected_year ?>">
                                                                                <?= $code ?>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>

                                                                </ul>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            Academic Year
                                                            <div class="dropdown d-inline">
                                                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="text-decoration:none;">
                                                                </a>

                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item <?= ($selected_year == 'All') ? 'active' : '' ?>"
                                                                            href="?course=<?= $selected_course ?>&year=All">
                                                                            All
                                                                        </a>
                                                                    </li>

                                                                    <?php
                                                                    $years = mysqli_query($conn, "SELECT DISTINCT year_graduated FROM alumnidetails ORDER BY year_graduated DESC");
                                                                    while ($y = mysqli_fetch_assoc($years)) {
                                                                        $val = $y['year_graduated'];
                                                                    ?>
                                                                        <li>
                                                                            <a class="dropdown-item <?= ($selected_year == $val) ? 'active' : '' ?>"
                                                                                href="?course=<?= $selected_course ?>&year=<?= $val ?>">
                                                                                <?= $val ?>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Status</th>
                                                        <th style="width: 40px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cnt = $offset + 1;
                                                    if (mysqli_num_rows($ret) > 0) {
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                    ?>
                                                            <tr class="align-middle">
                                                                <td><?= $cnt ?></td>
                                                                <td><?= $row['full_name'] ?></td>
                                                                <td><?= $row['Programme'] ?></td>
                                                                <td><?= $row['Academic_year'] ?></td>
                                                                <td><?= $row['Email'] ?></td>
                                                                <td><?= $row['Phone'] ?></td>
                                                                <td>
                                                                    <?php if ($row['Status'] == 'active') : ?>
                                                                        <span class="badge text-bg-success">Active</span>

                                                                    <?php elseif ($row['Status'] == 'pending') : ?>
                                                                        <span class="badge text-bg-warning">Pending</span>

                                                                    <?php else : ?>
                                                                        <span class="badge text-bg-danger">Inactive</span>
                                                                    <?php endif; ?>
                                                                </td>

                                                                <td>
                                                                    <a href="view_alumnus.php?id=<?= $row['alumni_id'] ?>" class="view">
                                                                        <i class="bi bi-eye-fill"></i>
                                                                    </a>

                                                                    <a href="edit_alumnus.php?id=<?= $row['alumni_id'] ?>" class="edit">
                                                                        <i class="bi bi-pencil-fill"></i>
                                                                    </a>

                                                                    <a href="all_alumni.php?delete=1&id=<?= $row['alumni_id'] ?>"
                                                                        class="delete"
                                                                        onclick="return confirm('Delete this record?');">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $cnt = $cnt + 1;
                                                        }
                                                    } else { ?>
                                                        <tr>
                                                            <th style="text-align:center; color:red;" colspan="8">No Record Found</th>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer clearfix">
                                    <form action="export_data.php" method="POST">
                                        <a href="add_alumnus.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i>&nbsp; Add New Alumnus</a>
                                        <button class="exportexcel btn btn-success" id="exportexcel" name="exportexcel" type="submit"><i class="bi bi-download"></i>&nbsp; Export Data</button>
                                        <ul class="pagination pagination-sm m-0 float-end">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item"><a class="page-link" href="?course=<?= $selected_course ?>&year=<?= $selected_year ?>&page=<?= $page - 1 ?>">&laquo; Previous</a></li>
                                            <?php endif; ?>
                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                                    <a class="page-link" href="?course=<?= $selected_course ?>&year=<?= $selected_year ?>&page=<?= $i ?>"></a>
                                                </li>
                                            <?php endfor; ?>
                                            <?php if ($page < $total_pages): ?>
                                                <li class="page-item"><a class="page-link" href="?course=<?= $selected_course ?>&year=<?= $selected_year ?>&page=<?= $page + 1 ?>">Next &raquo;</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <?php if (isset($_GET['update']) && htmlspecialchars($_GET['update']) == 'success'): ?>
                                <div class="callout callout-success">Alumnus Details updated successfully!</div>
                            <?php endif; ?>
                            <?php if (isset($_GET['delete']) && htmlspecialchars($_GET['delete']) == 'success'): ?>
                                <div class="callout callout-success">Alumnus Details deleted successfully!</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/footer.php"); ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function autoFilter() {
            document.getElementById('filterForm').submit();
        }
    </script>
    <script>
        function logout(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, log out",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../logout.php";
                }
            });
        }
    </script>
</body>

</html>