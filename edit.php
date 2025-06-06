<?php
require 'db.php';
$id  = $_GET['id'] ?? 0;
$emp = $conn->query("SELECT * FROM employees WHERE id=$id")->fetch_assoc();
if (!$emp) {
    die('Employee not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $salary = $_POST['salary'];
    $photo  = $emp['photo'];

    
if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    if ($photo && file_exists(__DIR__ . '/uploads/' . $photo)) {
        unlink(__DIR__ . '/uploads/' . $photo);
    }

    $ext   = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photo = uniqid('emp_', true) . '.' . $ext;
    $target = __DIR__ . '/uploads/' . $photo;

    if (!is_dir(__DIR__ . '/uploads')) {
        mkdir(__DIR__ . '/uploads', 0775, true);
    }

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        die('Failed to upload new photo.');
    }
}


    $stmt = $conn->prepare("UPDATE employees SET name=?, email=?, salary=?, photo=? WHERE id=?");
    $stmt->bind_param('ssdsi', $name, $email, $salary, $photo, $id);
    $stmt->execute();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Edit Minion – Payroll Pixie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container py-5">
      <div class="card shadow">
        <div class="card-body">
          <h2 class="mb-4">Edit Minion</h2>
          <form method="post" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" name="name" value="<?= htmlspecialchars($emp['name']); ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($emp['email']); ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Salary (₱)</label>
              <input type="number" step="0.01" name="salary" value="<?= htmlspecialchars($emp['salary']); ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Photo (optional)</label>
              <?php if ($emp['photo']): ?>
                <img src="uploads/<?= htmlspecialchars($emp['photo']); ?>" width="60" height="60" class="d-block rounded-circle my-1 object-fit-cover">
              <?php endif; ?>
              <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <div class="col-12">
              <button class="btn btn-primary">Update</button>
              <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
