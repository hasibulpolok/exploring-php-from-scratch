<?php
/**
 * admin/index.php — Admin Dashboard
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/data.php';
requireAdmin();

$profile  = getProfile();
$skills   = getSkills();
$projects = getProjects();
$socials  = getSocialLinks();
$messages = getContactMessages();
$csrf     = generateCsrfToken();

$unread = array_filter($messages, fn($m) => !$m['is_read']);
$tab    = $_GET['tab'] ?? 'dashboard';

// ─── Handle POST actions ─────────────────────────────────────────
$flashMsg = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postCsrf = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($postCsrf)) {
        $flashMsg  = 'Invalid CSRF token.';
        $flashType = 'error';
    } else {
        $action = $_POST['action'] ?? '';

        // ── Update Profile ──────────────────────────────────────
        if ($action === 'update_profile') {
            $result = updateProfile([
                ':name'         => clean($_POST['name'] ?? ''),
                ':nickname'     => clean($_POST['nickname'] ?? ''),
                ':role'         => clean($_POST['role'] ?? ''),
                ':location'     => clean($_POST['location'] ?? ''),
                ':email'        => clean($_POST['email'] ?? ''),
                ':phone'        => clean($_POST['phone'] ?? ''),
                ':whatsapp'     => clean($_POST['whatsapp'] ?? ''),
                ':address'      => clean($_POST['address'] ?? ''),
                ':about'        => clean($_POST['about'] ?? ''),
                ':open_to_work' => isset($_POST['open_to_work']) ? 1 : 0,
            ]);
            $flashMsg = $result ? 'Profile updated successfully!' : 'Failed to update profile.';
            if (!$result) $flashType = 'error';
            $tab = 'profile';
        }

        // ── Upsert Skill ────────────────────────────────────────
        if ($action === 'save_skill') {
            $data = [
                ':name'     => clean($_POST['skill_name'] ?? ''),
                ':level'    => max(0, min(100, (int)($_POST['skill_level'] ?? 80))),
                ':category' => clean($_POST['skill_category'] ?? 'General'),
            ];
            if (!empty($_POST['skill_id'])) {
                $data[':id'] = (int)$_POST['skill_id'];
            }
            $result    = upsertSkill($data);
            $flashMsg  = $result ? 'Skill saved!' : 'Failed to save skill.';
            if (!$result) $flashType = 'error';
            $tab = 'skills';
        }

        // ── Delete Skill ────────────────────────────────────────
        if ($action === 'delete_skill' && !empty($_POST['skill_id'])) {
            $result    = deleteSkill((int)$_POST['skill_id']);
            $flashMsg  = $result ? 'Skill deleted.' : 'Failed to delete skill.';
            if (!$result) $flashType = 'error';
            $tab = 'skills';
        }

        // ── Upsert Project ──────────────────────────────────────
        if ($action === 'save_project') {
            $data = [
                ':title'       => clean($_POST['proj_title'] ?? ''),
                ':description' => clean($_POST['proj_desc'] ?? ''),
                ':tech_stack'  => clean($_POST['proj_tech'] ?? ''),
                ':url'         => clean($_POST['proj_url'] ?? ''),
            ];
            if (!empty($_POST['proj_id'])) {
                $data[':id'] = (int)$_POST['proj_id'];
            }
            $result    = upsertProject($data);
            $flashMsg  = $result ? 'Project saved!' : 'Failed to save project.';
            if (!$result) $flashType = 'error';
            $tab = 'projects';
        }

        // ── Delete Project ──────────────────────────────────────
        if ($action === 'delete_project' && !empty($_POST['proj_id'])) {
            $result    = deleteProject((int)$_POST['proj_id']);
            $flashMsg  = $result ? 'Project deleted.' : 'Failed to delete project.';
            if (!$result) $flashType = 'error';
            $tab = 'projects';
        }

        // ── Upsert Social ───────────────────────────────────────
        if ($action === 'save_social') {
            $data = [
                ':platform'   => clean($_POST['soc_platform'] ?? ''),
                ':url'        => clean($_POST['soc_url'] ?? ''),
                ':icon_class' => clean($_POST['soc_icon'] ?? ''),
            ];
            if (!empty($_POST['soc_id'])) {
                $data[':id'] = (int)$_POST['soc_id'];
            }
            $result    = upsertSocialLink($data);
            $flashMsg  = $result ? 'Social link saved!' : 'Failed to save social link.';
            if (!$result) $flashType = 'error';
            $tab = 'socials';
        }

        // ── Delete Social ───────────────────────────────────────
        if ($action === 'delete_social' && !empty($_POST['soc_id'])) {
            $result    = deleteSocialLink((int)$_POST['soc_id']);
            $flashMsg  = $result ? 'Social link deleted.' : 'Failed to delete.';
            if (!$result) $flashType = 'error';
            $tab = 'socials';
        }

        // ── Mark Message Read ───────────────────────────────────
        if ($action === 'mark_read' && !empty($_POST['msg_id'])) {
            markMessageRead((int)$_POST['msg_id']);
            $tab = 'messages';
        }

        // Refresh data after mutations
        $profile  = getProfile();
        $skills   = getSkills();
        $projects = getProjects();
        $socials  = getSocialLinks();
        $messages = getContactMessages();
        $unread   = array_filter($messages, fn($m) => !$m['is_read']);
        $csrf     = generateCsrfToken(); // rotate
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — <?= clean(SITE_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-layout">

    <!-- ── Sidebar ──────────────────────────────────────────── -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <div class="logo-icon"><i class="fas fa-user-shield"></i></div>
            <span>Admin Panel</span>
        </div>

        <nav class="admin-nav">
            <?php
            $navItems = [
                ['tab' => 'dashboard', 'icon' => 'fas fa-chart-bar',    'label' => 'Dashboard'],
                ['tab' => 'profile',   'icon' => 'fas fa-user',          'label' => 'Profile'],
                ['tab' => 'skills',    'icon' => 'fas fa-star',           'label' => 'Skills'],
                ['tab' => 'projects',  'icon' => 'fas fa-code',           'label' => 'Projects'],
                ['tab' => 'socials',   'icon' => 'fas fa-share-alt',      'label' => 'Social Links'],
                ['tab' => 'messages',  'icon' => 'fas fa-envelope',       'label' => 'Messages' . (!empty($unread) ? ' <span style="background:#cc1016;color:#fff;border-radius:10px;padding:1px 6px;font-size:.7rem">'.count($unread).'</span>' : '')],
            ];
            foreach ($navItems as $item):
            ?>
                <a href="?tab=<?= $item['tab'] ?>"
                   class="admin-nav-item <?= $tab === $item['tab'] ? 'active' : '' ?>">
                    <i class="<?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="../index.php" class="admin-nav-item">
                <i class="fas fa-eye"></i> View Site
            </a>
            <a href="../logout.php" class="admin-nav-item" style="color:#cc1016;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <button class="admin-nav-item" onclick="toggleTheme()" style="color:inherit;">
                <i class="fas fa-moon" id="adminThemeIcon"></i> Dark Mode
            </button>
        </div>
    </aside>

    <!-- ── Main Content ─────────────────────────────────────── -->
    <main class="admin-main">

        <!-- Flash Message -->
        <?php if ($flashMsg): ?>
            <div class="alert alert-<?= $flashType === 'error' ? 'error' : 'success' ?>"
                 id="flashAlert">
                <i class="fas fa-<?= $flashType === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
                <?= clean($flashMsg) ?>
            </div>
            <script>setTimeout(() => {
                const el = document.getElementById('flashAlert');
                if (el) el.style.transition='opacity .5s', el.style.opacity=0, setTimeout(()=>el.remove(),500);
            }, 4000);</script>
        <?php endif; ?>

        <!-- ── DASHBOARD ────────────────────────────────────── -->
        <?php if ($tab === 'dashboard'): ?>
            <div class="admin-topbar">
                <h1>Dashboard</h1>
                <span style="font-size:.85rem;color:var(--text-muted)">
                    Welcome back, <strong><?= clean($_SESSION['admin_user'] ?? 'Admin') ?></strong>
                </span>
            </div>

            <div class="admin-stats">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon blue"><i class="fas fa-star"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($skills) ?></div>
                        <div class="admin-stat-label">Skills</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon green"><i class="fas fa-code"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($projects) ?></div>
                        <div class="admin-stat-label">Projects</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon orange"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($messages) ?></div>
                        <div class="admin-stat-label">Messages</div>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon purple"><i class="fas fa-share-alt"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($socials) ?></div>
                        <div class="admin-stat-label">Social Links</div>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <h2><i class="fas fa-user"></i> Profile Summary</h2>
                <p><strong><?= clean($profile['name'] ?? '') ?></strong>
                   — <?= clean($profile['role'] ?? '') ?></p>
                <p style="color:var(--text-muted);font-size:.88rem;margin-top:6px">
                    <?= clean($profile['location'] ?? '') ?>
                </p>
                <div style="margin-top:12px">
                    <a href="?tab=profile" class="btn btn-sm btn-outline">Edit Profile</a>
                </div>
            </div>

            <?php if (!empty($unread)): ?>
            <div class="admin-card">
                <h2><i class="fas fa-envelope"></i> Unread Messages (<?= count($unread) ?>)</h2>
                <table class="messages-table">
                    <tr><th>From</th><th>Subject</th><th>Date</th></tr>
                    <?php foreach (array_slice($unread, 0, 5) as $msg): ?>
                        <tr class="unread">
                            <td><?= clean($msg['sender_name']) ?></td>
                            <td><?= clean($msg['subject']) ?></td>
                            <td><?= date('M j, Y', strtotime($msg['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div style="margin-top:12px">
                    <a href="?tab=messages" class="btn btn-sm btn-outline">View All</a>
                </div>
            </div>
            <?php endif; ?>

        <!-- ── PROFILE ───────────────────────────────────────── -->
        <?php elseif ($tab === 'profile'): ?>
            <div class="admin-topbar"><h1>Edit Profile</h1></div>
            <div class="admin-card">
                <h2><i class="fas fa-user-edit"></i> Profile Information</h2>
                <form method="POST" action="?tab=profile" class="admin-form" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <input type="hidden" name="action"     value="update_profile">

                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" value="<?= clean($profile['name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nickname</label>
                            <input type="text" name="nickname" value="<?= clean($profile['nickname'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Role / Title *</label>
                        <input type="text" name="role" value="<?= clean($profile['role'] ?? '') ?>" required>
                    </div>

                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= clean($profile['email'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?= clean($profile['phone'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" value="<?= clean($profile['location'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp Number (digits only)</label>
                            <input type="text" name="whatsapp" value="<?= clean($profile['whatsapp'] ?? '') ?>"
                                   placeholder="8801XXXXXXXXX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?= clean($profile['address'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label>About</label>
                        <textarea name="about" rows="5"><?= clean($profile['about'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="open_to_work"
                                   <?= !empty($profile['open_to_work']) ? 'checked' : '' ?>>
                            Open to Work
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Profile
                    </button>
                </form>
            </div>

        <!-- ── SKILLS ────────────────────────────────────────── -->
        <?php elseif ($tab === 'skills'): ?>
            <div class="admin-topbar"><h1>Manage Skills</h1></div>

            <div class="admin-card">
                <h2><i class="fas fa-plus-circle"></i> Add / Edit Skill</h2>
                <form method="POST" action="?tab=skills" class="admin-form" id="skillForm">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <input type="hidden" name="action"     value="save_skill">
                    <input type="hidden" name="skill_id"   id="skillIdField" value="">

                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Skill Name *</label>
                            <input type="text" name="skill_name" id="skillNameField" placeholder="e.g. ReactJS" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="skill_category" id="skillCatField" placeholder="Frontend" value="Frontend">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Level (0–100): <span id="skillLevelDisplay">80</span>%</label>
                        <input type="range" name="skill_level" id="skillLevelField" min="0" max="100" value="80"
                               oninput="document.getElementById('skillLevelDisplay').textContent=this.value"
                               style="width:100%;accent-color:var(--primary)">
                    </div>
                    <div style="display:flex;gap:10px">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save Skill
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="resetSkillForm()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h2><i class="fas fa-list"></i> Existing Skills</h2>
                <div class="admin-list">
                    <?php foreach ($skills as $sk): ?>
                        <div class="admin-list-item">
                            <div class="item-name"><?= clean($sk['name']) ?></div>
                            <div class="item-meta"><?= clean($sk['category']) ?> — <?= $sk['level'] ?>%</div>
                            <div class="skill-bar" style="width:100px;margin:0 8px">
                                <div class="skill-fill" style="width:<?= $sk['level'] ?>%"></div>
                            </div>
                            <button class="btn-edit"
                                onclick="editSkill(<?= $sk['id'] ?>, '<?= addslashes(clean($sk['name'])) ?>', <?= $sk['level'] ?>, '<?= addslashes(clean($sk['category'])) ?>')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <form method="POST" action="?tab=skills" style="display:inline"
                                  onsubmit="return confirm('Delete this skill?')">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="action"   value="delete_skill">
                                <input type="hidden" name="skill_id" value="<?= $sk['id'] ?>">
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <!-- ── PROJECTS ──────────────────────────────────────── -->
        <?php elseif ($tab === 'projects'): ?>
            <div class="admin-topbar"><h1>Manage Projects</h1></div>

            <div class="admin-card">
                <h2><i class="fas fa-plus-circle"></i> Add / Edit Project</h2>
                <form method="POST" action="?tab=projects" class="admin-form" id="projForm">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <input type="hidden" name="action"  value="save_project">
                    <input type="hidden" name="proj_id" id="projIdField" value="">

                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="proj_title" id="projTitleField" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="proj_desc" id="projDescField" rows="3"></textarea>
                    </div>
                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Tech Stack (comma-separated)</label>
                            <input type="text" name="proj_tech" id="projTechField" placeholder="ReactJS, PHP, MySQL">
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" name="proj_url" id="projUrlField" placeholder="https://...">
                        </div>
                    </div>
                    <div style="display:flex;gap:10px">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save Project
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="resetProjForm()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h2><i class="fas fa-list"></i> Existing Projects</h2>
                <div class="admin-list">
                    <?php foreach ($projects as $pr): ?>
                        <div class="admin-list-item">
                            <div>
                                <div class="item-name"><?= clean($pr['title']) ?></div>
                                <div class="item-meta"><?= clean($pr['tech_stack'] ?? '') ?></div>
                            </div>
                            <button class="btn-edit"
                                onclick="editProj(<?= $pr['id'] ?>, '<?= addslashes(clean($pr['title'])) ?>', '<?= addslashes(clean($pr['description'] ?? '')) ?>', '<?= addslashes(clean($pr['tech_stack'] ?? '')) ?>', '<?= addslashes(clean($pr['url'] ?? '')) ?>')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <form method="POST" action="?tab=projects" style="display:inline"
                                  onsubmit="return confirm('Delete this project?')">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="action"  value="delete_project">
                                <input type="hidden" name="proj_id" value="<?= $pr['id'] ?>">
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <!-- ── SOCIALS ───────────────────────────────────────── -->
        <?php elseif ($tab === 'socials'): ?>
            <div class="admin-topbar"><h1>Social Links</h1></div>

            <div class="admin-card">
                <h2><i class="fas fa-plus-circle"></i> Add / Edit Social Link</h2>
                <form method="POST" action="?tab=socials" class="admin-form" id="socForm">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <input type="hidden" name="action" value="save_social">
                    <input type="hidden" name="soc_id" id="socIdField" value="">

                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Platform</label>
                            <input type="text" name="soc_platform" id="socPlatField" placeholder="YouTube">
                        </div>
                        <div class="form-group">
                            <label>Font Awesome Icon Class</label>
                            <input type="text" name="soc_icon" id="socIconField" placeholder="fab fa-youtube">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <input type="url" name="soc_url" id="socUrlField" placeholder="https://...">
                    </div>
                    <div style="display:flex;gap:10px">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="resetSocForm()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <div class="admin-card">
                <h2><i class="fas fa-list"></i> Existing Links</h2>
                <div class="admin-list">
                    <?php foreach ($socials as $soc): ?>
                        <div class="admin-list-item">
                            <i class="<?= clean($soc['icon_class']) ?>" style="font-size:1.3rem;color:var(--primary);width:24px"></i>
                            <div>
                                <div class="item-name"><?= clean($soc['platform']) ?></div>
                                <div class="item-meta"><?= clean($soc['url']) ?></div>
                            </div>
                            <button class="btn-edit"
                                onclick="editSoc(<?= $soc['id'] ?>, '<?= addslashes(clean($soc['platform'])) ?>', '<?= addslashes(clean($soc['url'])) ?>', '<?= addslashes(clean($soc['icon_class'])) ?>')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <form method="POST" action="?tab=socials" style="display:inline"
                                  onsubmit="return confirm('Delete this link?')">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                <input type="hidden" name="action" value="delete_social">
                                <input type="hidden" name="soc_id" value="<?= $soc['id'] ?>">
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <!-- ── MESSAGES ──────────────────────────────────────── -->
        <?php elseif ($tab === 'messages'): ?>
            <div class="admin-topbar">
                <h1>Contact Messages</h1>
                <span style="color:var(--text-muted);font-size:.85rem">
                    <?= count($unread) ?> unread / <?= count($messages) ?> total
                </span>
            </div>

            <div class="admin-card">
                <h2><i class="fas fa-inbox"></i> All Messages</h2>
                <?php if (empty($messages)): ?>
                    <p style="color:var(--text-muted);text-align:center;padding:24px">No messages yet.</p>
                <?php else: ?>
                    <div style="overflow-x:auto">
                        <table class="messages-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $msg): ?>
                                    <tr class="<?= !$msg['is_read'] ? 'unread' : '' ?>">
                                        <td><?= clean($msg['sender_name']) ?></td>
                                        <td><a href="mailto:<?= clean($msg['sender_email']) ?>"><?= clean($msg['sender_email']) ?></a></td>
                                        <td><?= clean($msg['subject']) ?></td>
                                        <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"
                                            title="<?= clean($msg['message']) ?>">
                                            <?= clean(mb_substr($msg['message'], 0, 60)) ?>…
                                        </td>
                                        <td style="white-space:nowrap"><?= date('M j, Y H:i', strtotime($msg['created_at'])) ?></td>
                                        <td>
                                            <?php if (!$msg['is_read']): ?>
                                                <form method="POST" action="?tab=messages" style="display:inline">
                                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                                                    <input type="hidden" name="action" value="mark_read">
                                                    <input type="hidden" name="msg_id" value="<?= $msg['id'] ?>">
                                                    <button type="submit" class="btn-edit" title="Mark as read">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span style="color:var(--success);font-size:.78rem">
                                                    <i class="fas fa-check-double"></i> Read
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </main>
</div>

<script>
// Dark mode
const html = document.documentElement;
const saved = localStorage.getItem('portfolio-theme') || 'light';
html.setAttribute('data-theme', saved);
document.getElementById('adminThemeIcon').className = saved === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

function toggleTheme() {
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('portfolio-theme', next);
    document.getElementById('adminThemeIcon').className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

// Skill form helpers
function editSkill(id, name, level, cat) {
    document.getElementById('skillIdField').value    = id;
    document.getElementById('skillNameField').value  = name;
    document.getElementById('skillLevelField').value = level;
    document.getElementById('skillCatField').value   = cat;
    document.getElementById('skillLevelDisplay').textContent = level;
    document.getElementById('skillForm').scrollIntoView({ behavior: 'smooth' });
}
function resetSkillForm() {
    document.getElementById('skillIdField').value    = '';
    document.getElementById('skillNameField').value  = '';
    document.getElementById('skillLevelField').value = 80;
    document.getElementById('skillCatField').value   = 'Frontend';
    document.getElementById('skillLevelDisplay').textContent = '80';
}

// Project form helpers
function editProj(id, title, desc, tech, url) {
    document.getElementById('projIdField').value    = id;
    document.getElementById('projTitleField').value = title;
    document.getElementById('projDescField').value  = desc;
    document.getElementById('projTechField').value  = tech;
    document.getElementById('projUrlField').value   = url;
    document.getElementById('projForm').scrollIntoView({ behavior: 'smooth' });
}
function resetProjForm() {
    ['projIdField','projTitleField','projDescField','projTechField','projUrlField']
        .forEach(id => document.getElementById(id).value = '');
}

// Social form helpers
function editSoc(id, platform, url, icon) {
    document.getElementById('socIdField').value    = id;
    document.getElementById('socPlatField').value  = platform;
    document.getElementById('socUrlField').value   = url;
    document.getElementById('socIconField').value  = icon;
    document.getElementById('socForm').scrollIntoView({ behavior: 'smooth' });
}
function resetSocForm() {
    ['socIdField','socPlatField','socUrlField','socIconField']
        .forEach(id => document.getElementById(id).value = '');
}
</script>
</body>
</html>
