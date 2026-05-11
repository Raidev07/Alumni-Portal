<?php
include("../backend/db_admin.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/*
|-------------------------------------------------------
| GET ALUMNI ID (FROM URL)
|-------------------------------------------------------
*/
$alumni_user_id = null;
$alumni_id = null;

if (isset($_GET['id'])) {
    $alumni_id = (int) $_GET['id'];

    $stmt = $conn->prepare("
        SELECT user_id 
        FROM alumnidetails 
        WHERE alumni_id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $alumni_user_id = $row['user_id'];
    }

    $stmt->close();
}

if (!$alumni_user_id) {
    die("Invalid alumni selected.");
}

/*
|-------------------------------------------------------
| PREFILL DATA
|-------------------------------------------------------
*/
$prefill_name = "";
$prefill_year = "";

if ($alumni_id) {

    $stmt = $conn->prepare("
        SELECT 
            p.first_name,
            p.middle_name,
            p.last_name,
            p.suffix,
            a.year_graduated
        FROM alumnidetails a
        INNER JOIN userprofile p ON p.user_id = a.user_id
        WHERE a.alumni_id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {

        $suffix = !empty($row['suffix']) ? ' ' . $row['suffix'] : '';

        $prefill_name =
            $row['first_name'] . ' ' .
            $row['middle_name'] . ' ' .
            $row['last_name'] .
            $suffix;

        $prefill_year = $row['year_graduated'];
    }

    $stmt->close();
}

/*
|-------------------------------------------------------
| INSERT STORY
|-------------------------------------------------------
*/
if (isset($_POST['publish_story'])) {

    $title           = trim($_POST['title']);
    $alumni_name     = trim($_POST['alumniName']);
    $year_graduated  = date('Y', strtotime($_POST['gradYear'] . '-01-01'));
    $category        = trim($_POST['category']);
    $excerpt         = trim($_POST['excerpt']);
    $content         = trim($_POST['content']);

    $allowedCategories = [
        "Science & Research",
        "Community Impact",
        "Arts & Culture",
        "Business",
        "Sports",
        "Technology",
        "Gaming",
        "Food and Hospitality",
        "Other"
    ];

    if (!in_array($category, $allowedCategories)) {
        $category = "Other";
    }

    /*
    | IMAGE UPLOAD
    */
    $cover_image = null;

    if (!empty($_FILES['coverImage']['name']) && $_FILES['coverImage']['error'] === 0) {

        $uploadDir = "../uploads/stories/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . "_" . basename($_FILES["coverImage"]["name"]);
        $targetFile = $uploadDir . $fileName;

        $allowedExt = ["jpg", "jpeg", "png", "webp"];
        $ext = strtolower(pathinfo($_FILES["coverImage"]["name"], PATHINFO_EXTENSION));

        if (in_array($ext, $allowedExt)) {
            if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $targetFile)) {
                $cover_image = "uploads/stories/" . $fileName;
            }
        }
    }

    /*
    | INSERT
    */
    if (empty($title) || empty($alumni_name) || empty($year_graduated) || empty($content)) {
        $error = "Please fill in required fields.";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO alumnifeatured
            (title, alumni_name, year_graduated, category, cover_image, excerpt, content, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssssi",
            $title,
            $alumni_name,
            $year_graduated,
            $category,
            $cover_image,
            $excerpt,
            $content,
            $alumni_user_id
        );

        if ($stmt->execute()) {
            header("Location: dashboard.php?story=success");
            exit();
        } else {
            $error = "Failed to publish story.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Story | Alumni Association</title>

    <link rel="icon" href="../assets/image/alumni_plp_newicon.png">

    <?php include('includes/global_styles.php'); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php
        include('includes/navbar.php');
        include('includes/sidebar.php');
        ?>

        <main class="app-main">

            <!-- HEADER -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Create A Story</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Stories</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="app-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card card-primary card-outline">

                                <div class="card-header">
                                    <div class="card-title">Write Alumni Achievement Story</div>
                                </div>

                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger m-3"><?= $error ?></div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                        <div class="mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Alumni Name <span class="text-danger">*</span></label>
                                                <input type="text" name="alumniName" class="form-control" value="<?= htmlspecialchars($prefill_name) ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Graduation Year <span class="text-danger">*</span></label>
                                                <input type="number" name="gradYear" class="form-control" value="<?= htmlspecialchars($prefill_year) ?>" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Category</label>
                                                <select name="category" class="form-select" required>
                                                    <option value="">Select Category</option>
                                                    <option value="Science & Research">Science & Research</option>
                                                    <option value="Community Impact">Community Impact</option>
                                                    <option value="Arts & Culture">Arts & Culture</option>
                                                    <option value="Business">Business</option>
                                                    <option value="Sports">Sports</option>
                                                    <option value="Technology">Technology</option>
                                                    <option value="Gaming">Gaming</option>
                                                    <option value="Food and Hospitality">Food and Hospitality</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Cover Image Upload</label>
                                                <input type="file" name="coverImage" class="form-control" accept="image/*">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Short Excerpt</label>
                                            <textarea name="excerpt" class="form-control" rows="2"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Full Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="form-control" rows="8" required></textarea>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" name="publish_story" class="btn btn-primary"><i class="bi bi-send"></i> Publish</button>

                                        <a href="dashboard.php" class="btn btn-secondary float-end">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/footer.php"); ?>

    </div>

    <script src="js/write_article.js"></script>
</body>

</html>