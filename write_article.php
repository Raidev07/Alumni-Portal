<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" href="assets/image/alumni-logo.png">
<title>Create A Story</title>
<meta name="description" content="Submit a new alumni achievement or milestone."/>
<link rel="stylesheet" href="assets/css/write_article.css"/>
</head>
<body>

<section class="block">
  <div class="container form-wrap">
    <div class="page-head">
      <p class="section-eyebrow">Share an achievement</p>
      <h1>Write a New Story</h1>
      <p>Tell us about an alumni milestone — a promotion, award, breakthrough, or any moment worth celebrating.</p>
    </div>

    <form id="new-article-form" class="form">
      <div class="field">
        <label for="title">Article title *</label>
        <input id="title" name="title" placeholder="A breakthrough on the path to..." required/>
      </div>
      <div class="row">
        <div class="field"><label for="alumniName">Alumni name *</label><input id="alumniName" name="alumniName" placeholder="e.g. Maria Santos" required/></div>
        <div class="field"><label for="gradYear">Graduation year *</label><input id="gradYear" name="gradYear" placeholder="2015" inputmode="numeric" required/></div>
      </div>
      <div class="row">
        <div class="field"><label for="category">Category</label><select id="category" name="category"></select></div>
        <div class="field"><label for="coverImage">Cover image URL</label><input id="coverImage" name="coverImage" placeholder="https://..."/></div>
      </div>
      <div class="field"><label for="excerpt">Short excerpt</label><textarea id="excerpt" name="excerpt" rows="2" placeholder="A one-line summary that pulls readers in."></textarea></div>
      <div class="field"><label for="content">Full article *</label><textarea id="content" name="content" rows="10" placeholder="Tell the whole story. Use blank lines to separate paragraphs." required></textarea></div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Publish story</button>
        <a class="btn btn-outline" href="articles.html">Cancel</a>
      </div>
    </form>
  </div>
</section>

<script src="assets/js/write_article.js"></script>
</body>
</html>
