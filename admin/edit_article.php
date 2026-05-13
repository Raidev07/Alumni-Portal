<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

//  GET STORY ID
if (!isset($_GET['id'])) {
    die("Story ID missing.");
}

$story_id = (int) $_GET['id'];

// FETCH STORY
$stmt = $conn->prepare("
    SELECT *
    FROM alumnifeatured
    WHERE id = ?
    LIMIT 1
");

if (!$stmt) {
    flash("error", "Database Error", $conn->error);
    exit();
}

$stmt->bind_param("i", $story_id);

if (!$stmt->execute()) {
    flash("error", "Database Error", $stmt->error);
    exit();
}

$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    flash("error", "Not Found", "Story does not exist.");
    exit();
}

$story = $result->fetch_assoc();
$stmt->close();

// UPDATE STORY
if (isset($_POST['update_story'])) {

    $title          = trim($_POST['title']);
    $alumni_name    = trim($_POST['alumniName']);
    $year_graduated = trim($_POST['gradYear']);
    $category       = trim($_POST['category']);
    $excerpt        = trim($_POST['excerpt']);
    $content        = trim($_POST['content']);

    if (empty($title) || empty($alumni_name) || empty($year_graduated) || empty($content)) {
        flash("error", "Validation Error", "Required fields cannot be empty.");
        return;
    }

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

    $cover_image = $story['cover_image'];

    // IMAGE UPLOAD ERROR HANDLING
    if (!empty($_FILES['coverImage']['name'])) {

        if ($_FILES['coverImage']['error'] !== 0) {
            flash("error", "Upload Error", "Image upload failed.");
        } else {

            $uploadDir = "../uploads/stories/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES["coverImage"]["name"], PATHINFO_EXTENSION));
            $allowedExt = ["jpg", "jpeg", "png", "webp"];

            if (!in_array($ext, $allowedExt)) {
                flash("error", "Invalid File", "Only JPG, PNG, WEBP allowed.");
                return;
            }

            $fileName = uniqid() . "_" . basename($_FILES["coverImage"]["name"]);
            $targetFile = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES["coverImage"]["tmp_name"], $targetFile)) {
                flash("error", "Upload Failed", "Could not save image.");
                return;
            }

            $cover_image = "uploads/stories/" . $fileName;
        }
    }

    // DATABASE UPDATE
    $stmt = $conn->prepare("
        UPDATE alumnifeatured
        SET title = ?, alumni_name = ?, year_graduated = ?, category = ?, cover_image = ?, excerpt = ?, content = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        flash("error", "Database Error", $conn->error);
        return;
    }

    $stmt->bind_param(
        "sssssssi",
        $title,
        $alumni_name,
        $year_graduated,
        $category,
        $cover_image,
        $excerpt,
        $content,
        $story_id
    );

    if (!$stmt->execute()) {
        flash("error", "Update Failed", $stmt->error);
        return;
    }

    $stmt->close();

    flash("success", "Updated", "Story updated successfully!");
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story | Alumni Association</title>

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
                            <h3 class="mb-0">Edit Story</h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item">
                                    <a href="dashboard.php">Home</a>
                                </li>

                                <li class="breadcrumb-item active">
                                    Edit Story
                                </li>
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
                                    <div class="card-title">
                                        Edit Alumni Achievement Story
                                    </div>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <!-- TITLE -->
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Title
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text"
                                                name="title"
                                                class="form-control"
                                                value="<?= htmlspecialchars($story['title']) ?>"
                                                required>
                                        </div>

                                        <!-- NAME + YEAR -->
                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Alumni Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text"
                                                    name="alumniName"
                                                    class="form-control"
                                                    value="<?= htmlspecialchars($story['alumni_name']) ?>"
                                                    required>
                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Graduation Year
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number"
                                                    name="gradYear"
                                                    class="form-control"
                                                    value="<?= htmlspecialchars($story['year_graduated']) ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- CATEGORY + IMAGE -->
                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label class="form-label">
                                                    Category
                                                </label>

                                                <select name="category"
                                                    class="form-select"
                                                    required>

                                                    <option value="Science & Research"
                                                        <?= $story['category'] == 'Science & Research' ? 'selected' : '' ?>>
                                                        Science & Research
                                                    </option>

                                                    <option value="Community Impact"
                                                        <?= $story['category'] == 'Community Impact' ? 'selected' : '' ?>>
                                                        Community Impact
                                                    </option>

                                                    <option value="Arts & Culture"
                                                        <?= $story['category'] == 'Arts & Culture' ? 'selected' : '' ?>>
                                                        Arts & Culture
                                                    </option>

                                                    <option value="Business"
                                                        <?= $story['category'] == 'Business' ? 'selected' : '' ?>>
                                                        Business
                                                    </option>

                                                    <option value="Sports"
                                                        <?= $story['category'] == 'Sports' ? 'selected' : '' ?>>
                                                        Sports
                                                    </option>

                                                    <option value="Technology"
                                                        <?= $story['category'] == 'Technology' ? 'selected' : '' ?>>
                                                        Technology
                                                    </option>

                                                    <option value="Gaming"
                                                        <?= $story['category'] == 'Gaming' ? 'selected' : '' ?>>
                                                        Gaming
                                                    </option>

                                                    <option value="Food and Hospitality" <?= $story['category'] == 'Food and Hospitality' ? 'selected' : '' ?>>Food and Hospitality</option>
                                                    <option value="Other" <?= $story['category'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Cover Image Upload</label>
                                                <input type="file" name="coverImage" class="form-control" accept="image/*">
                                                <?php if (!empty($story['cover_image'])) : ?>
                                                    <div class="mt-3">
                                                        <img src="../<?= htmlspecialchars($story['cover_image']) ?>" width="220" class="img-thumbnail">
                                                    </div>

                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- EXCERPT -->
                                        <div class="mb-3">
                                            <label class="form-label">Short Excerpt</label>
                                            <textarea name="excerpt" class="form-control" rows="2"><?= htmlspecialchars($story['excerpt']) ?></textarea>
                                        </div>

                                        <!-- CONTENT -->
                                        <div class="mb-3">
                                            <label class="form-label">Full Content<span class="text-danger">*</span></label>
                                            <textarea name="content" class="form-control" rows="8" required><?= htmlspecialchars($story['content']) ?></textarea>
                                        </div>
                                    </div>

                                    <!-- FOOTER -->
                                    <div class="card-footer">
                                        <button type="submit" name="update_story" class="btn btn-primary"><i class="bi bi-save"></i>Update Story</button>
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

    <?php include("includes/flash-swal.php"); ?>
    <script src="js/write_article.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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