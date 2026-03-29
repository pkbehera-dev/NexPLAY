<?php 
require_once dirname(__DIR__) . '/config/init.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /NexPLAY/");
    exit();
}
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'ban') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'banned', blocked_until = NULL WHERE id = ? AND role != 'admin'");
        $stmt->execute([$uid]);
    } elseif ($action === 'unban') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'active', blocked_until = NULL WHERE id = ?");
        $stmt->execute([$uid]);
    } elseif ($action === 'block') {
        $duration = (int)$_POST['duration']; // in hours
        $until = (new DateTime())->modify("+$duration hours")->format('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE users SET status = 'blocked', blocked_until = ? WHERE id = ? AND role != 'admin'");
        $stmt->execute([$until, $uid]);
    }
    
    $_SESSION['msg'] = "User ID #$uid status updated successfully.";
    header("Location: manage_users.php");
    exit();
}

$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();

include 'includes/head_admin.php'; 
include 'includes/nav_admin.php'; 
?>

<main class="container py-5" id="main-content" tabindex="-1">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h1 class="h2 fw-bold text-dark">User Management</h1>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm" aria-label="Return to Dashboard"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <!-- Toast notifications handle msg -->

    <div class="admin-card p-0 overflow-hidden shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover m-0 bg-white" aria-label="Registered Platform Users">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="py-3 px-3">User ID</th>
                        <th scope="col" class="py-3">Username</th>
                        <th scope="col" class="py-3">Email Address</th>
                        <th scope="col" class="py-3">Role</th>
                        <th scope="col" class="py-3">Status</th>
                        <th scope="col" class="py-3">Blocked Until</th>
                        <th scope="col" class="text-end py-3 px-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="align-middle border-top-0">
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="px-3 fw-bold text-muted">#<?php echo $u['id']; ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($u['email']); ?>"><?php echo htmlspecialchars($u['email']); ?></a></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span class="badge bg-dark border border-dark rounded-pill">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-light text-dark border rounded-pill">User</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($u['status'] === 'active'): ?>
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold"><i class="bi bi-check-lg" aria-hidden="true"></i> Active</span>
                            <?php elseif($u['status'] === 'blocked'): ?>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold"><i class="bi bi-pause-circle" aria-hidden="true"></i> Blocked</span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold"><i class="bi bi-slash-circle" aria-hidden="true"></i> Banned</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?php echo $u['blocked_until'] ? htmlspecialchars($u['blocked_until']) : 'N/A'; ?></td>
                        <td class="px-3 text-end">
                            <?php if($u['role'] !== 'admin'): ?>
                                <form action="manage_users.php" method="POST" class="d-flex gap-2 justify-content-end align-items-center m-0">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <?php if($u['status'] === 'banned' || $u['status'] === 'blocked'): ?>
                                        <button type="submit" name="action" value="unban" class="btn btn-sm btn-success fw-bold shadow-sm" aria-label="Restore user access">Restore Access</button>
                                    <?php else: ?>
                                        <div class="input-group input-group-sm" style="width: 140px;">
                                            <input type="number" name="duration" class="form-control" placeholder="Hours" value="24" min="1" aria-label="Block duration in hours" required>
                                            <button type="submit" name="action" value="block" class="btn btn-warning fw-bold border-dark shadow-sm">Block</button>
                                        </div>
                                        <button type="submit" name="action" value="ban" class="btn btn-sm btn-danger fw-bold shadow-sm" aria-label="Ban user permanently">Ban</button>
                                    <?php endif; ?>
                                </form>
                            <?php else: ?>
                                <span class="text-muted small fw-bold">System Protected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

</div> <!-- End admin-content-wrapper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
