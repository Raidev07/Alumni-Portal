<?php
include("../backend/db_admin.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

/*
|-------------------------------------------------------
| GET STORY ID
|-------------------------------------------------------
*/
if (!isset($_GET['id'])) {
    die("Story ID missing.");
}

$story_id = (int) $_GET['id'];

/*
|-------------------------------------------------------
| FETCH STORY
|-------------------------------------------------------
*/
$stmt = $conn->prepare("
    SELECT *
    FROM alumnifeatured
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param("i", $story_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Story not found.");
}

$story = $result->fetch_assoc();
$stmt->close();

/*
|-------------------------------------------------------
| UPDATE STORY
|-------------------------------------------------------
*/
if (isset($_POST['update_story'])) {

    $title           = trim($_POST['title']);
    $alumni_name     = trim($_POST['alumniName']);
    $year_graduated  = trim($_POST['gradYear']);
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
    | KEEP OLD IMAGE
    */
    $cover_image = $story['cover_image'];

    /*
    | NEW IMAGE UPLOAD
    */
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
    | UPDATE DATABASE
    */
    $stmt = $conn->prepare("
        UPDATE alumnifeatured
        SET
            title = ?,
            alumni_name = ?,
            year_graduated = ?,
            category = ?,
            cover_image = ?,
            excerpt = ?,
            content = ?
        WHERE id = ?
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
        $story_id
    );

    if ($stmt->execute()) {

        header("Location: dashboard.php?update=success");
        exit();
    } else {

        $error = "Failed to update story.";
    }

    $stmt->close();
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

                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger m-3">
                                        <?= $error ?>
                                    </div>
                                <?php endif; ?>

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

                                                    <option value="Food and Hospitality"<?= $story['category'] == 'Food and Hospitality' ? 'selected' : '' ?>>Food and Hospitality</option>
                                                    <option value="Other"<?= $story['category'] == 'Other' ? 'selected' : '' ?>>Other</option>
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

</body>

</html>