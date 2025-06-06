<?php
require 'db.php';
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Payroll Cast– Employee Cash Dispatcher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f4f7fc;
      }
      h1 small {
        font-size: 16px;
        display: block;
        margin-top: 4px;
        color: #6c757d;
      }
      .object-fit-cover {
        object-fit: cover;
      }
    </style>
  </head>
  <body>
    <div class="container py-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Payroll Cast<small>Employee Cash Dispatcher</small></h1>
        <a href="add.php" class="btn btn-success">➕ Hire & Pay</a>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
          <thead class="table-dark">
            <tr><th>#</th><th>Photo</th><th>Name</th><th>Email</th><th>Salary (₱)</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id']; ?></td>
                <td>
                  <?php if ($row['photo']): ?>
                    <img src="uploads/<?= htmlspecialchars($row['photo']); ?>" width="60" height="60" class="rounded-circle object-fit-cover">
                  <?php else: ?>
                    <span class="text-muted">No Image</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= number_format($row['salary'], 2); ?></td>
                <td>
                  <div class="btn-group">
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">✏️</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Fire this minion?');">🗑️</a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
